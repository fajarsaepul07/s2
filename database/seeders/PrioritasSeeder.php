<?php
namespace Database\Seeders;

use App\Models\Prioritas;
use Illuminate\Database\Seeder;

class PrioritasSeeder extends Seeder
{
    public function run()
    {
        $priorities = [
            ['nama_prioritas' => 'Critical'],
            ['nama_prioritas' => 'High'],
            ['nama_prioritas' => 'Medium'],
            ['nama_prioritas' => 'Low'],
        ];

        foreach ($priorities as $priority) {
            Prioritas::firstOrCreate(
                ['nama_prioritas' => $priority['nama_prioritas']],
                $priority
            );
        }
    }
}
