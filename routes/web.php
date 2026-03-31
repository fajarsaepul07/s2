<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PrioritasController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TiketStatusController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    // Jika sudah login, redirect ke home
    if ((Auth::check())) {
        return redirect()->route('home');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    // Jika sudah login, redirect ke home
    if ((Auth::check())) {
        return redirect()->route('home');
    }
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Google Login
Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect'])->name('google.redirect');
Route::get('/auth-google-callback', [AuthController::class, 'google_callback'])->name('google.callback');

// PROTECTED ROUTES - BUTUH LOGIN
Route::middleware('auth')->group(function () {

    // Halaman Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 🔔 NOTIFIKASI ROUTES (Untuk Semua User) - FINAL FIX
    Route::prefix('notifications')->name('notifications.')->middleware('auth')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/unread', [NotificationController::class, 'getUnread'])->name('unread');
        
        // Route utama
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        
        // Alias untuk kompatibilitas (jika ada view lain yang masih pakai readAll)
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('readAll');
        
        // FIXED: Tambah GET route untuk handle redirect dari onclick
        Route::get('/{id}/read', [NotificationController::class, 'read'])->name('read.get');
        Route::post('/{id}/read', [NotificationController::class, 'read'])->name('read');
        
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // ADMIN ROUTES - PREFIX: /admin
    Route::prefix('admin')->middleware('isAdmin')->group(function () {

        // CRUD Kategori
        Route::resource('kategori', KategoriController::class);

        // CRUD Prioritas
        Route::resource('prioritas', PrioritasController::class);

        // CRUD Status Tiket
        Route::resource('status', TiketStatusController::class)
            ->except(['show'])
            ->names([
                'index'   => 'admin.status.index',
                'create'  => 'admin.status.create',
                'store'   => 'admin.status.store',
                'edit'    => 'admin.status.edit',
                'update'  => 'admin.status.update',
                'destroy' => 'admin.status.destroy',
            ]);

        // Admin Tiket Routes
        Route::get('/tiket', [TiketController::class, 'adminIndex'])->name('admin.tiket.index');

        Route::resource('tiket', TiketController::class)->except(['index'])->names([
            'create'  => 'admin.tiket.create',
            'store'   => 'admin.tiket.store',
            'show'    => 'admin.tiket.show',
            'edit'    => 'admin.tiket.edit',
            'update'  => 'admin.tiket.update',
            'destroy' => 'admin.tiket.destroy',
        ]);

        // 🔔 Actions khusus admin untuk tiket
        Route::post('/tiket/{tiket_id}/update-status', [TiketController::class, 'updateStatus'])->name('admin.tiket.updateStatus');
        Route::post('/tiket/{tiket_id}/reply', [TiketController::class, 'reply'])->name('admin.tiket.reply');

        // Admin Report Routes
        Route::get('report', [ReportController::class, 'index'])->name('admin.report.index');
        Route::get('report/create', [ReportController::class, 'create'])->name('admin.report.create');
        Route::post('report', [ReportController::class, 'store'])->name('admin.report.store');
        Route::get('report/{id}', [ReportController::class, 'show'])->name('admin.report.show');
        Route::get('report/{id}/edit', [ReportController::class, 'edit'])->name('admin.report.edit');
        Route::put('report/{id}', [ReportController::class, 'update'])->name('admin.report.update');
        Route::delete('report/{id}', [ReportController::class, 'destroy'])->name('admin.report.destroy');

    });

    // USER ROUTES - TIKET
    Route::prefix('tiket')->group(function () {

        Route::get('/history', [TiketController::class, 'history'])->name('tiket.history');
        Route::get('/history/export', [TiketController::class, 'exportHistory'])->name('tiket.history.export');

        // Daftar tiket
        Route::get('/', [TiketController::class, 'index'])->name('tiket.index');

        // Form buat tiket
        Route::get('/create', function () {
            $kategoris = \App\Models\Kategori::all();
            $prioritas = \App\Models\Prioritas::all();
            $statuses  = \App\Models\TiketStatus::all();
            $tikets    = \App\Models\Tiket::with('status', 'kategori', 'prioritas')->get();

            return view('tiket.create', compact('kategoris', 'prioritas', 'statuses', 'tikets'));
        })->name('tiket.create');

        // Simpan tiket
        Route::post('/', [TiketController::class, 'store'])->name('tiket.store');

        // Detail tiket (dengan constraint bahwa tiket_id harus angka)
        Route::get('/{tiket_id}', [TiketController::class, 'show'])
            ->where('tiket_id', '[0-9]+')
            ->name('tiket.show');

        // Form edit tiket
        Route::get('/{tiket_id}/edit', [TiketController::class, 'edit'])
            ->where('tiket_id', '[0-9]+')
            ->name('tiket.edit');

        // Update tiket
        Route::put('/{tiket_id}', [TiketController::class, 'update'])
            ->where('tiket_id', '[0-9]+')
            ->name('tiket.update');

        // Hapus tiket
        Route::delete('/{tiket_id}', [TiketController::class, 'destroy'])
            ->where('tiket_id', '[0-9]+')
            ->name('tiket.destroy');
    });

    // USER ROUTES - REPORT
    Route::prefix('report')->group(function () {

        Route::get('/history', [ReportController::class, 'history'])->name('report.history');
        Route::get('/history/export', [ReportController::class, 'exportHistory'])->name('report.history.export');

        Route::get('/', [ReportController::class, 'index'])->name('report.index');
        Route::get('/create', [ReportController::class, 'create'])->name('report.create');
        Route::post('/', [ReportController::class, 'store'])->name('report.store');
        Route::get('/{id}', [ReportController::class, 'show'])->name('report.show');
        Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
        Route::put('/{id}', [ReportController::class, 'update'])->name('report.update');
        Route::delete('/{id}', [ReportController::class, 'destroy'])->name('report.destroy');
    });

    // TIM TEKNISI ROUTES
    Route::middleware(['auth'])->prefix('tim-teknisi')->name('tim_teknisi.')->group(function () {
        Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
        Route::get('/laporan/{id}', [ReportController::class, 'show'])->name('report.show');
        Route::get('/laporan/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
        Route::put('/laporan/{id}', [ReportController::class, 'update'])->name('report.update');
    });

    // TIM KONTEN ROUTES
    Route::middleware(['auth'])->prefix('tim-konten')->name('tim_konten.')->group(function () {
        Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
        Route::get('/laporan/{id}', [ReportController::class, 'show'])->name('report.show');
        Route::get('/laporan/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
        Route::put('/laporan/{id}', [ReportController::class, 'update'])->name('report.update');
    });

    // TIM (TEKNISI & KONTEN) - TIKET ROUTES
    Route::middleware(['auth'])->prefix('tim')->name('tim.')->group(function () {
        // Tiket yang ditugaskan
        Route::get('/tiket', [TiketController::class, 'timIndex'])->name('tiket.index');
        Route::get('/tiket/{id}', [TiketController::class, 'timShow'])->name('tiket.show');
        Route::get('/tiket/{id}/edit', [TiketController::class, 'timEdit'])->name('tiket.edit');
        Route::put('/tiket/{id}', [TiketController::class, 'timUpdate'])->name('tiket.update');
        Route::put('/tiket/{id}/update-status', [TiketController::class, 'timUpdateStatus'])->name('tiket.update-status');
    });
});

// Routes untuk User - Komentar Tiket
Route::middleware(['auth'])->group(function () {
    Route::get('/tiket/{tiket_id}/komentar', [TiketController::class, 'showKomentarForm'])
        ->name('tiket.komentar.form');

    Route::post('/tiket/{tiket_id}/komentar', [TiketController::class, 'storeKomentar'])
        ->name('tiket.komentar.store');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Route tiket admin yang sudah ada...
    
    // 🆕 Route Evaluasi & Komentar Admin
    Route::get('/evaluasi/dashboard', [TiketController::class, 'adminEvaluasiDashboard'])
        ->name('evaluasi.dashboard');
    Route::get('/tiket/{tiket_id}/komentars', [TiketController::class, 'adminViewKomentars'])
        ->name('tiket.komentars');
});


// Fallback route (optional)

