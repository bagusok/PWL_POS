<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function category($slug)
    {
        return view('category')
            ->with('slug', $slug)
            ->with('category', str_replace(
                '-',
                ' ',
                ucfirst($slug)
            ));
    }
}
