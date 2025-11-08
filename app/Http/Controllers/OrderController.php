<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer');
        if ($request->filled('search')) {
            $query->where('id', $request->search)
                ->orWhereHas('customer', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $orders = $query->latest()->paginate(10);
        return view('pages.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all(['id', 'name']);
        $products = Product::all(['id', 'name', 'price']);
        return view('pages.orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'order_total' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'shipping_address' => 'nullable|string|max:500',
            'discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'remark' => 'nullable|string|max:500',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.vat' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $order = Order::create($validated);
                
                foreach ($validated['items'] as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'vat' => $item['vat'] ?? 0,
                        'discount' => $item['discount'] ?? 0,
                    ]);
                }
            });

            return redirect()->route('orders.index')->with('success', 'Order created successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create order: ' . $e->getMessage())->withInput();
        }
    }

        public function show(string $id)
        {
            $order = Order::with(['customer', 'details.product'])->findOrFail($id);
            return view("pages.orders.show", compact('order'));
        }

    public function edit($id)
    {
        $order = Order::with(['customer', 'details.product'])->findOrFail($id);
        $customers = Customer::all(['id', 'name']);
        $products = Product::all(['id', 'name', 'price']);
        
        return view('pages.orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'order_total' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'shipping_address' => 'nullable|string|max:500',
            'discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'remark' => 'nullable|string|max:500',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.vat' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ]);

        $order = Order::findOrFail($id);

        try {
            DB::transaction(function () use ($validated, $order) {
                // Update the order
                $order->update($validated);

                // Delete existing order details
                $order->details()->delete();

                // Create new order details
                foreach ($validated['items'] as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'vat' => $item['vat'] ?? 0,
                        'discount' => $item['discount'] ?? 0,
                    ]);
                }
            });

            return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update order: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        try {
            DB::transaction(function () use ($order) {
                $order->details()->delete();
                $order->delete();
            });
            
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }
}