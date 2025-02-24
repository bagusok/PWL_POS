<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualanData = [
            [
                'penjualan_id' => 1,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Budi Santoso',
                'penjualan_kode' => 'PJN001',
                'penjualan_tanggal' => '2025-02-01 10:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Ani Wijaya',
                'penjualan_kode' => 'PJN002',
                'penjualan_tanggal' => '2025-02-02 11:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Cahyo Pratama',
                'penjualan_kode' => 'PJN003',
                'penjualan_tanggal' => '2025-02-03 14:15:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Dewi Lestari',
                'penjualan_kode' => 'PJN004',
                'penjualan_tanggal' => '2025-02-04 09:45:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Eko Nugroho',
                'penjualan_kode' => 'PJN005',
                'penjualan_tanggal' => '2025-02-05 16:20:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Fitriani',
                'penjualan_kode' => 'PJN006',
                'penjualan_tanggal' => '2025-02-06 12:10:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Guntur Wibowo',
                'penjualan_kode' => 'PJN007',
                'penjualan_tanggal' => '2025-02-07 13:45:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Hana Putri',
                'penjualan_kode' => 'PJN008',
                'penjualan_tanggal' => '2025-02-08 15:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Irfan Maulana',
                'penjualan_kode' => 'PJN009',
                'penjualan_tanggal' => '2025-02-09 17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3, // Staff/Kasir
                'pembeli' => 'Joko Susilo',
                'penjualan_kode' => 'PJN010',
                'penjualan_tanggal' => '2025-02-10 18:20:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke tabel m_penjualan
        DB::table('m_penjualan')->insert($penjualanData);
    }
}
