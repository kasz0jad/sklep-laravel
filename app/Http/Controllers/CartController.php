<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        $items = $products->map(fn ($p) => [
            'product' => $p,
            'quantity' => $cart[$p->id],
            'subtotal' => $p->price * $cart[$p->id],
        ]);
        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = session('cart', []);
        $quantity = ($cart[$product->id] ?? 0) + (int) $request->quantity;

        if ($quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Brak wystarczającej ilości w magazynie.']);
        }

        $cart[$product->id] = $quantity;
        session(['cart' => $cart]);

        return back()->with('success', 'Dodano do koszyka.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }
}