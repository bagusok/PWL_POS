<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        // Mengambil data user yang memiliki user_id 1
        // $user = UserModel::find(1);

        // Mengambil data user yang memiliki level_id 1
        // $user = UserModel::where('level_id', 1)->first();

        // Mengambil data user yang memiliki level_id 1
        // $user = UserModel::firstWhere('level_id', 1);


        // Mengambil data user yang memiliki user id, tetapi jika tidak ada
        // Maka akan mengembalikan halaman 404
        // $user = UserModel::findOr(20, ['username', 'nama'], function () {
        //     abort(404);
        // });

        // Mengambil data user yang memiliki user id 20
        // Jika tidak ada, maka akan mengembalikan halaman 404
        // $user = UserModel::findOrFail(20);

        // $user = UserModel::where('level_id', 1)->count();
        // dd($user);

        // $user = UserModel::where([
        //     'username' => 'johndoe',
        // ])->firstOrCreate([
        //     'level_id' => 1,
        //     'username' => 'johndoe',
        //     'nama' => 'John Doe',
        //     // 'password' => Hash::make('password')
        // ]);

        // $user = UserModel::firstOrNew([
        //     'level_id' => 1,
        //     'username' => 'john_smith',
        //     'nama' => 'John Smith',
        //     'password' => Hash::make('password')
        // ]);

        // $user->save();

        // $user = UserModel::create([
        //     'username' => 'manager44',
        //     'nama' => 'Manager 44',
        //     'password' => Hash::make('password'),
        //     'level_id' => 2
        // ]);

        // $user->username = 'manager45';

        // $user->isDirty();
        // $user->isDirty('username');
        // $user->isDirty([
        //     'username',
        //     'nama'
        // ]);

        // $user->isClean();
        // $user->isClean('username');
        // $user->isClean([
        //     'username',
        //     'nama'
        // ]);

        // $user->save();

        // $user->isDirty();
        // $user->isClean();

        // dd($user->isDirty());

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager 11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ]);

        // $user->username = 'manager45';
        // $user->save();

        // $user->wasChanged();
        // dd($user->wasChanged());

        $user = UserModel::with('level')->get();

        return view('user.user', [
            'data' => $user
        ]);
    }

    public function tambah()
    {
        return view('user.user_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => request()->username,
            'nama' => request()->nama,
            'password' => Hash::make(request()->password),
            'level_id' => request()->level_id
        ]);

        return redirect('/user');
    }

    public function ubah($id)
    {

        $user = UserModel::findOrFail($id);

        return view('user.user_edit', [
            'user' => $user
        ]);
    }

    public function ubah_simpan($id)
    {
        $user = UserModel::findOrFail($id);

        $user->update([
            'username' => request()->username,
            'nama' => request()->nama,
            'password' => Hash::make(request()->password),
            'level_id' => request()->level_id
        ]);

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect('/user');
    }
}
