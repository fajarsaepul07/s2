<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'nama_event' => 'Konser Musik Rock Nusantara 2025',
                'area' => 'Jakarta',
                'lokasi' => 'Gelora Bung Karno Stadium',
                'tanggal_mulai' => Carbon::create(2025, 3, 15),
                'tanggal_selesai' => Carbon::create(2025, 3, 15),
            ],
            [
                'nama_event' => 'Festival Kuliner Bandung',
                'area' => 'Bandung',
                'lokasi' => 'Lapangan Gasibu',
                'tanggal_mulai' => Carbon::create(2025, 4, 1),
                'tanggal_selesai' => Carbon::create(2025, 4, 3),
            ],
            [
                'nama_event' => 'Tech Summit Indonesia 2025',
                'area' => 'Jakarta',
                'lokasi' => 'Jakarta Convention Center',
                'tanggal_mulai' => Carbon::create(2025, 5, 10),
                'tanggal_selesai' => Carbon::create(2025, 5, 12),
            ],
            [
                'nama_event' => 'Pameran Seni Rupa Kontemporer',
                'area' => 'Yogyakarta',
                'lokasi' => 'Museum Affandi',
                'tanggal_mulai' => Carbon::create(2025, 6, 5),
                'tanggal_selesai' => Carbon::create(2025, 6, 30),
            ],
            [
                'nama_event' => 'Surabaya Fashion Week 2025',
                'area' => 'Surabaya',
                'lokasi' => 'Grand City Convention Hall',
                'tanggal_mulai' => Carbon::create(2025, 7, 20),
                'tanggal_selesai' => Carbon::create(2025, 7, 23),
            ],
            [
                'nama_event' => 'Bali International Film Festival',
                'area' => 'Bali',
                'lokasi' => 'Bali International Convention Centre',
                'tanggal_mulai' => Carbon::create(2025, 8, 15),
                'tanggal_selesai' => Carbon::create(2025, 8, 20),
            ],
            [
                'nama_event' => 'Marathon Jakarta 2025',
                'area' => 'Jakarta',
                'lokasi' => 'Bundaran HI - Monas',
                'tanggal_mulai' => Carbon::create(2025, 9, 10),
                'tanggal_selesai' => Carbon::create(2025, 9, 10),
            ],
            [
                'nama_event' => 'Indonesia Comic Con 2025',
                'area' => 'Jakarta',
                'lokasi' => 'ICE BSD',
                'tanggal_mulai' => Carbon::create(2025, 10, 5),
                'tanggal_selesai' => Carbon::create(2025, 10, 7),
            ],
            [
                'nama_event' => 'Semarang Night Carnival',
                'area' => 'Semarang',
                'lokasi' => 'Simpang Lima',
                'tanggal_mulai' => Carbon::create(2025, 11, 2),
                'tanggal_selesai' => Carbon::create(2025, 11, 2),
            ],
            [
                'nama_event' => 'Bazar Ramadan Nusantara',
                'area' => 'Jakarta',
                'lokasi' => 'Parkir Timur Senayan',
                'tanggal_mulai' => Carbon::create(2026, 3, 1),
                'tanggal_selesai' => Carbon::create(2026, 3, 29),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}