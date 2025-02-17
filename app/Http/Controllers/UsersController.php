<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index($userId, $name)
    {
        return view('user')
            ->with('userId', $userId)
            ->with('name', $name);
    }
}
