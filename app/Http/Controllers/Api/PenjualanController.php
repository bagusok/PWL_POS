<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{

    /**
     * @bodyParam pembeli string required Nama pembeli. Example: John Doe
     * @bodyParam penjualan_tanggal date required Tanggal penjualan. Example: 2024-08-01
     * @bodyParam barang array required Daftar barang.
     * @bodyParam barang[].id integer required ID barang. Example: 1
     * @bodyParam barang[].quantity integer required Jumlah barang. Example: 2
     */
    public function store(Request $request)
    {

        $rules = [
            'pembeli' => 'required|string|max:255',
            'penjualan_tanggal' => 'required|date',
            'barang' => 'required|array|min:1',
            'barang.*.id' => 'required|exists:m_barang,barang_id',
            'barang.*.quantity' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validasi gagal",
                'msgField' => $validator->errors()
            ]);
        }


        DB::beginTransaction();
        try {
            $penjualan = PenjualanModel::create([
                'user_id' => auth()->user()->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_tanggal' => $request->penjualan_tanggal,
                'penjualan_kode' => 'P'  . time() . strtoupper(str()->random(8)),
            ]);

            foreach ($request->barang as $item) {
                $barang = BarangModel::find($item['id']);


                // cek stock barang
                if ($barang->stock_available < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Stock barang tidak cukup'
                    ]);
                }

                $penjualan->penjualan_detail()->create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $item['id'],
                    'jumlah' => $item['quantity'],
                    'harga' => $barang->harga_jual * $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Penjualan berhasil disimpan',
                'data' => $penjualan->load('penjualan_detail.barang')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ]);
        }
    }
}
