<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KategoriCOntroller extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem',
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();

        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama', 'created_at');


        return DataTables::of($kategori)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btnsm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btnwarning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return
confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif

        return view('kategori.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }


    public function show(string $id)
    {
        $kategori = KategoriModel::find($id)->first();


        // dd($kategori);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'user';

        return view('kategori.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        // dd($request->all());

        $kategori = KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,

        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }


    public function destroy(string $id)
    {

        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus');
        }
    }
}
