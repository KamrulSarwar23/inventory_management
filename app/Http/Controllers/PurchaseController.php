<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $purchases = DB::table('purchases as ps')
            ->join('suppliers as sup', 'sup.id', '=', 'ps.supplier_id')
            ->leftJoin('statuses as st', 'st.id', '=', 'ps.status_id')
            ->select(
                'ps.id',
                'ps.created_at',
                'ps.purchase_total',
                'ps.shipping_address',
                'sup.name as supplier',
                'st.name as status'
            )
            ->get();

        return view("pages.purchases.index", ["purchases" => $purchases]);
    }


    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {
        $suppliers = Supplier::all();
        return view("pages.purchases.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::find($id);
        $warehouse = Warehouse::find($id);
        $supplier = Supplier::find($purchase->supplier_id);
        $details = DB::table('purchases as ps')
            ->join('purchase_details as d', 'ps.id', '=', 'd.purchase_id')
            ->join('products as p', 'p.id', '=', 'd.product_id')
            ->where('ps.id', $id)
            ->select('p.id', 'p.name', 'd.qty', 'd.price', 'd.discount', 'd.vat')
            ->get();
        return view("pages.purchases.show", ["purchases" => $purchase, "warehouse" => $warehouse, "supplier" => $supplier, "details" => $details]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        $suppliers = Supplier::all();
        $products = Product::all();
        $warehouses = Warehouse::all();
        $purchaseDetails = PurchaseDetail::where('purchase_id', $id)->get();

        return view("pages.purchases.edit", compact('purchase', 'suppliers', 'products', 'warehouses', 'purchaseDetails'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'shipping_address' => 'required|string|max:255',
            'purchase_total' => 'required|numeric',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->update($request->only([
            'supplier_id',
            'shipping_address',
            'purchase_total',
            'paid_amount',
            'status_id',
            'discount',
            'vat',
            'remark',
            'warehouse_id',
            'purchase_date',
            'delivery_date'
        ]));

        // Clear old details and insert new
        PurchaseDetail::where('purchase_id', $id)->delete();
        foreach ($request->items as $item) {
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'vat' => $item['vat'] ?? 0,
                'discount' => $item['discount'] ?? 0,
            ]);
        }

        return redirect('purchases')->with('success', 'Purchase updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $purchase = Purchase::find($id);
        $warehouse = Warehouse::find($id);
        $supplier = Supplier::find($purchase->supplier_id);
        $details = DB::table('purchases as ps')
            ->join('purchase_details as d', 'ps.id', '=', 'd.purchase_id')
            ->join('products as p', 'p.id', '=', 'd.product_id')
            ->where('ps.id', $id)
            ->select('p.id', 'p.name', 'd.qty', 'd.price', 'd.discount', 'd.vat')
            ->get();
        return view("pages.purchases.delete", ["purchase" => $purchase, "warehouse" => $warehouse, "supplier" => $supplier, "details" => $details]);
    }
    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();
        PurchaseDetail::where('purchase_id', $id)->delete();
        return redirect("purchases");
    }
}
