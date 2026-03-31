<?php
namespace Database\Seeders;

use App\Models\TiketStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiketStatusSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar status yang ingin ada
        $statuses = [
            'Pending',
            'Ditugaskan ke tim terkait',
            'Diproses',
            'Selesai',
            'Ditolak',
        ];

        foreach ($statuses as $nama) {
            // Cek dulu, kalau belum ada baru insert
            $exists = TiketStatus::where('nama_status', $nama)->exists();

            if (! $exists) {
                TiketStatus::create(['nama_status' => $nama]);
            }
        }

        // PERBAIKI SEQUENCE supaya tidak bentrok lagi (ini yang bikin error!)
        // Hanya dijalankan di PostgreSQL
        if (DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            $maxId = TiketStatus::max('status_id') ?? 0;
            DB::statement("SELECT setval('tiket_statuses_status_id_seq', {$maxId}, true)");
        }

    }
}
