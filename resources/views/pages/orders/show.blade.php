@extends('layouts.master')
@section('page')

<?php
use App\Models\Customer;
use App\Models\Order;
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

  .form-control-plaintext {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    background-color: #e9ecef;
    padding: 8px 12px;
  }

  .table {
    background-color: #fff;
    border-radius: 0.5rem;
    overflow: hidden;
  }

  .table th, .table td {
    vertical-align: middle !important;
    text-align: center;
    padding: 10px;
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
  }
</style>

<div class="container py-5">
  <div class="card shadow rounded-4 p-4 bg-light border-0">
    <div class="invoice-header">
      <h1 class="mb-0 fw-bold">Manage Order</h1>
    </div>

    <form id="orderForm">
      <!-- Customer & Order Info -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Customer Name</label>
          <div class="form-control-plaintext">{{$customer->name}}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Order Date</label>
          <div class="form-control-plaintext">{{ date('d-M-Y', strtotime($order->created_at)) }}</div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <div class="form-control-plaintext">{{$customer->email}}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <div class="form-control-plaintext">{{$customer->mobile}}</div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <div class="form-control-plaintext">{{$customer->address}}</div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Payment Method</label>
          <div class="form-control-plaintext">{{$order->payment_method ?? 'Cash on Delivery'}}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <div class="form-control-plaintext">{{$order->status ?? 'Confirmed'}}</div>
        </div>
      </div>

      <!-- Order Items -->
      <h5 class="mb-3">Order Items</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Product</th>
              <th>Qty</th>
              <th>Unit Price</th>
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
              <td>{{ number_format($detail->qty * $detail->price, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Totals -->
      <div class="row justify-content-end">
        <div class="col-md-4">
          <table class="table table-borderless">
            <tr>
              <td class="total-field">Subtotal</td>
              <td class="total-field">{{ number_format($order->order_total, 2) }}</td>
            </tr>
            <tr>
              <td class="total-field">VAT ({{ $order->vat }}%)</td>
              <td class="total-field">{{ number_format($order->vat_amount ?? 0, 2) }}</td>
            </tr>
            <tr>
              <td class="total-field">Grand Total</td>
              <td class="total-field">{{ number_format($order->grand_total ?? $order->order_total, 2) }}</td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Note -->
      

    </form>
  </div>
</div>

@endsection
