<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriCOntroller extends Controller
{
    public function index()
    {
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];

        // DB::table('m_kategori')->insert($data);

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update([
        //     'kategori_nama' => 'Camilan'
        // ]);

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();

        $data = DB::table('m_kategori')->get();

        return view('kategori', [
            'data' => $data
        ]);
    }
}
