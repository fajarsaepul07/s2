<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi sesuai role
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->user_id)
            ->with('tiket')
            ->orderBy('waktu_kirim', 'desc')
            ->paginate(10);

        // Pisahkan view berdasarkan role - FIXED
        if (in_array($user->role, ['admin', 'tim_teknisi', 'tim_konten'])) {
            // Untuk admin dan tim (teknisi/konten) gunakan view admin
            return view('admin.notifications.index', compact('notifications', 'user'));
        } else {
            // Untuk user biasa
            return view('notifications.index', compact('notifications', 'user'));
        }
    }

    /**
     * Ambil notifikasi belum dibaca (untuk dropdown navbar)
     */
    public function getUnread()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->user_id)
            ->where('status_baca', false)
            ->with('tiket')
            ->orderBy('waktu_kirim', 'desc')
            ->limit(5)
            ->get();

        $unreadCount = Notification::where('user_id', $user->user_id)
            ->where('status_baca', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai dibaca DAN redirect ke tiket
     * Method ini digunakan saat user klik notifikasi
     */
    public function read($id)
    {
        try {
            $user = Auth::user();
            
            $notification = Notification::where('notif_id', $id)
                ->where('user_id', $user->user_id)
                ->with('tiket')
                ->firstOrFail();

            // Tandai sebagai dibaca
            $notification->update(['status_baca' => true]);

            // Return JSON jika AJAX request
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil ditandai sebagai dibaca'
                ]);
            }

            // Redirect ke detail tiket jika ada - FIXED untuk semua role
            if ($notification->tiket_id && $notification->tiket) {
                // Cek role untuk redirect ke route yang tepat
                if ($user->role === 'admin') {
                    // Admin menggunakan route admin
                    return redirect()->route('admin.tiket.show', $notification->tiket_id);
                } elseif (in_array($user->role, ['tim_teknisi', 'tim_konten'])) {
                    // Tim menggunakan route tim
                    return redirect()->route('tim.tiket.show', $notification->tiket_id);
                } else {
                    // User biasa
                    return redirect()->route('tiket.show', $notification->tiket_id);
                }
            }

            // Jika tidak ada tiket terkait, kembali ke halaman notifikasi
            return redirect()->route('notifications.index')
                ->with('info', 'Tiket terkait tidak ditemukan');

        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menandai notifikasi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menandai notifikasi');
        }
    }

    /**
     * Tandai SEMUA notifikasi sebagai dibaca
     * Method ini untuk button "Tandai Semua Dibaca"
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $user = Auth::user();

            // Update semua notifikasi yang belum dibaca
            $updated = Notification::where('user_id', $user->user_id)
                ->where('status_baca', false)
                ->update(['status_baca' => true]);

            Log::info("User {$user->user_id} marked {$updated} notifications as read");

            // Jika AJAX request, return JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Semua notifikasi telah ditandai sebagai dibaca',
                    'updated_count' => $updated
                ]);
            }

            // Jika request biasa, redirect
            return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');

        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menandai semua notifikasi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menandai semua notifikasi');
        }
    }

    /**
     * Hapus notifikasi
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            
            $notification = Notification::where('notif_id', $id)
                ->where('user_id', $user->user_id)
                ->firstOrFail();

            $notification->delete();

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil dihapus'
                ]);
            }

            return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus notifikasi'
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus notifikasi');
        }
    }
}