<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function list(Request $request)
    {
        $barangs = BarangModel::with('kategori')->orderBy('created_at', 'desc');

        // dd($barangs->first()->total_stock, $barangs->first()->total_penjualan, $barangs->first()->stock_available);

        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data barang berhasil diambil',
            'data' => $barangs->get(),
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'kategori_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = $request->file('image');
        $filename = 'barang' . '_' . $request->barang_kode  . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/barang'), $filename);

        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'image' => $filename,
        ]);

        if ($barang) {
            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan',
                'data' => $barang
            ]);
        } else {
            return response()->json([
                'status' => false,

            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'kategori_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $file = $request->file('image');
        $filename = 'barang' . '_' . $request->barang_kode  . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/barang'), $filename);

        $barang = BarangModel::find($id)->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'image' => $filename,
        ]);

        if ($barang) {
            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data barang gagal diubah'
            ]);
        }
    }


    public function destroy(string $id)
    {

        $check = BarangModel::find($id);
        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Data barang tidak ditemukan'
            ]);
        }

        try {
            BarangModel::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data barang gagal dihapus'
            ]);
        }
    }
}
