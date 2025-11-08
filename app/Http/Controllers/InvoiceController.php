<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  


    public function index()
    {
         $invoices=DB::table('invoices as i')
                ->join('customers as c','c.id','=','i.customer_id')
                ->select('i.id','i.customer_id','i.created_at','i.invoice_total','i.shipping_address','c.name as customer')
                ->get();
        //  $invoices=Invoice::all();
        return view("pages.invoices.index",["invoices"=>$invoices]);
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        $customers=Customer::all();
        $products=Product::all();

        return view("pages.invoices.create",["customers"=>$customers,"products"=>$products]);
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
        $invoice=Invoice::find($id);        
        $customer=Customer::find($invoice->customer_id);       
        $details = DB::table('invoices as i')
        ->join('invoice_details as d', 'i.id', '=', 'd.invoice_id')
        ->join('products as p','p.id','=','d.product_id')
        ->where('i.id',$id)
        ->select('p.id', 'p.name','d.qty','d.price','d.discount','d.vat')
        ->get();

        return view("pages.invoices.show",["invoice"=>$invoice,"details"=>$details,"customer"=>$customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function delete(string $id)
    {
        $invoice=Invoice::find($id);        
        $customer=Customer::find($invoice->customer_id);       
        $details = DB::table('invoices as i')
        ->join('invoice_details as d', 'i.id', '=', 'd.invoice_id')
        ->join('products as p','p.id','=','d.product_id')
        ->where('i.id',$id)
        ->select('p.id', 'p.name','d.qty','d.price','d.discount','d.vat')
        ->get();

        return view("pages.invoices.delete",["invoice"=>$invoice,"details"=>$details,"customer"=>$customer]);
    
    }
    public function destroy(string $id)
    {
        $invoice=Invoice::find($id);
         $invoice->delete();         
         InvoiceDetail::where('invoice_id',$id)->delete();
         return redirect("invoices");
    }
}
