<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('m_kategori')->insert([
            [
                'kategori_id' => 1,
                'kategori_kode' => 'KTG001',
                'kategori_nama' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'KTG002',
                'kategori_nama' => 'Fashion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'KTG003',
                'kategori_nama' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'KTG004',
                'kategori_nama' => 'Kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'KTG005',
                'kategori_nama' => 'Olahraga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
