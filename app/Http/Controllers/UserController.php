<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        // UserModel::insert([
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('123456'),
        //     'level_id' => 3
        // ]);

        UserModel::where('username', 'customer-1')->update([
            'nama' => 'Pelanggan Pertama',

        ]);

        $user = UserModel::all();
        return view('user', [
            'data' => $user
        ]);
    }
}
