<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Prioritas;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar laporan sesuai role
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Eager load relasi untuk menghindari N+1 query
        $query = Report::with(['kategori', 'prioritas', 'user', 'assignedUser']);

        // Filter berdasarkan role
        if ($user->role === 'admin') {
            // Admin melihat semua laporan
            $view = 'admin.report.index';
        } elseif ($user->role === 'tim_teknisi') {
            // Tim teknisi melihat laporan yang ditugaskan ke mereka
            $query->where('assigned_to', $user->user_id);
            $view = 'admin.teknisi.index';
        } elseif ($user->role === 'tim_konten') {
            // Tim konten melihat laporan yang ditugaskan ke mereka
            $query->where('assigned_to', $user->user_id);
            $view = 'admin.konten.index';
        } else {
            // User biasa hanya melihat laporan miliknya
            $query->where('user_id', $user->user_id);
            $view = 'report.index';
        }

        // Filter berdasarkan kategori jika ada request
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan status jika ada request
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search berdasarkan judul atau deskripsi
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil data dengan sorting terbaru
        $reports = $query->latest()->get();

        // Data untuk dropdown filter
        $kategoris = Kategori::all();
        $statuses  = ['pending', 'diproses', 'selesai', 'ditolak'];

        // Statistik riwayat
        $stats = [
            'total'    => Report::where('user_id', $user->user_id)->count(),
            'selesai'  => Report::where('user_id', $user->user_id)
                ->where('status', 'selesai')
                ->count(),
            'ditolak'  => Report::where('user_id', $user->user_id)
                ->where('status', 'ditolak')
                ->count(),
            'diproses' => Report::where('user_id', $user->user_id)
                ->whereIn('status', ['pending', 'diproses'])
                ->count(),
        ];

        $kategoriStats = Report::where('user_id', $user->user_id)
            ->selectRaw('kategori_id, count(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        return view($view, compact('reports', 'kategoris', 'statuses', 'stats', 'kategoriStats'));

    }

    /**
     * Form membuat laporan baru
     */
    public function create()
    {
        $user      = auth()->user();
        $kategoris = Kategori::all();
        $prioritas = Prioritas::all();
        $teknisis  = collect();
        $kontens   = collect();

        if ($user->role === 'admin') {
            $teknisis = User::where('role', 'tim_teknisi')->get();
            $kontens  = User::where('role', 'tim_konten')->get();
        }

        if ($user->role === 'admin') {
            $view = 'admin.report.create';
        } else {
            $view = 'report.create';
        }

        return view($view, compact('kategoris', 'prioritas', 'teknisis', 'kontens'));
    }

    /**
     * Simpan laporan baru
     */
    // ... di dalam ReportController

    public function store(Request $request)
    {
        $user = auth()->user();

        // Tentukan aturan validasi berdasarkan role
        $rules = [
            'judul'       => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'deskripsi'   => 'required|string',
            'lampiran'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assigned_to' => 'nullable|exists:users,user_id',
        ];

        // Hanya admin/teknisi/konten yang wajib mengisi prioritas
        if (in_array($user->role, ['admin', 'tim_teknisi', 'tim_konten'])) {
            $rules['prioritas_id'] = 'required|exists:priorities,prioritas_id';
        } else {
            $rules['prioritas_id'] = 'nullable|exists:priorities,prioritas_id';
        }

        $validated = $request->validate($rules);

        // Upload file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }

        $validated['user_id'] = $user->user_id;
        $validated['status']  = 'pending';

        // Set prioritas default untuk user biasa jika tidak diisi
        if (! isset($validated['prioritas_id'])) {
                                            // Ambil ID prioritas "Medium" atau "Normal" sebagai default
                                            // Sesuaikan dengan ID yang ada di database Anda
            $validated['prioritas_id'] = 2; // Misalnya ID 2 = Medium/Normal
        }

        Report::create($validated);

        // Tentukan route redirect berdasarkan role
        if ($user->role === 'admin') {
            $route = 'admin.report.index';
        } elseif ($user->role === 'tim_teknisi') {
            $route = 'admin.teknisi.index';
        } elseif ($user->role === 'tim_konten') {
            $route = 'admin.konten.index';
        } else {
            $route = 'report.index';
        }

        return redirect()->route($route)->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Detail laporan
     */
    public function show($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            $report = $query->findOrFail($id);
            $view   = 'admin.report.show';
        } elseif ($user->role === 'tim_teknisi') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.teknisi.show';
        } elseif ($user->role === 'tim_konten') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.konten.show';
        } else {
            $report = $query->where('user_id', $user->user_id)->findOrFail($id);
            $view   = 'report.show';
        }

        return view($view, compact('report'));
    }

    /**
     * Form edit laporan
     */
    public function edit($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            $report = $query->findOrFail($id);
            $view   = 'admin.report.edit';
        } elseif ($user->role === 'tim_teknisi') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.teknisi.edit';
        } elseif ($user->role === 'tim_konten') {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
            $view   = 'admin.konten.edit';
        } else {
            $report = $query->where('user_id', $user->user_id)->findOrFail($id);
            $view   = 'report.edit';
        }

        $kategoris  = Kategori::all();
        $priorities = Prioritas::all();
        $teknisis   = collect();
        $kontens    = collect();

        if ($user->role === 'admin') {
            $teknisis = User::where('role', 'tim_teknisi')->get();
            $kontens  = User::where('role', 'tim_konten')->get();
        }

        return view($view, compact('report', 'kategoris', 'priorities', 'teknisis', 'kontens'));
    }

    /**
     * Update laporan
     */
    public function update(Request $request, $id)
    {
        $user   = auth()->user();
        $report = Report::query();

        if ($user->role === 'admin') {
            $report = $report->findOrFail($id);
        } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
            $report = $report->where('assigned_to', $user->user_id)->findOrFail($id);
        } else {
            $report = $report->where('user_id', $user->user_id)->findOrFail($id);
        }

        if ($user->role === 'admin') {
            $this->updateAsAdmin($request, $report);
        } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
            $this->updateAsTeam($request, $report);
        } else {
            $this->updateAsUser($request, $report);
        }

        return redirect()->route($this->getRedirectRoute())
            ->with('success', 'Laporan berhasil diperbarui!');
    }

// Helper method untuk admin
    private function updateAsAdmin(Request $request, Report $report)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,kategori_id',
            'prioritas_id' => 'required|exists:priorities,prioritas_id',
            'deskripsi'    => 'required|string',
            'lampiran'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'assigned_to'  => 'nullable|exists:users,user_id',
            'status'       => 'required|in:pending,diproses,selesai,ditolak',
        ]);

        $this->handleFileUpload($request, $report, $validated);
        $report->update($validated);
    }

// Helper method untuk tim teknisi/konten
    private function updateAsTeam(Request $request, Report $report)
    {
        $validated = $request->validate([
            'deskripsi' => 'string',
            'lampiran'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status'    => 'required|in:diproses,selesai', // teknisi hanya 2 pilihan
        ]);
        
        $report->status    = $validated['status']; // update status

        if ($request->hasFile('lampiran')) {
            if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $report->lampiran = $request->file('lampiran')->store('reports', 'public');
        }

        $report->save();
    }

// Helper method untuk user biasa
    private function updateAsUser(Request $request, Report $report)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,kategori_id',
            'deskripsi'    => 'required|string',
            'lampiran'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $this->handleFileUpload($request, $report, $validated);
        $report->update($validated);
    }

// Helper untuk handle upload file
    private function handleFileUpload(Request $request, Report $report, array &$validated)
    {
        if ($request->hasFile('lampiran')) {
            if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
                Storage::disk('public')->delete($report->lampiran);
            }
            $validated['lampiran'] = $request->file('lampiran')->store('reports', 'public');
        }
    }

    private function getRedirectRoute()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin'       => 'admin.report.index',
            'tim_teknisi' => 'tim_teknisi.report.index',
            'tim_konten'  => 'tim_konten.report.index',
            default       => 'report.index',
        };
    }

    /**
     * Hapus laporan
     */
    public function destroy($id)
    {
        $user  = auth()->user();
        $query = Report::query();

        if ($user->role === 'admin') {
            $report = $query->findOrFail($id);
        } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
            $report = $query->where('assigned_to', $user->user_id)->findOrFail($id);
        } else {
            $report = $query->where('user_id', $user->user_id)->findOrFail($id);
        }

        if ($report->lampiran && Storage::disk('public')->exists($report->lampiran)) {
            Storage::disk('public')->delete($report->lampiran);
        }

        $report->delete();

        if ($user->role === 'admin') {
            $route = 'admin.report.index';
        } elseif ($user->role === 'tim_teknisi') {
            $route = 'admin.teknisi.index';
        } elseif ($user->role === 'tim_konten') {
            $route = 'admin.konten.index';
        } else {
            $route = 'report.index';
        }

        return redirect()->route($route)->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Menampilkan riwayat/history report user
     */
    public function history(Request $request)
    {
        $user = $request->user();

        // Query semua report milik user yang login
        $query = Report::with(['kategori', 'prioritas', 'user', 'assignedUser'])
            ->where('user_id', $user->user_id);

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search berdasarkan judul
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting: terbaru dulu
        $query->orderByDesc('created_at');

        // Pagination
        $reports = $query->paginate(15);

        // Data untuk dropdown filter
        $kategoris = Kategori::all();
        $prioritas = Prioritas::all();
        $statuses  = ['pending', 'diproses', 'selesai', 'ditolak'];

        // Statistik riwayat
        $stats = [
            'total'    => Report::where('user_id', $user->user_id)->count(),
            'selesai'  => Report::where('user_id', $user->user_id)
                ->where('status', 'selesai')
                ->count(),
            'ditolak'  => Report::where('user_id', $user->user_id)
                ->where('status', 'ditolak')
                ->count(),
            'diproses' => Report::where('user_id', $user->user_id)
                ->whereIn('status', ['pending', 'diproses'])
                ->count(),
        ];

        // Statistik per kategori
        $kategoriStats = Report::where('user_id', $user->user_id)
            ->selectRaw('kategori_id, count(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get();

        return view('report.history', compact('reports', 'kategoris', 'prioritas', 'statuses', 'stats', 'kategoriStats'));
    }

/**
 * Export riwayat report (opsional)
 */
    public function exportHistory(Request $request)
    {
        $reports = Report::with(['kategori', 'prioritas', 'user'])
            ->where('user_id', $request->user()->user_id)
            ->orderByDesc('created_at')
            ->get();

        // Implementasi export sesuai kebutuhan
        return response()->json([
            'message' => 'Export feature coming soon',
            'data'    => $reports,
        ]);
    }

    /**
     * Tentukan redirect sesuai role user
     */
}
