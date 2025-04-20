<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StockModel;
use App\Models\SupplierModel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{


    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Daftar Stock Terbaru',
            'list' => ['Home', 'Stock']
        ];

        $page = (object) [
            'title' => 'Daftar stock terbaru',
        ];

        $activeMenu = 'stock';

        $stock = StockModel::all();

        return view('stock.index', compact('breadcrumb', 'page', 'activeMenu', 'stock'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function list(Request $request)
    {
        $stock = StockModel::select('stock_id', 'supplier_id', 'barang_id', 'user_id', 'stock_jumlah', 'stock_tanggal')
            ->with('supplier', 'barang', 'user')->orderBy('created_at', 'desc');


        return DataTables::of($stock)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stock) { // menambahkan kolom aksi
                // $btn = '<button onclick="modalAction(\'' . url('/stock/' . $stock->stock_id .
                //     '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn = '<bsutton onclick="modalAction(\'' . url('/stock/' . $stock->stock_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::all();
        $supplier = SupplierModel::all();


        return view('stock.create_ajax', compact('barang', 'supplier'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id' => 'required|int|exists:m_supplier,supplier_id',
                'barang_id' => 'required|int|exists:m_barang,barang_id',
                'stock_jumlah' => 'required|int|min:1',
                'stock_tanggal' => 'required|date',
            ];

            $user = auth()->user();
            $request->merge([
                'user_id' => $user->user_id,
            ]);

            $validator = FacadesValidator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validasi gagal",
                    'msgField' => $validator->errors()
                ]);
            }

            StockModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data stock berhasil disimpan'
            ]);
        }
        redirect('/stock');
    }

    public function confirm_ajax(string $id)
    {
        $stock = StockModel::with('supplier', 'barang', 'user')->find($id);

        if (!$stock) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return view('stock.confirm_ajax', [
            'stock' => $stock
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $stock = StockModel::find($id);

                if ($stock) {

                    $barang = BarangModel::find($stock->barang_id);

                    // dd($barang->stock_available, $stock->stock_jumlah);

                    if ($barang->stock_available < $stock->stock_jumlah) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Tidak bisa menghapus stock, karena stock yang ada lebih sedikit dari stock yang tersedia, silahkan hapus penjualan terlebih dahulu'
                        ]);
                    }

                    $stock->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);

                    if ($stock->trashed()) {
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
}
