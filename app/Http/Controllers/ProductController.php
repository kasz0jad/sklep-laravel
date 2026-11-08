<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Lista dla klienta (tylko podgląd)
    public function shop()
    {
        $products = Product::orderBy('name')->get();
        return view('products.shop', compact('products'));
    }

    // Zarządzanie: moderator i admin
    public function index()
    {
        $products = Product::orderBy('id')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produkt został dodany.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produkt został usunięty.');
    }
}