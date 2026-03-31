<?php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik berdasarkan role
        if ($user->role === 'admin') {
            $stats     = $this->getAdminStats();
            $chartData = $this->getAdminChartData();
        } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
            $stats     = $this->getTimStats($user);
            $chartData = $this->getTimChartData($user);
        } else {
            $stats     = $this->getUserStats($user);
            $chartData = $this->getUserChartData($user);
        }

        return view('home', compact('stats', 'chartData'));
    }

    // Statistik untuk Admin
    private function getAdminStats()
    {
        return [
            // Tiket Stats - DIPERBAIKI ✅
            'total_tiket'     => Tiket::count(),
            'tiket_baru'      => Tiket::whereHas('status', fn($q) => $q->where('nama_status', 'Pending'))->count(),                                   // ✅ Ganti "Baru" jadi "Pending"
            'tiket_proses'    => Tiket::whereHas('status', fn($q) => $q->whereIn('nama_status', ['Ditugaskan ke tim terkait', 'Diproses']))->count(), // ✅ Gabung 2 status
            'tiket_selesai'   => Tiket::whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))->count(),

            // Laporan Stats
            'total_laporan'   => Report::count(),
            'laporan_pending' => Report::where('status', 'pending')->count(),
            'laporan_proses'  => Report::where('status', 'diproses')->count(),
            'laporan_selesai' => Report::where('status', 'selesai')->count(),

            // Recent Data
            'recent_tikets'   => Tiket::with(['user', 'status', 'prioritas'])
                ->latest('waktu_dibuat')
                ->take(5)
                ->get(),
            'recent_reports'  => Report::with(['user', 'kategori', 'prioritas'])
                ->whereNotNull('id')
                ->latest('created_at')
                ->take(5)
                ->get(),
        ];
    }

    // Statistik untuk Tim Teknisi/Konten
    private function getTimStats($user)
    {
        return [
            // Tiket yang ditugaskan - DIPERBAIKI ✅
            'total_tiket'     => Tiket::where('assigned_to', $user->user_id)->count(),
            'tiket_baru'      => Tiket::where('assigned_to', $user->user_id)
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Pending'))
                ->count(),
            'tiket_proses'    => Tiket::where('assigned_to', $user->user_id)
                ->whereHas('status', fn($q) => $q->whereIn('nama_status', ['Ditugaskan ke tim terkait', 'Diproses']))
                ->count(),
            'tiket_selesai'   => Tiket::where('assigned_to', $user->user_id)
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))
                ->count(),

            // Laporan yang ditugaskan
            'total_laporan'   => Report::where('assigned_to', $user->user_id)->count(),
            'laporan_pending' => Report::where('assigned_to', $user->user_id)
                ->where('status', 'pending')
                ->count(),
            'laporan_proses'  => Report::where('assigned_to', $user->user_id)
                ->where('status', 'diproses')
                ->count(),
            'laporan_selesai' => Report::where('assigned_to', $user->user_id)
                ->where('status', 'selesai')
                ->count(),

            // Recent Data
            'recent_tikets'   => Tiket::with(['user', 'status', 'prioritas'])
                ->where('assigned_to', $user->user_id)
                ->latest('waktu_dibuat')
                ->take(5)
                ->get(),
            'recent_reports'  => Report::with(['user', 'kategori', 'prioritas'])
                ->where('assigned_to', $user->user_id)
                ->latest('created_at')
                ->take(5)
                ->get(),
        ];
    }

    // Statistik untuk User Biasa
    private function getUserStats($user)
    {
        return [
            // Tiket milik user - DIPERBAIKI ✅
            'total_tiket'     => Tiket::where('user_id', $user->user_id)->count(),
            'tiket_baru'      => Tiket::where('user_id', $user->user_id)
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Pending'))
                ->count(),
            'tiket_proses'    => Tiket::where('user_id', $user->user_id)
                ->whereHas('status', fn($q) => $q->whereIn('nama_status', ['Ditugaskan ke tim terkait', 'Diproses']))
                ->count(),
            'tiket_selesai'   => Tiket::where('user_id', $user->user_id)
                ->whereHas('status', fn($q) => $q->where('nama_status', 'Selesai'))
                ->count(),

            // Laporan milik user
            'total_laporan'   => Report::where('user_id', $user->user_id)->count(),
            'laporan_pending' => Report::where('user_id', $user->user_id)
                ->where('status', 'pending')
                ->count(),
            'laporan_proses'  => Report::where('user_id', $user->user_id)
                ->where('status', 'diproses')
                ->count(),
            'laporan_selesai' => Report::where('user_id', $user->user_id)
                ->where('status', 'selesai')
                ->count(),

            // Recent Data
            'recent_tikets'   => Tiket::with(['user', 'status', 'prioritas'])
                ->where('user_id', $user->user_id)
                ->latest('waktu_dibuat')
                ->take(5)
                ->get(),
            'recent_reports'  => Report::with(['user', 'kategori', 'prioritas'])
                ->where('user_id', $user->user_id)
                ->latest('created_at')
                ->take(5)
                ->get(),
        ];
    }

    // Chart Data tidak perlu diubah...
    private function getAdminChartData()
    {
        $months      = [];
        $tiketData   = [];
        $laporanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $tiketData[] = Tiket::whereYear('waktu_dibuat', $date->year)
                ->whereMonth('waktu_dibuat', $date->month)
                ->count();

            $laporanData[] = Report::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'labels'  => $months,
            'tiket'   => $tiketData,
            'laporan' => $laporanData,
        ];
    }

    private function getTimChartData($user)
    {
        $months      = [];
        $tiketData   = [];
        $laporanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $tiketData[] = Tiket::where('assigned_to', $user->user_id)
                ->whereYear('waktu_dibuat', $date->year)
                ->whereMonth('waktu_dibuat', $date->month)
                ->count();

            $laporanData[] = Report::where('assigned_to', $user->user_id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'labels'  => $months,
            'tiket'   => $tiketData,
            'laporan' => $laporanData,
        ];
    }

    private function getUserChartData($user)
    {
        $months      = [];
        $tiketData   = [];
        $laporanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date     = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $tiketData[] = Tiket::where('user_id', $user->user_id)
                ->whereYear('waktu_dibuat', $date->year)
                ->whereMonth('waktu_dibuat', $date->month)
                ->count();

            $laporanData[] = Report::where('user_id', $user->user_id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'labels'  => $months,
            'tiket'   => $tiketData,
            'laporan' => $laporanData,
        ];
    }
}
