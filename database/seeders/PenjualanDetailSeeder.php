<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualanDetailData = [];

        // Ambil semua penjualan_id dari tabel m_penjualan
        $penjualanIds = DB::table('m_penjualan')->pluck('penjualan_id')->toArray();

        // Ambil semua barang_id dari tabel m_barang
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray();

        $detailId = 1; // Mulai dari detail_id = 1

        // Loop untuk setiap transaksi penjualan
        foreach ($penjualanIds as $penjualanId) {
            // Ambil 3 barang secara acak untuk setiap transaksi
            $selectedBarangIds = array_rand(array_flip($barangIds), 3);

            foreach ($selectedBarangIds as $barangId) {
                // Ambil harga jual dari tabel m_barang
                $harga = DB::table('m_barang')->where('barang_id', $barangId)->value('harga_jual');

                // Tambahkan data detail penjualan
                $penjualanDetailData[] = [
                    'detail_id' => $detailId++,
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $barangId,
                    'harga' => $harga,
                    'jumlah' => rand(1, 5), // Jumlah barang antara 1 sampai 5
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert data ke tabel t_penjualan_detail
        DB::table('t_penjualan_detail')->insert($penjualanDetailData);
    }
}
