<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Sklep (podgląd, filtr kategorii i wyszukiwarka)
    public function shop(Request $request)
    {
        $search = $request->query('q', '');
        $category = $request->query('kategoria', '');

        $products = Product::query()
            ->when($search !== '', fn ($q) => $q->where('name', 'like', '%' . $search . '%'))
            ->when($category !== '', fn ($q) => $q->where('category', $category))
            ->orderBy('name')
            ->get();

        return view('products.shop', compact('products', 'search', 'category'));
    }

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
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produkt został dodany.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produkt został zmieniony.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produkt został usunięty.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'stock' => 'required|integer|min:0',
            'category' => ['nullable', Rule::in(Product::CATEGORIES)],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}