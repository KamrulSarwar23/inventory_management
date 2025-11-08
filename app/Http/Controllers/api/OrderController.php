<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // List all orders
    public function index()
    {
        $orders = Order::with('details')->latest()->get();
        return response()->json($orders);
    }

  
    public function show($id)
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
            'items.*.product_id' => 'required|integer',
            'items.*.qty' => 'required|numeric',
            'items.*.price' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create($validated);

            foreach ($validated['items'] as $item) {
                $item['order_id'] = $order->id;
                OrderDetail::create($item);
            }

            DB::commit();
            return response()->json(['success' => true, 'order' => $order->load('details')], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
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
        return redirect("orders");
    }
}
