<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'status'   => 'active',
            'role'     => 'admin',
            'password' => Hash::make('admin'),
        ]);

        User::create([
            'name'     => 'customer',
            'email'    => 'customer@gmail.com',
            'status'   => 'active',
            'role'     => 'customer',
            'password' => Hash::make('customer'),
        ]);

        User::create([
            'name'     => 'Tim Teknisi',
            'email'    => 'teknisi@gmail.com',
            'status'   => 'active',
            'role'     => 'tim_teknisi',
            'password' => Hash::make('teknisi123'),
        ]);

        User::create([
            'name'     => 'Tim Konten',
            'email'    => 'konten@gmail.com',
            'status'   => 'active',
            'role'     => 'tim_konten',
            'password' => Hash::make('konten123'),
        ]);

    }
}
