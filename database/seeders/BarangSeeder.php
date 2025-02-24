<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            // Barang dari Supplier 1
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Laptop ASUS ROG', 'harga_beli' => 15000000, 'harga_jual' => 17000000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Monitor LG 24 Inch', 'harga_beli' => 2500000, 'harga_jual' => 3000000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'BRG003', 'barang_nama' => 'Mouse Logitech', 'harga_beli' => 300000, 'harga_jual' => 400000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 4, 'kategori_id' => 1, 'barang_kode' => 'BRG004', 'barang_nama' => 'Keyboard Mechanical', 'harga_beli' => 800000, 'harga_jual' => 1000000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 5, 'kategori_id' => 1, 'barang_kode' => 'BRG005', 'barang_nama' => 'Headset Gaming', 'harga_beli' => 1200000, 'harga_jual' => 1500000, 'created_at' => now(), 'updated_at' => now()],

            // Barang dari Supplier 2
            ['barang_id' => 6, 'kategori_id' => 2, 'barang_kode' => 'BRG006', 'barang_nama' => 'Jaket Hoodie', 'harga_beli' => 200000, 'harga_jual' => 300000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 7, 'kategori_id' => 2, 'barang_kode' => 'BRG007', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 100000, 'harga_jual' => 150000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 8, 'kategori_id' => 2, 'barang_kode' => 'BRG008', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 250000, 'harga_jual' => 350000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 9, 'kategori_id' => 2, 'barang_kode' => 'BRG009', 'barang_nama' => 'Sepatu Sneakers', 'harga_beli' => 500000, 'harga_jual' => 650000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 10, 'kategori_id' => 2, 'barang_kode' => 'BRG010', 'barang_nama' => 'Topi Baseball', 'harga_beli' => 120000, 'harga_jual' => 180000, 'created_at' => now(), 'updated_at' => now()],

            // Barang dari Supplier 3
            ['barang_id' => 11, 'kategori_id' => 3, 'barang_kode' => 'BRG011', 'barang_nama' => 'Mie Instan', 'harga_beli' => 3000, 'harga_jual' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 12, 'kategori_id' => 3, 'barang_kode' => 'BRG012', 'barang_nama' => 'Susu UHT', 'harga_beli' => 7000, 'harga_jual' => 10000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 13, 'kategori_id' => 3, 'barang_kode' => 'BRG013', 'barang_nama' => 'Beras Premium 5kg', 'harga_beli' => 60000, 'harga_jual' => 75000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 14, 'kategori_id' => 3, 'barang_kode' => 'BRG014', 'barang_nama' => 'Minyak Goreng 1L', 'harga_beli' => 15000, 'harga_jual' => 20000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 15, 'kategori_id' => 3, 'barang_kode' => 'BRG015', 'barang_nama' => 'Gula Pasir 1kg', 'harga_beli' => 13000, 'harga_jual' => 17000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
