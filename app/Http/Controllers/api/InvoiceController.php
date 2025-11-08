<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = DB::table('invoices as i')
            ->join('customers as c', 'c.id', '=', 'i.customer_id')
            ->select(
                'i.id',
                'i.customer_id',
                'i.created_at',
                'i.invoice_total',
                'i.shipping_address',
                'c.name as customer'
            )
            ->get();

        return response()->json([
            'success' => true,
            'invoices' => $invoices
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_total' => 'required|numeric|min:0',
            'paid_total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $invoice = new Invoice();
            $invoice->customer_id = $request->customer_id;
            $invoice->invoice_total = $request->invoice_total;
            $invoice->shipping_address = $request->shipping_address ?? 'N/A';
            $invoice->paid_total = $request->paid_total;
            $invoice->remark = $request->remark ?? 'N/A';
            $invoice->discount = $request->discount ?? 0;
            // Laravel sets created_at automatically if you have timestamps enabled
            $invoice->save();

            foreach ($request->items as $product) {
                $detail = new InvoiceDetail();
                $detail->invoice_id = $invoice->id;
                $detail->product_id = $product['id'];
                $detail->qty = $product['qty'];
                $detail->price = $product['price'];
                $detail->vat = $product['vat'] ?? 0;
                $detail->discount = $product['discount'] ?? 0;
                $detail->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'invoice' => $invoice
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
