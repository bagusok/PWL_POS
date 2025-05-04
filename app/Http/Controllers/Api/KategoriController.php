<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama', 'created_at');

        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil diambil',
            'data' => $kategori->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil ditambahkan',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // dd($request->all());

        $kategori = KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,

        ]);

        if ($kategori) {
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data kategori gagal diubah',
            ]);
        }
    }


    public function destroy(string $id)
    {

        $check = KategoriModel::find($id);
        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Data kategori tidak ditemukan',
            ]);
        }

        try {
            KategoriModel::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil dihapus',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data kategori gagal dihapus',
            ]);
        }
    }
}
