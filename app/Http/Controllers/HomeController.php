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

        if (Auth::check()) {
            $user = Auth::user();
            $products = $user->userProducts()->latest()->get();

            // Buscar apenas as vendas de produtos que pertencem ao usuário logado
            $sales = Sale::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->whereHas('product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->groupBy('product_id')
                ->with('product')
                ->get();
        } else {
            $sales = collect(); // coleção vazia
        }

        return view('home', [
            'products' => $products,
            'sales' => $sales,
        ]);
    }

}
