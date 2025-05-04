<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{

    public function list(Request $request)
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama', 'created_at');


        return response()->json([
            'status' => true,
            'message' => 'Data level berhasil diambil',
            'data' => $level->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $create =  LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        if ($create) {
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan',
                'data' => $create
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data level gagal disimpan'
            ]);
        }
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // dd($request->all());

        $level = LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,

        ]);

        if ($level) {
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil diupdate',
                'data' => $level
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data level gagal diupdate'
            ]);
        }
    }


    public function destroy(string $id)
    {

        $check = LevelModel::find($id);

        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Data level tidak ditemukan'
            ]);
        }

        try {
            LevelModel::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus, karena masih digunakan'
            ]);
        }
    }
}
