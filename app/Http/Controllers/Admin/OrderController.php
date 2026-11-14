<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public const STATUSES = ['nowe', 'w realizacji', 'wysłane', 'zrealizowane'];

    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        if ($order->status === 'anulowane') {
            return redirect()->route('admin.orders.show', $order)
                ->withErrors(['order' => 'Anulowanego zamówienia nie można edytować.']);
        }

        return view('admin.orders.edit', [
            'order' => $order,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        if ($order->status === 'anulowane') {
            return redirect()->route('admin.orders.show', $order)
                ->withErrors(['order' => 'Anulowanego zamówienia nie można edytować.']);
        }

        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\-]+$/u'],
            'shipping_phone' => ['required', 'regex:/^\d{9}$/'],
            'shipping_street' => ['nullable', 'string', 'max:255', 'regex:/^[\p{L}0-9\s\.\-]+$/u'],
            'shipping_house_number' => ['required', 'regex:/^\d{1,4}[A-Za-z]?(\/\d{1,4}[A-Za-z]?)?$/'],
            'shipping_postcode' => ['required', 'regex:/^\d{2}-\d{3}$/', 'not_in:00-000'],
            'shipping_city' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.\-]+$/u'],
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Zamówienie zostało zmienione.');
    }

    // "Usunięcie" = anulowanie: zamówienie zostaje w bazie, towar wraca do magazynu
    public function destroy(Order $order)
    {
        $cancelled = DB::transaction(function () use ($order) {
            $order = Order::whereKey($order->id)->lockForUpdate()->first();

            if ($order->status === 'anulowane') {
                return false;
            }

            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'anulowane']);

            return true;
        });

        if (! $cancelled) {
            return back()->withErrors(['order' => 'To zamówienie jest już anulowane.']);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Zamówienie zostało anulowane.');
    }
}