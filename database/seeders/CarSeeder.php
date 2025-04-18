<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Jalankan database seed.
     */
    public function run(): void
    {
        DB::table('cars')->insert([
            [
                'kode_mobil' => 'CAR-001',
                'merek' => 'Honda',
                'model' => 'New Honda City RS Hatchback CTV',
                'tahun' => 2021,
                'gambar' => 'citycars&hatchback.png',
                'kategori' => 'City Car & Hatchback',
                'spesifikasi' => '1.5L DOHC I-VTEC Engine 121PS
                                    • CVT with Earth Dreams Technology
                                    • Full LED Headlights with LED DRL
                                    • LED Fog Light
                                    • Black Door Mirror with LED Turning Signal
                                    • New 16" Sporty Alloy Wheels Design
                                    • One Push Ignition System 
                                    • Auto A/C with Red Illumination
                                    • Suede-Fabric Leather Combi Trimmed Seats
                                    • 8" Capacitive Touchscreen Display Audio
                                    • 8-Speakers
                                    • 2nd Row Power Outlet
                                    • Multi-Angle Rear View Camera
                                    • Remote Engine Start
                                    • ABS + EBD + BA
                                    • Brake Override System
                                    • Honda SENSING
                                    • Honda CONNECT
                                    • 7" Interactive TFT Meter Cluster
                                    • Honda LaneWatch
                                    • Auto Headlight
                                    • Walk-Away Auto Lock

                                    *Tambahan harga Rp 2.500.000,- untuk two tone color
                                    *Harga yang tertera untuk rangka 2025
                                    **Keterangan',
                'warna' => 'Electric Lime Metallic',
                'harga' => 384500000.00,
                'stok' => 4, 
                'created_at' => now(),
                'updated_at' => now(),
                                    ],
            [
                'kode_mobil' => 'CAR-002',
                'merek' => 'Honda',
                'model' => 'Honda Brio Satya S M/T',
                'tahun' => 2019,
                'gambar' => 'hondabriosatya.png',
                'kategori' => 'City Car & Hatchback',
                'spesifikasi' => '  • 1.2L i-VTEC 90PS with 4 cylinder
                                    • 5 M/T|
                                    • Digital A/C
                                    • Chrome Front Grille
                                    • 14" Trim Wheels
                                    • Black & Gray Interior Color with New Fabric Seat Pattern
                                    • Auto Up/Down Windows with Anti Pinch
                                    • 2nd Row Adjustable Headrest
                                    • Tilt Steering
                                    • Electric Power Steering
                                    • Digital A/C
                                    • ABS + EBD
                                    • Parking Sensor
                                    • 7" Touchscreen Display Audio, USB Port, AM/FM Radio, Bluetooth, Hands-free Telephone, Screen Mirroring.',
                'warna' => 'Taffeta White (Satya)',
                'harga' => 170400000.00,
                'stok' => 5, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mobil' => 'CAR-003',
                'merek' => 'Honda',
                'model' => 'Honda Brio Satya E M/T',
                'tahun' => 2021,
                'gambar' => 'hondabriosatya2.png',
                'kategori' => 'City Car & Hatchback',
                'spesifikasi' => 'Memiliki semua fitur di tipe S, ditambah:

                                    • Headlamp with LED DRL
                                    • 14" Two Tone Alloy Wheels
                                    • Rear Wiper
                                    • ⁠Audio Steering Switch with Illumination
                                    • ⁠Auto Door Lock by Speed
                                    • ⁠Alarm System
                                    • Shifter Illumination',
                'warna' => 'Meteroid Gray Metallic',
                'harga' => 185500000.00,
                'stok' => 6, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
