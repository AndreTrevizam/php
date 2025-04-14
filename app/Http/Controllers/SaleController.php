<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function store(Request $request) {
        $fields = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($fields['product_id']);
    
        if ($fields['quantity'] > $product->quantity) {
            return back()->withErrors(['quantity' => 'Estoque insuficiente.']);
        }
    
        // Registrar a venda com o preço atual do produto
        Sale::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'quantity' => $fields['quantity'],
            'unit_price' => $product->price
        ]);
    
        // Reduzir o estoque
        $product->decrement('quantity', $fields['quantity']);
    
        return redirect('/')->with('success', 'Venda registrada com sucesso!');
    }
    

    public function report() {
        $sales = Sale::with('product')->get();
        return view('sales-report', ['sales' => $sales]);
    }
}
