@extends('layouts.master')
@section('page')

<?php
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Warehouse;

$suppliers = Supplier::all();
$products = Product::all();
$warehouses = Warehouse::all();
?>

<style>
  body {
    background-color: #f2f4f8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .invoice-header {
    background: linear-gradient(135deg, #2c3e50, #4ca1af);
    padding: 20px 30px;
    border-radius: 12px;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 30px;
  }

  .card {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.05);
  }

  h1 {
    color: white;
    font-weight: bold;
  }

  h2, h5 {
    color: #0d6efd;
    font-weight: 600;
  }

  .form-label {
    font-weight: 600;
    color: #495057;
  }

  .form-control, .form-select, textarea {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    transition: all 0.2s ease-in-out;
  }

  input:focus, select:focus, textarea:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2);
  }

  .table {
    background-color: #fff;
    border-radius: 0.5rem;
    overflow: hidden;
  }

  .table th, .table td {
    vertical-align: middle !important;
    text-align: center;
  }

  .table th {
    background: linear-gradient(135deg, #2c3e50, #4ca1af);
    color: #fff;
  }

  .total-field {
    background-color: #e9ecef;
    font-weight: 600;
    text-align: right;
  }

  .btn {
    transition: all 0.2s ease-in-out;
    font-weight: 500;
    border-radius: 0.375rem;
  }

  .btn-outline-primary:hover {
    background-color: #0d6efd;
    color: #fff;
    transform: scale(1.03);
  }

  .btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
    transform: scale(1.03);
  }

  .btn-success:hover {
    background-color: #198754;
    color: #fff;
    transform: scale(1.03);
  }

  #addItem {
    font-size: 0.95rem;
    padding: 0.45rem 1rem;
  }

  .item-row:hover {
    background-color: #f8f9fa;
  }

  .text-end h5 {
    font-size: 1.2rem;
    color: #212529;
  }

  @media (max-width: 768px) {
    .form-label {
      font-size: 0.9rem;
    }

    h2 {
      font-size: 1.5rem;
    }

    #addItem, .btn-success {
      width: 100%;
    }
  }
</style>

<div class="container py-5">
  <div class="card shadow rounded-4 p-4 bg-light border-0">
    <div class="invoice-header">
      <h1 class="mb-0 fw-bold">Manage Purchase Order</h1>
    </div>

    <form id="purchaseForm">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Supplier</label>
          <div class="form-control-plaintext">{{$supplier->name}}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Purchase Date</label>
          <div class="form-control-plaintext">{{ date("d-M-Y", strtotime($purchase->purchase_date)) }}</div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Warehouse</label>
        <div class="form-control-plaintext">{{$warehouse->name ?? 'N/A'}}</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Shipping Address</label>
        <div class="form-control-plaintext">{{$purchase->shipping_address}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label">Purchase Total</label>
          <div class="form-control-plaintext">{{$purchase->purchase_total}}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label">Status ID</label>
          <div class="form-control-plaintext">{{$purchase->status_id}}</div>
        </div>
        <div class="col-md-4">
          <label class="form-label">Paid Amount</label>
          <div class="form-control-plaintext">{{$purchase->paid_amount}}</div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Discount</label>
          <div class="form-control-plaintext">{{$purchase->discount}}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">VAT</label>
          <div class="form-control-plaintext">{{$purchase->vat}}%</div>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Remark</label>
        <div class="form-control-plaintext">{{$purchase->remark}}</div>
      </div>

      <h5 class="mb-3">Purchase Items</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Product</th>
              <th>Qty</th>
              <th>Price</th>
              <th>VAT</th>
              <th>Discount</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($details as $index => $detail)
            <tr class="item-row">
              <td>{{ $index + 1 }}</td>
              <td>{{ $detail->name }}</td>
              <td>{{ $detail->qty }}</td>
              <td>{{ number_format($detail->price, 2) }}</td>
              <td>{{ $detail->vat }}%</td>
              <td>{{ $detail->discount }}</td>
              <td>{{ number_format(($detail->qty * $detail->price), 2) }}</td>
            </tr>
            @endforeach
          </tbody>
          
        </table>
       
      </div>
    </form>
    <div>
      <form action="{{url("purchases/$purchase->id")}}" method="post">
       @csrf
      @method('DELETE')
      <input class="btn btn-danger" type="submit" value="Delete" />
     </form>

   </div>


   
  </div>
</div>





@endsection
