<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kategori' => 'Teknis',
                'deskripsi' => 'Permasalahan terkait perangkat lunak, perangkat keras, dan jaringan.'
            ],
            [
                'nama_kategori' => 'Sarana & Prasarana',
                'deskripsi' => 'Laporan kerusakan fasilitas, peralatan kantor, dan kebutuhan inventaris.'
            ],
            [
                'nama_kategori' => 'Akun & Akses',
                'deskripsi' => 'Masalah login, lupa password, dan akses aplikasi.'
            ],
            [
                'nama_kategori' => 'Layanan Umum',
                'deskripsi' => 'Layanan terkait kebutuhan administrasi umum dan operasional.'
            ],
            [
                'nama_kategori' => 'Konten & Media',
                'deskripsi' => 'Kebutuhan desain, konten sosial media, atau dokumentasi.'
            ],
        ];

        foreach ($data as $item) {
            Kategori::create($item);
        }
    }
}
