<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Tiket;
use App\Models\TiketKomentar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TiketController extends Controller
{
    /**
     * Menampilkan semua tiket dengan filter opsional
     * Untuk web view (bukan API)
     */

    public function index(Request $request)
    {
        $query = Tiket::with(['user', 'kategori', 'prioritas', 'status'])
            ->where('user_id', Auth::id());

        // Hanya tampilkan tiket yang BELUM selesai dan BELUM ditolak
        $query->whereHas('status', function ($q) {
            $q->whereNotIn('nama_status', ['Selesai', 'Ditolak']);
        });
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('prioritas_id')) {
            $query->where('prioritas_id', $request->prioritas_id);
        }

        $query->orderByRaw("
    CASE
        WHEN prioritas_id = 1 THEN 1
        WHEN prioritas_id = 2 THEN 2
        WHEN prioritas_id = 3 THEN 3
        ELSE 4
    END
")
            ->latest()                     // ini yang utama: updated_at terbaru di atas
            ->orderByDesc('waktu_dibuat'); // fallback

        $tikets = $query->get();

        $statuses  = \App\Models\TiketStatus::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();

        $stats = [
            'total'    => Tiket::where('user_id', Auth::id())->count(),
            'selesai'  => Tiket::where('user_id', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))
                ->count(),
            'ditolak'  => Tiket::where('user_id', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Ditolak'))
                ->count(),
            'diproses' => Tiket::where('user_id', Auth::id())
                ->whereHas('status', fn($q) => $q->whereIn('nama_status', ['Diproses']))
                ->count(),
        ];

        $kategoriStats = Tiket::where('user_id', Auth::id())
            ->selectRaw('kategori_id, count(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        return view('tiket.index', compact('tikets', 'statuses', 'kategoris', 'prioritas', 'stats', 'kategoriStats'));
    }

    public function adminIndex()
    {
        $tikets = Tiket::with(['status', 'kategori', 'prioritas', 'user', 'assignedTo'])
            ->latest()
            ->orderByDesc('tiket_id') // tiket yang baru diupdate muncul paling atas
            ->get();

        return view('admin.tiket.index', compact('tikets'));
    }

    public function create()
    {
        // 🔹 Cek role - Admin vs User
        if (Auth::user()->role === 'admin') {
            // Admin bisa akses semua field
            $kategoris  = \App\Models\Kategori::all();
            $prioritas  = \App\Models\Prioritas::all();
            $statuses   = \App\Models\TiketStatus::all();
            $users      = \App\Models\User::all();
            $timTeknisi = User::where('role', 'tim_teknisi')->get();
            $timKonten  = User::where('role', 'tim_konten')->get();

            return view('admin.tiket.create', compact('kategoris', 'prioritas', 'statuses', 'users', 'timTeknisi', 'timKonten'));
        }

        // 🔹 User biasa - hanya ambil  kategori
        $kategoris = \App\Models\Kategori::all();

        return view('tiket.create', compact('kategoris'));
    }

        /**
     * Menyimpan tiket baru (Web + API Flutter)
     */
        /**
     * Menyimpan tiket baru (Web + API Flutter)
     */
    public function store(Request $request)
    {
        // ================== BAGIAN API FLUTTER ==================
        if ($request->wantsJson() || $request->is('api/*')) {
            $request->validate([
                'kategori_id' => 'required|exists:kategoris,kategori_id',
                'judul'       => 'required|string|max:255',
                'deskripsi'   => 'nullable|string',
            ]);

            // Generate kode tiket
            $today      = Carbon::now()->format('Ymd');
            $countToday = Tiket::whereDate('waktu_dibuat', Carbon::today())->count() + 1;
            $kodeTiket  = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

            while (Tiket::where('kode_tiket', $kodeTiket)->exists()) {
                $countToday++;
                $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
            }

            $statusBaru = \App\Models\TiketStatus::whereIn('nama_status', ['Pending', 'Baru'])->first();
            $prioritasDefault = \App\Models\Prioritas::where('nama_prioritas', 'Medium')
                ->orWhere('nama_prioritas', 'Low')
                ->first();

            $tiket = Tiket::create([
                'user_id'      => Auth::id(),
                'kategori_id'  => $request->kategori_id,
                'status_id'    => $statusBaru ? $statusBaru->status_id : 1,
                'prioritas_id' => $prioritasDefault ? $prioritasDefault->prioritas_id : 3,
                'judul'        => $request->judul,
                'deskripsi'    => $request->deskripsi ?? null,
                'kode_tiket'   => $kodeTiket,
                'waktu_dibuat' => now(),
            ]);

            $tiket->load(['kategori', 'status']);

            // Notifikasi ke Admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'     => $admin->user_id,
                    'tiket_id'    => $tiket->tiket_id,
                    'pesan'       => "Tiket baru #{$tiket->kode_tiket} telah dibuat oleh user",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil dibuat dengan kode: ' . $kodeTiket,
                'tiket'   => $tiket
            ], 201);
        }

        // ================== BAGIAN WEB (Blade) ==================
        // Kode web kamu tetap sama seperti sebelumnya
        if (Auth::user()->role === 'admin') {
            $request->validate([
                'user_id'      => 'required|exists:users,user_id',
                'kategori_id'  => 'required|exists:kategoris,kategori_id',
                'status_id'    => 'required|exists:tiket_statuses,status_id',
                'prioritas_id' => 'required|exists:priorities,prioritas_id',
                'judul'        => 'required|string|max:255',
                'deskripsi'    => 'nullable|string',
                'assigned_to'  => 'nullable|exists:users,user_id',
            ]);
        } else {
            $request->validate([
                'kategori_id' => 'required|exists:kategoris,kategori_id',
                'judul'       => 'required|string|max:255',
                'deskripsi'   => 'nullable|string',
            ]);
        }

        // Generate kode tiket
        $today      = Carbon::now()->format('Ymd');
        $countToday = Tiket::whereDate('waktu_dibuat', Carbon::today())->count() + 1;
        $kodeTiket  = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        while (Tiket::where('kode_tiket', $kodeTiket)->exists()) {
            $countToday++;
            $kodeTiket = 'TCK-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
        }

        if (Auth::user()->role !== 'admin') {
            $statusBaru = \App\Models\TiketStatus::where('nama_status', 'Baru')->first();
            $prioritasDefault = \App\Models\Prioritas::where('nama_prioritas', 'Medium')
                ->orWhere('nama_prioritas', 'Low')
                ->first();

            $request->merge([
                'user_id'      => Auth::id(),
                'status_id'    => $statusBaru ? $statusBaru->status_id : 1,
                'prioritas_id' => $prioritasDefault ? $prioritasDefault->prioritas_id : 2,
            ]);
        }

        $tiket = Tiket::create([
            'user_id'      => $request->user_id ?? Auth::id(),
            'kategori_id'  => $request->kategori_id,
            'status_id'    => $request->status_id,
            'prioritas_id' => $request->prioritas_id,
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'kode_tiket'   => $kodeTiket,
            'assigned_to'  => $request->assigned_to ?? null,
            'waktu_dibuat' => now(),
        ]);

        $tiket->load(['user', 'kategori', 'prioritas', 'status', 'assignedTo']);

        // Notifikasi web
        if (Auth::user()->role !== 'admin') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'     => $admin->user_id,
                    'tiket_id'    => $tiket->tiket_id,
                    'pesan'       => "Tiket baru #{$tiket->kode_tiket} telah dibuat",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }
        }

        if (Auth::user()->role === 'admin' && $tiket->user_id != Auth::id()) {
            Notification::create([
                'user_id'     => $tiket->user_id,
                'tiket_id'    => $tiket->tiket_id,
                'pesan'       => "Tiket #{$tiket->kode_tiket} telah dibuat untuk Anda",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);
        }

        if ($request->assigned_to) {
            Notification::create([
                'user_id'     => $request->assigned_to,
                'tiket_id'    => $tiket->tiket_id,
                'pesan'       => "Anda ditugaskan menangani tiket #{$tiket->kode_tiket}",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.tiket.index')
                ->with('success', 'Tiket berhasil dibuat dengan kode: ' . $kodeTiket);
        }

        return redirect()->route('tiket.index')
            ->with('success', 'Tiket berhasil dibuat dengan kode: ' . $kodeTiket);
    }

    /**
     * Menampilkan detail tiket
     */
    public function show($id)
    {
        $tiket = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'assignedTo', 'komentars'])
            ->where('tiket_id', $id)
            ->firstOrFail();

        if (Auth::user()->role == 'admin') {
            return view('admin.tiket.show', compact('tiket'));
        } else {
            return view('tiket.show', compact('tiket'));
        }
    }

    public function edit($tiket_id)
    {
        $tiket = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $tiket_id)
            ->firstOrFail();

        $users     = \App\Models\User::all();
        
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();
        $statuses  = \App\Models\TiketStatus::all();

        $timTeknisi = User::where('role', 'tim_teknisi')->get();
        $timKonten  = User::where('role', 'tim_konten')->get();

        if (Auth::user()->role === 'admin') {
            return view('admin.tiket.edit', compact('tiket', 'users', 'kategoris', 'prioritas', 'statuses', 'timTeknisi', 'timKonten'));
        }

        return view('tiket.edit', compact('tiket', 'kategoris', 'prioritas', 'statuses'));
    }

    /**
     * Mengupdate tiket
     */
    public function update(Request $request, $tiket_id)
    {
        try {
            $query = Tiket::where('tiket_id', $tiket_id);

            if (Auth::user()->role !== 'admin') {
                $query->where('user_id', Auth::id());
            }

            $tiket = $query->firstOrFail();

            $statusLama     = $tiket->status->nama_status ?? null;
            $statusIdLama   = $tiket->status_id;
            $assignedToLama = $tiket->assigned_to;

            // 🔹 Validasi berbeda untuk admin dan user
            if (Auth::user()->role === 'admin') {
                $validated = $request->validate([
                    'kategori_id'   => 'nullable|exists:kategoris,kategori_id',
                    'status_id'     => 'nullable|exists:tiket_statuses,status_id',
                    'prioritas_id'  => 'nullable|exists:priorities,prioritas_id',
                    'judul'         => 'nullable|string|max:255',
                    'deskripsi'     => 'nullable|string',
                    'assigned_to'   => 'nullable|exists:users,user_id',
                    'waktu_selesai' => 'nullable|date',
                ]);
            } else {
                // User biasa tidak bisa ubah status dan prioritas
                $validated = $request->validate([
                    'kategori_id' => 'nullable|exists:kategoris,kategori_id',
                    'judul'       => 'nullable|string|max:255',
                    'deskripsi'   => 'nullable|string',
                ]);
            }

            if (! empty($validated['waktu_selesai'])) {
                $validated['waktu_selesai'] = Carbon::parse($validated['waktu_selesai'])->format('Y-m-d H:i:s');
            }

            foreach ($validated as $key => $value) {
                if (! is_null($value)) {
                    $tiket->$key = $value;
                }
            }

            $tiket->save();

            // Notifikasi saat status berubah
if (Auth::user()->role === 'admin' && 
    isset($validated['status_id']) && 
    $statusIdLama != $validated['status_id']) {

    $statusBaru = $tiket->status->nama_status ?? 'Diperbarui';

    Notification::create([
        'user_id'     => $tiket->user_id,
        'tiket_id'    => $tiket->tiket_id,
        'pesan'       => "Tiket #{$tiket->kode_tiket} telah {$statusBaru}",
        'waktu_kirim' => now(),
        'status_baca' => false,
    ]);
}

// Notifikasi saat ditugaskan ke tim
if (Auth::user()->role === 'admin' && 
    isset($validated['assigned_to']) && 
    $assignedToLama != $validated['assigned_to'] && 
    $validated['assigned_to']) {

    Notification::create([
        'user_id'     => $validated['assigned_to'],
        'tiket_id'    => $tiket->tiket_id,
        'pesan'       => "Anda ditugaskan menangani tiket #{$tiket->kode_tiket}",
        'waktu_kirim' => now(),
        'status_baca' => false,
    ]);

    Notification::create([
        'user_id'     => $tiket->user_id,
        'tiket_id'    => $tiket->tiket_id,
        'pesan'       => "Tiket #{$tiket->kode_tiket} telah ditugaskan ke tim",
        'waktu_kirim' => now(),
        'status_baca' => false,
    ]);
}

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.tiket.index')
                    ->with('success', 'Tiket berhasil diperbarui.');
            }

            return redirect()->route('tiket.show', $tiket->tiket_id)
                ->with('success', 'Tiket berhasil diperbarui.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('tiket.index')->with('error', 'Tiket tidak ditemukan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus tiket
     */
   public function destroy($id)
{
    try {
        $tiket = Tiket::findOrFail($id);

        // Hapus lampiran jika ada
        if ($tiket->lampiran && Storage::exists($tiket->lampiran)) {
            Storage::delete($tiket->lampiran);
        }

        // Hapus semua komentar terkait
        $tiket->komentars()->delete();

        // Hapus tiket
        $tiket->delete();

        // RESPONSE UNTUK FLUTTER (API)
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil dihapus'
            ], 200);
        }

        // Response untuk Web (Blade)
        return redirect()->route('admin.tiket.index')
            ->with('success', 'Tiket berhasil dihapus.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan'
            ], 404);
        }
        return redirect()->route('tiket.index')->with('error', 'Tiket tidak ditemukan');
    } catch (\Exception $e) {
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Method khusus admin untuk update status cepat
     * Bisa dipanggil via AJAX atau form biasa
     */
    public function updateStatus(Request $request, $tiket_id)
    {
        try {
            $tiket      = Tiket::with(['status', 'user'])->findOrFail($tiket_id);
            $statusLama = $tiket->status->nama_status ?? null;

            $validated = $request->validate([
                'status_id' => 'required|exists:tiket_statuses,status_id',
            ]);

            $tiket->update($validated);
            $tiket->load(['status']);

            Notification::create([
                'user_id'  => $tiket->user_id,
                'tiket_id' => $tiket->tiket_id,
                'pesan'    => "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}'",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status tiket berhasil diupdate',
                    'tiket'   => $tiket,
                ]);
            }

            return redirect()->back()->with('success', 'Status tiket berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal update status: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk admin membalas tiket
     */
    public function reply(Request $request, $tiket_id)
    {
        try {
            $tiket = Tiket::with(['user'])->findOrFail($tiket_id);

            $validated = $request->validate([
                'balasan' => 'required|string',
            ]);

            Notification::create([
                'user_id'  => $tiket->user_id,
                'tiket_id' => $tiket->tiket_id,
                'pesan'    => "Admin telah membalas tiket #{$tiket->kode_tiket}: " . substr($validated['balasan'], 0, 50) . "...",
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            return redirect()->back()->with('success', 'Balasan berhasil dikirim');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim balasan: ' . $e->getMessage());
        }
    }

    /**
     * 🆕 Menampilkan tiket yang ditugaskan ke tim teknisi/konten
     * Hanya menampilkan tiket yang assigned_to = user login
     */
    public function timIndex(Request $request)
    {
        // Pastikan hanya tim teknisi atau tim konten yang bisa akses
        if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
            abort(403, 'Unauthorized access');
        }

        // Query tiket yang ditugaskan ke user login
        $query = Tiket::with(['user', 'kategori', 'prioritas', 'status'])
            ->where('assigned_to', Auth::id());

        // Filter opsional
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('prioritas_id')) {
            $query->where('prioritas_id', $request->prioritas_id);
        }

                                               // Sorting: Data terbaru di atas
        $query->orderBy('waktu_dibuat', 'desc'); // atau gunakan 'waktu_dibuat' jika itu nama kolomnya

                                        // Gunakan paginate untuk hasil yang lebih baik
        $tikets = $query->paginate(15); // atau ->get() jika tidak mau pagination

        // Data untuk dropdown filter
        $statuses  = \App\Models\TiketStatus::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();

        // Statistik untuk dashboard tim
        $stats = [
            'total'   => Tiket::where('assigned_to', Auth::id())->count(),
            'baru'    => Tiket::where('assigned_to', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Baru'))
                ->count(),
            'proses'  => Tiket::where('assigned_to', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Sedang Diproses'))
                ->count(),
            'selesai' => Tiket::where('assigned_to', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))
                ->count(),
        ];

        return view('tim.tiket.index', compact('tikets', 'statuses', 'kategoris', 'prioritas', 'stats'));
    }

    /**
     * 🆕 Menampilkan detail tiket untuk tim
     */
    public function timShow($id)
    {
        // Pastikan hanya tim teknisi atau tim konten yang bisa akses
        if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
            abort(403, 'Unauthorized access');
        }

        $tiket = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $id)
            ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
            ->firstOrFail();

        $statuses = \App\Models\TiketStatus::all();

        return view('tim.tiket.show', compact('tiket', 'statuses'));
    }

    /**
     * 🆕 Halaman edit tiket untuk tim teknisi/konten
     */
    public function timEdit($tiket_id)
    {
        // Pastikan hanya tim teknisi atau tim konten yang bisa akses
        if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
            abort(403, 'Unauthorized access');
        }

        $tiket = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('tiket_id', $tiket_id)
            ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
            ->firstOrFail();

        $statuses = \App\Models\TiketStatus::all();

        return view('tim.tiket.edit', compact('tiket', 'statuses'));
    }

    /**
     * 🆕 Update tiket oleh tim teknisi/konten
     */
    public function timUpdate(Request $request, $tiket_id)
    {
        try {
            // Pastikan hanya tim teknisi atau tim konten yang bisa akses
            if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
                abort(403, 'Unauthorized access');
            }

            $tiket = Tiket::with(['status', 'user'])
                ->where('tiket_id', $tiket_id)
                ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
                ->firstOrFail();

            $statusLama = $tiket->status->nama_status ?? null;

            // Validasi - Tim hanya bisa update status dan catatan
            $validated = $request->validate([
                'status_id' => 'required|exists:tiket_statuses,status_id',
                'catatan'   => 'nullable|string|max:1000',
            ]);

            // Update status
            $tiket->update(['status_id' => $validated['status_id']]);

            // Jika status selesai, set waktu selesai
            if ($tiket->status->nama_status == 'Selesai' && ! $tiket->waktu_selesai) {
                $tiket->update(['waktu_selesai' => now()]);
            }

            $tiket->load(['status']);

            // 🔔 KIRIM NOTIFIKASI KE USER
            $pesan = "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}' oleh " . Auth::user()->name;

            // Notifikasi ke User Pemilik Tiket
$statusBaru = $tiket->status->nama_status;

Notification::create([
    'user_id'     => $tiket->user_id,
    'tiket_id'    => $tiket->tiket_id,
    'pesan'       => "Tiket #{$tiket->kode_tiket} telah {$statusBaru}",
    'waktu_kirim' => now(),
    'status_baca' => false,
]);

// Notifikasi ke Admin
$admins = User::where('role', 'admin')->get();
foreach ($admins as $admin) {
    Notification::create([
        'user_id'     => $admin->user_id,
        'tiket_id'    => $tiket->tiket_id,
        'pesan'       => Auth::user()->name . " telah mengubah status tiket #{$tiket->kode_tiket} menjadi {$statusBaru}",
        'waktu_kirim' => now(),
        'status_baca' => false,
    ]);
}

            return redirect()->route('tim.tiket.show', $tiket->tiket_id)
                ->with('success', 'Tiket berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal update tiket: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * 🆕 Update status tiket oleh tim teknisi/konten (untuk AJAX/quick update)
     */
    public function timUpdateStatus(Request $request, $tiket_id)
    {
        try {
            // Pastikan hanya tim teknisi atau tim konten yang bisa akses
            if (! in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten'])) {
                abort(403, 'Unauthorized access');
            }

            $tiket = Tiket::with(['status', 'user'])
                ->where('tiket_id', $tiket_id)
                ->where('assigned_to', Auth::id()) // Hanya tiket yang ditugaskan ke user login
                ->firstOrFail();

            $statusLama = $tiket->status->nama_status ?? null;

            $validated = $request->validate([
                'status_id' => 'required|exists:tiket_statuses,status_id',
                'catatan'   => 'nullable|string|max:500',
            ]);

            $tiket->update(['status_id' => $validated['status_id']]);
            $tiket->load(['status']);

            // 🔔 KIRIM NOTIFIKASI KE USER
            $pesan = "Status tiket #{$tiket->kode_tiket} telah diubah dari '{$statusLama}' menjadi '{$tiket->status->nama_status}' oleh " . Auth::user()->name;

            if (! empty($validated['catatan'])) {
                $pesan .= ". Catatan: {$validated['catatan']}";
            }

            Notification::create([
                'user_id'     => $tiket->user_id,
                'tiket_id'    => $tiket->tiket_id,
                'pesan'       => $pesan,
                'waktu_kirim' => now(),
                'status_baca' => false,
            ]);

            // 🔔 KIRIM NOTIFIKASI KE ADMIN
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'  => $admin->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => Auth::user()->name . " telah mengubah status tiket #{$tiket->kode_tiket} menjadi '{$tiket->status->nama_status}'",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            return redirect()->back()->with('success', 'Status tiket berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan riwayat/history tiket user
     */
    // ==== DI METHOD history() (Riwayat Tiket) ====
    public function history(Request $request)
    {
        $query = Tiket::with(['user', 'kategori', 'prioritas', 'status', 'assignedTo'])
            ->where('user_id', Auth::id());

        // Tambahkan baris ini → hanya tiket yang SUDAH SELESAI / DITOLAK
        $query->whereHas('status', function ($q) {
            $q->whereIn('nama_status', ['Selesai', 'Ditolak']);
        });

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('waktu_dibuat', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('waktu_dibuat', '<=', $request->end_date);
        }

        // Filter berdasarkan status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan prioritas
        if ($request->filled('prioritas_id')) {
            $query->where('prioritas_id', $request->prioritas_id);
        }

        // Search berdasarkan judul atau kode tiket
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_tiket', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting: terbaru dulu
        $query->orderBy('waktu_dibuat', 'desc');

        // Pagination
        $tikets = $query->paginate(15);

        // Data untuk dropdown filter
        $statuses  = \App\Models\TiketStatus::all();
        $kategoris = \App\Models\Kategori::all();
        $prioritas = \App\Models\Prioritas::all();

        // Statistik riwayat
        $stats = [
            'total'    => Tiket::where('user_id', Auth::id())->count(),
            'selesai'  => Tiket::where('user_id', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))
                ->count(),
            'ditolak'  => Tiket::where('user_id', Auth::id())
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Ditolak'))
                ->count(),
            'diproses' => Tiket::where('user_id', Auth::id())
                ->whereHas('status', fn($q) => $q->whereIn('nama_status', ['Baru', 'Sedang Diproses']))
                ->count(),
        ];

        // Statistik per kategori
        $kategoriStats = Tiket::where('user_id', Auth::id())
            ->selectRaw('kategori_id, count(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        return view('tiket.history', compact('tikets', 'statuses', 'kategoris', 'prioritas', 'stats', 'kategoriStats'));
    }

/**
 * Export riwayat tiket ke PDF atau Excel (opsional)
 */
    public function exportHistory(Request $request)
    {
        $tikets = Tiket::with(['user', 'kategori', 'prioritas', 'status'])
            ->where('user_id', Auth::id())
            ->orderByDesc('waktu_dibuat')
            ->get();

        // Implementasi export sesuai kebutuhan
        // Bisa menggunakan package seperti Laravel Excel atau DomPDF

        return response()->json([
            'message' => 'Export feature coming soon',
            'data'    => $tikets,
        ]);
    }

    public function showKomentarForm($tiket_id)
    {
        $tiket = Tiket::with(['user', 'status', 'komentars'])
            ->where('tiket_id', $tiket_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek apakah tiket sudah selesai
        if ($tiket->status->nama_status !== 'Selesai') {
            return redirect()->route('tiket.show', $tiket_id)
                ->with('error', 'Komentar hanya dapat diberikan pada tiket yang sudah selesai.');
        }

        // Cek apakah user sudah memberikan komentar
        if ($tiket->hasUserComment(Auth::id())) {
            return redirect()->route('tiket.show', $tiket_id)
                ->with('info', 'Anda sudah memberikan komentar untuk tiket ini.');
        }

        return view('tiket.komentar', compact('tiket'));
    }

/**
 * Simpan komentar user
 */
    public function storeKomentar(Request $request, $tiket_id)
    {
        try {
            $tiket = Tiket::with(['status', 'assignedTo'])
                ->where('tiket_id', $tiket_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Validasi tiket harus selesai
            if ($tiket->status->nama_status !== 'Selesai') {
                return redirect()->back()
                    ->with('error', 'Komentar hanya dapat diberikan pada tiket yang sudah selesai.');
            }

            // Validasi user belum memberikan komentar
            if ($tiket->hasUserComment(Auth::id())) {
                return redirect()->back()
                    ->with('error', 'Anda sudah memberikan komentar untuk tiket ini.');
            }

            // Validasi input
            $validated = $request->validate([
                'komentar'      => 'required|string|min:10|max:1000',
                'rating'        => 'required|integer|min:1|max:5',
                'tipe_komentar' => 'required|in:feedback,evaluasi,complaint',
            ], [
                'komentar.required'      => 'Komentar wajib diisi',
                'komentar.min'           => 'Komentar minimal 10 karakter',
                'komentar.max'           => 'Komentar maksimal 1000 karakter',
                'rating.required'        => 'Rating wajib dipilih',
                'rating.min'             => 'Rating minimal 1',
                'rating.max'             => 'Rating maksimal 5',
                'tipe_komentar.required' => 'Tipe komentar wajib dipilih',
            ]);

            // Simpan komentar
            $komentar = TiketKomentar::create([
                'tiket_id'       => $tiket_id,
                'user_id'        => Auth::id(),
                'komentar'       => $validated['komentar'],
                'rating'         => $validated['rating'],
                'tipe_komentar'  => $validated['tipe_komentar'],
                'waktu_komentar' => now(),
            ]);

            // 🔔 KIRIM NOTIFIKASI KE ADMIN
            $admins     = User::where('role', 'admin')->get();
            $ratingText = str_repeat('⭐', $validated['rating']);

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'  => $admin->user_id,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => "User {$tiket->user->name} memberikan {$validated['tipe_komentar']} untuk tiket #{$tiket->kode_tiket} dengan rating {$ratingText}",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            // 🔔 KIRIM NOTIFIKASI KE TIM YANG DITUGASKAN
            if ($tiket->assigned_to) {
                Notification::create([
                    'user_id'  => $tiket->assigned_to,
                    'tiket_id' => $tiket->tiket_id,
                    'pesan'    => "User {$tiket->user->name} memberikan {$validated['tipe_komentar']} dengan rating {$ratingText} untuk tiket #{$tiket->kode_tiket} yang Anda tangani",
                    'waktu_kirim' => now(),
                    'status_baca' => false,
                ]);
            }

            return redirect()->route('tiket.show', $tiket_id)
                ->with('success', 'Terima kasih! Komentar Anda telah berhasil disimpan dan akan menjadi evaluasi kami.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage())
                ->withInput();
        }
    }

/**
 * Lihat semua komentar tiket (untuk admin)
 */
    public function adminViewKomentars($tiket_id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $tiket = Tiket::with(['user', 'komentars.user', 'status', 'kategori'])
            ->findOrFail($tiket_id);

        return view('admin.tiket.komentars', compact('tiket'));
    }

/**
 * Dashboard evaluasi untuk admin (statistik komentar)
 */
    public function adminEvaluasiDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        // Statistik rating
        $ratingStats = TiketKomentar::selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        // Rata-rata rating keseluruhan
        $averageRating = TiketKomentar::avg('rating');

        // Statistik per tipe komentar
        $tipeStats = TiketKomentar::selectRaw('tipe_komentar, COUNT(*) as total')
            ->groupBy('tipe_komentar')
            ->get();

        // Komentar terbaru
        $recentKomentars = TiketKomentar::with(['user', 'tiket'])
            ->orderByDesc('waktu_komentar')
            ->limit(10)
            ->get();

        // Statistik per tim yang ditugaskan
        $timStats = Tiket::with(['assignedTo', 'komentars'])
            ->whereNotNull('assigned_to')
            ->whereHas('komentars')
            ->get()
            ->groupBy('assigned_to')
            ->map(function ($tikets) {
                $avgRating     = $tikets->flatMap->komentars->avg('rating');
                $totalKomentar = $tikets->flatMap->komentars->count();
                return [
                    'user'           => $tikets->first()->assignedTo,
                    'avg_rating'     => round($avgRating, 2),
                    'total_komentar' => $totalKomentar,
                ];
            });

        // Komplain terbaru (prioritas tinggi)
        $complaints = TiketKomentar::with(['user', 'tiket'])
            ->where('tipe_komentar', 'complaint')
            ->orWhere('rating', '<=', 2)
            ->orderByDesc('waktu_komentar')
            ->limit(5)
            ->get();

        return view('admin.evaluasi.dashboard', compact(
            'ratingStats',
            'averageRating',
            'tipeStats',
            'recentKomentars',
            'timStats',
            'complaints'
        ));
    }
}
