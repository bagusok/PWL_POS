<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        $todayIncome = PenjualanModel::whereDate('created_at', now())
            ->withSum('penjualan_detail', 'harga')
            ->get()
            ->sum('penjualan_detail_sum_harga');

        $monthlyIncome = PenjualanModel::whereMonth('created_at', now()->month)
            ->withSum('penjualan_detail', 'harga')
            ->get()
            ->sum('penjualan_detail_sum_harga');

        $allIncome = PenjualanModel::withSum('penjualan_detail', 'harga')
            ->get()
            ->sum('penjualan_detail_sum_harga');


        $chartMonthly = PenjualanModel::whereBetween('created_at', [now()->subDays(30)->startOfDay(), now()->endOfDay()])
            ->withSum('penjualan_detail', 'harga')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map(function ($items, $date) {
                return [
                    'date' => $date,
                    'total' => $items->sum('penjualan_detail_sum_harga')
                ];
            })
            ->values();

        // dd($todayIncome, $monthlyIncome, $allIncome);

        return view('welcome', compact('breadcrumb', 'activeMenu'))->with([
            'todayIncome' => $todayIncome,
            'monthlyIncome' => $monthlyIncome,
            'allIncome' => $allIncome,
            'chartMonthly' => $chartMonthly,
        ]);
    }
}
