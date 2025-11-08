<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class ProductController extends Controller
{
   
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    
    public function create()
    {
        $categories = Category::all();
        return view('pages.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'sku'         => 'required|string|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $data = $request->all();

        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    
    public function show(Product $product)
    {
        return view('pages.products.show', compact('product'));
    }

    
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'sku'         => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->all();

        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
