<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diambil',
            'data' => $users->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5', // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data user gagal diubah'
            ]);
        }
    }


    public function destroy(string $id)
    {

        $check = UserModel::find($id);
        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Data user tidak ditemukan'
            ]);
        }

        try {
            UserModel::destroy($id);
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil dihapus'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data user gagal dihapus'
            ]);
        }
    }

    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diambil',
            'data' => $user
        ]);
    }
}
