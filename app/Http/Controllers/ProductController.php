<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function userOwnsProduct(Product $product): bool {
        return auth()->id() === $product->user_id;
    }

    private function validateProductFields(Request $request): array {
        $fields = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required'
        ]);

        return [
            'name' => strip_tags($fields['name']),
            'description' => strip_tags($fields['description']),
            'price' => strip_tags($fields['price']),
            'quantity' => strip_tags($fields['quantity']),
        ];
    }

    public function updateProduct(Product $product, Request $request) {
        if (!$this->userOwnsProduct($product)) {
            return redirect('/');
        }

        $incomingFields = $this->validateProductFields($request);

        $product->update($incomingFields);
        return redirect('/');
    }

    public function createProduct(Request $request) {
        $incomingFields = $this->validateProductFields($request);
        $incomingFields['user_id'] = auth()->id();

        Product::create($incomingFields);

        return redirect('/');
    }

    public function showEditScreen(Product $product) {
        if (auth()->user()->id !== $product['user_id']) {
            return redirect('/');
        }

        return view('edit-product', ['product' => $product]);
    }

    public function deleteProduct(Product $product) {
        if (!$this->userOwnsProduct($product)) {
            return redirect('/');
        }

        $product->delete();
        return redirect('/');
    }
}
