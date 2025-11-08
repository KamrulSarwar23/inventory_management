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
            'customer_id' => 'required',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date',
            'order_total' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'shipping_address' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
            'items' => 'required|array',
        ]);

        DB::transaction(function () use ($validated) {
            $order = Order::create($validated);
            foreach ($validated['items'] as $item) {
                $item['order_id'] = $order->id;
                OrderDetail::create($item);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    public function show(string $id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customer_id);
        $details = DB::table('orders as o')
            ->join('order_details as d', 'o.id', '=', 'd.order_id')
            ->join('products as p', 'p.id', '=', 'd.product_id')
            ->where('o.id', $id)
            ->select('p.id', 'p.name', 'd.qty', 'd.price', 'd.discount', 'd.vat')
            ->get();

        return view("pages.orders.show", ["order" => $order, "details" => $details, "customer" => $customer]);
    }

    public function edit($id)
    {
        
        $order = Order::with('customer')->findOrFail($id);
        $customer = $order->customer;

        $details = $order->details()->with('product')->get();

        return view('pages.orders.edit', compact('order', 'customer', 'details'));
    }

 public function update(Request $request, $id)
{
    $validated = $request->validate([
        'customer_id' => 'required',
        'order_date' => 'required|date',
        'delivery_date' => 'required|date',
        'order_total' => 'required|numeric',
        'paid_amount' => 'nullable|numeric',
        'shipping_address' => 'nullable|string',
        'discount' => 'nullable|numeric',
        'vat' => 'nullable|numeric',
        'items' => 'required|array',
    ]);

    $order = Order::findOrFail($id);

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

    return redirect()->route('orders.index')->with('success', 'Order updated successfully');
}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect('orders');
    }
}
