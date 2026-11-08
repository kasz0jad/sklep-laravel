<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items');
        return view('orders.show', compact('order'));
    }

    public function store()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Koszyk jest pusty.']);
        }

        try {
            $order = DB::transaction(function () use ($cart) {
                $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get();

                if ($products->isEmpty()) {
                    throw new RuntimeException('Koszyk jest pusty.');
                }

                $total = 0;
                foreach ($products as $p) {
                    if ($cart[$p->id] > $p->stock) {
                        throw new RuntimeException("Brak wystarczającej ilości: {$p->name}");
                    }
                    $total += $p->price * $cart[$p->id];
                }

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'status' => 'nowe',
                ]);

                foreach ($products as $p) {
                    $qty = $cart[$p->id];
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $p->id,
                        'product_name' => $p->name,
                        'price' => $p->price,
                        'quantity' => $qty,
                    ]);
                    $p->decrement('stock', $qty);
                }

                return $order;
            });
        } catch (RuntimeException $e) {
            return redirect()->route('cart.index')->withErrors(['cart' => $e->getMessage()]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Zamówienie zostało złożone.');
    }
}