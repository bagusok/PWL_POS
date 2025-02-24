<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_id' => 1,
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'PT. Sumber Berkah',
                'supplier_alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'CV. Makmur Sentosa',
                'supplier_alamat' => 'Jl. Sejahtera No. 45, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SUP003',
                'supplier_nama' => 'UD. Jaya Abadi',
                'supplier_alamat' => 'Jl. Raya Sukamaju No. 78, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
