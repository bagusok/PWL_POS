<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan',
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->with('user')
            ->orderBy('created_at', 'desc');


        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_harga', function ($penjualan) { // menambahkan kolom total harga
                return 'Rp. ' . number_format($penjualan->total_harga, 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<a href="' . url('/penjualan/edit/' . $penjualan->penjualan_id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm m-1">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('user', 'penjualan_detail')->find($id);

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return view('penjualan.detail', [
            'penjualan' => $penjualan
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Penjualan',
        ];

        $activeMenu = 'penjualan';

        // $barang = BarangModel::select('barang_nama', 'harga_jual', 'barang_id')
        //     ->with(['stock', 'penjualan_detail']) // supaya stock_available bisa diakses
        //     ->get();

        $barang = BarangModel::select('barang_nama', 'harga_jual', 'barang_id')
            ->get()
            ->map(function ($barang) {
                return [
                    'barang_id' => $barang->barang_id,
                    'barang_nama' => $barang->barang_nama,
                    'harga_jual' => $barang->harga_jual,
                    'stock_available' => $barang->stock_available,
                ];
            });


        // dd($barang);

        return view('penjualan.create', compact('breadcrumb', 'page', 'activeMenu'))->with([
            'barang' => $barang,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
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
                    'message' => 'Penjualan berhasil disimpan'
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
        redirect('/penjualan');
    }

    public function edit(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Penjualan',
            'list' => ['Home', 'Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Penjualan',
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::with('user', 'penjualan_detail')->find($id);

        if (!$penjualan) {
            return redirect('/penjualan');
        }

        $penjualanWithBarang = $penjualan->penjualan_detail->map(function ($item) {
            return [
                'barang_id' => $item->barang_id,
                'barang_nama' => $item->barang->barang_nama,
                'harga_jual' => $item->barang->harga_jual,
                'jumlah' => $item->jumlah,
                'stock_available' => $item->barang->stock_available,
                'total_harga' => $item->harga,
            ];
        });

        // dd($penjualanWithBarang);

        $barang = BarangModel::select('barang_nama', 'harga_jual', 'barang_id')
            ->get()
            ->map(function ($barang) {
                return [
                    'barang_id' => $barang->barang_id,
                    'barang_nama' => $barang->barang_nama,
                    'harga_jual' => $barang->harga_jual,
                    'stock_available' => $barang->stock_available,
                ];
            });

        return view('penjualan.edit', compact('breadcrumb', 'page', 'activeMenu'))->with([
            'penjualan' => $penjualan,
            'barang' => $barang,
            'penjualan_detail' => $penjualanWithBarang,
        ]);
    }

    public function update(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|exists:m_penjualan,penjualan_id',
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
                $penjualan = PenjualanModel::find($request->penjualan_id);

                if (!$penjualan) {
                    return response()->json([
                        'status' => false,
                        'message' => "Data tidak ditemukan"
                    ]);
                }

                $penjualan->update([
                    'pembeli' => $request->pembeli,
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                ]);

                // Hapus detail penjualan yang sudah ada
                $penjualan->penjualan_detail()->delete();

                foreach ($request->barang as $item) {
                    $barang = BarangModel::find($item['id']);

                    // cek stock barang
                    if ($barang->stock_available < $item['quantity']) {

                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => "Stock " . $barang->barang_nama . " tidak cukup"
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
                    'message' => 'Penjualan berhasil diupdate'
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
        redirect('/penjualan');
    }



    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('user', 'penjualan_detail')->find($id);

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return view('penjualan.confirm_ajax', [
            'penjualan' => $penjualan
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $penjualan = PenjualanModel::with('penjualan_detail')->find($id);

                if ($penjualan) {


                    $penjualan->penjualan_detail()->delete();
                    $penjualan->delete();

                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);

                    if ($penjualan->trashed()) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Data berhasil dihapus'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Data gagal dihapus'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ]);
                }
            } catch (QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data gagal dihapus, karena masih digunakan'
                ]); {
                }
            }
        }

        return redirect('/');
    }

    public function export_pdf(Request $request)
    {
        $data = PenjualanModel::with('penjualan_detail', 'user')->withSum('penjualan_detail', 'harga')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('penjualan.export_pdf', [
            'data' => $data
        ]);

        $pdf->setPaper('A4', 'landscape'); // Note: fixed typo from 'potrait' to 'portrait'
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            // 'margin_top' => 10,
            // 'margin_right' => 10,
            // 'margin_bottom' => 10,
            // 'margin_left' => 10,
            // 'dpi' => 150
        ]);

        return $pdf->stream('Data_Penjualan_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
