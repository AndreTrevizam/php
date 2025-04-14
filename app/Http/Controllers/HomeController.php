<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        $products = [];
        $salesData = [
            'groupedSales' => collect(),
            'totalGeral' => 0,
            'totalQuantidade' => 0
        ];
    
        if (Auth::check()) {
            $user = Auth::user();
            $products = $user->userProducts()->latest()->get();
    
            // Agrupa vendas por produto
            $groupedSales = Sale::whereHas('product', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with('product')
                ->get()
                ->groupBy('product_id');
    
            // Calcula totais por produto e gerais
            $groupedSales = $groupedSales->map(function ($sales, $productId) {
                $totalQuantity = $sales->sum('quantity');
                $totalValue = $sales->sum(function($sale) {
                    return $sale->quantity * $sale->unit_price;
                });
                
                return [
                    'product' => $sales->first()->product,
                    'total_quantity' => $totalQuantity,
                    'total_value' => $totalValue,
                    'unit_price' => $sales->first()->unit_price // mantemos o preço unitário
                ];
            });
    
            $salesData = [
                'groupedSales' => $groupedSales,
                'totalGeral' => $groupedSales->sum('total_value'),
                'totalQuantidade' => $groupedSales->sum('total_quantity')
            ];
        }
    
        return view('home', array_merge([
            'products' => $products,
        ], $salesData));
    }
}