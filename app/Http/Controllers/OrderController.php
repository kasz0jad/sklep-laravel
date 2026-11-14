<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
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

    // Kasa: dostępna także dla gości (gość zobaczy wybór logowania)
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Koszyk jest pusty.']);
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $items = $products->map(fn ($p) => [
            'product' => $p,
            'quantity' => $cart[$p->id],
            'subtotal' => $p->price * $cart[$p->id],
        ]);
        $total = $items->sum('subtotal');

        // gość po zalogowaniu lub rejestracji wróci do kasy
        if (! auth()->check()) {
            session(['url.intended' => route('checkout')]);
        }

        return view('orders.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $shipping = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\-]+$/u'],
            'shipping_phone' => ['required', 'regex:/^\d{9}$/'],
            'shipping_street' => ['nullable', 'string', 'max:255', 'regex:/^[\p{L}0-9\s\.\-]+$/u'],
            'shipping_house_number' => ['required', 'regex:/^\d{1,4}[A-Za-z]?(\/\d{1,4}[A-Za-z]?)?$/'],
            'shipping_postcode' => ['required', 'regex:/^\d{2}-\d{3}$/', 'not_in:00-000'],
            'shipping_city' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.\-]+$/u'],
            'save_address' => ['nullable', 'boolean'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Koszyk jest pusta.']);
        }

        try {
            $order = DB::transaction(function () use ($cart, $shipping) {
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

                // poprzednie zamówienia tego klienta przestają być "nowe"
                Order::where('user_id', auth()->id())
                    ->where('status', 'nowe')
                    ->update(['status' => 'w realizacji']);

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'status' => 'nowe',
                    'shipping_name' => $shipping['shipping_name'],
                    'shipping_phone' => $shipping['shipping_phone'],
                    'shipping_street' => $shipping['shipping_street'] ?? null,
                    'shipping_house_number' => $shipping['shipping_house_number'],
                    'shipping_postcode' => $shipping['shipping_postcode'],
                    'shipping_city' => $shipping['shipping_city'],
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

       if ($request->boolean('save_address')) {
            $request->user()->update([
                'phone' => $shipping['shipping_phone'],
                'street' => $shipping['shipping_street'] ?? null,
                'house_number' => $shipping['shipping_house_number'],
                'postcode' => $shipping['shipping_postcode'],
                'city' => $shipping['shipping_city'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Zamówienie zostało złożone.');
    }
}