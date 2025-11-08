<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $purchases=Purchase::all();
        $purchases = DB::table('purchases as ps')
            ->join('suppliers as sup', 'sup.id', '=', 'ps.supplier_id')
            ->join('status as st', 'st.id', '=', 'ps.status_id')
            ->select(
                'ps.id',
                'ps.created_at',
                'ps.purchase_total',
                'ps.shipping_address',
                'sup.name as supplier',
                'st.name as status'
            )
            ->get();




        return response()->json(["purchases" => $purchases]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $purchase = new Purchase();

        $purchase->supplier_id = $request->supplier_id;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->delivery_date = $request->delivery_date;
        $purchase->shipping_address = $request->shipping_address;
        $purchase->purchase_total = $request->purchase_total;
        $purchase->paid_amount = $request->paid_amount;  // nullable allowed
        $purchase->remark = $request->remark;
        $purchase->status_id = $request->status_id;    // must be sent and not null

        $purchase->discount = $request->discount ?? 0;
        $purchase->vat = $request->vat ?? 0;

        // Do NOT set created_at or updated_at manually, DB will handle this
        $purchase->save();

        $transaction_type_id = 1; // Example: 1 = Purchase stock IN
        $warehouse_id = $request->warehouse_id ?? 1; // Default warehouse id or from request

        foreach ($request->items as $item) {
            $detail = new PurchaseDetail();
            $detail->purchase_id = $purchase->id;
            $detail->product_id = $item['product_id'];
            $detail->qty = $item['qty'];
            $detail->price = $item['price'];
            $detail->vat = $item['vat'] ?? 0;
            $detail->discount = $item['discount'] ?? 0;
            $detail->save();

            // Save stock entry
            $stock = new Stock();
            $stock->product_id = $item['product_id'];
            $stock->qty = $item['qty'];  // positive quantity for purchase
            $stock->transaction_type_id = $transaction_type_id;
            $stock->remark = "Purchase ID #{$purchase->id}";
            $stock->warehouse_id = $warehouse_id;
            $stock->save();
        }

        return response()->json([
            'message' => 'Purchase created successfully',
            'purchase' => $purchase
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
