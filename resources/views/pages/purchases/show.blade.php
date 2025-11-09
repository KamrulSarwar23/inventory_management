@extends('layouts.master')
@section('page')

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

  .form-label {
    font-weight: 600;
    color: #495057;
  }

  .form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
    font-weight: 500;
  }

  .table {
    background-color: #fff;
    border-radius: 0.5rem;
    overflow: hidden;
  }

  .table th {
    background: linear-gradient(135deg, #2c3e50, #4ca1af);
    color: #fff;
    text-align: center;
    vertical-align: middle;
  }

  .table td {
    text-align: center;
    vertical-align: middle;
  }

  .status-badge {
    padding: 0.35rem 0.65rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
  }
  
  .status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
  }
  
  .status-completed {
    background-color: #d1edff;
    color: #0c5460;
    border: 1px solid #b8daff;
  }
  
  .status-cancel {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }

  .total-row {
    background-color: #f8f9fa;
    font-weight: 600;
  }

  .btn-print {
    background: linear-gradient(135deg, #2c3e50, #4ca1af);
    color: white;
    border: none;
  }

  .btn-print:hover {
    background: linear-gradient(135deg, #1a252f, #357f8a);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  }

  @media print {
    .no-print {
      display: none !important;
    }
    
    .card {
      border: none;
      box-shadow: none;
    }
    
    .invoice-header {
      background: #2c3e50 !important;
      -webkit-print-color-adjust: exact;
    }
  }
</style>

<div class="container py-5">
  <div class="card shadow rounded-4 p-4 bg-light border-0">
    <div class="invoice-header">
      <h1 class="mb-0 fw-bold">Purchase Order #{{ $purchase->id }}</h1>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end gap-2 mb-4 no-print">
      <a href="{{ url('purchases') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to List
      </a>
      <a href="{{ url('purchases/' . $purchase->id . '/edit') }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i> Edit
      </a>

    </div>

    <div class="row">
      <!-- Purchase Information -->
      <div class="col-md-8">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Supplier</label>
            <div class="form-control-plaintext fw-bold text-dark">{{ $purchase->supplier->name ?? 'N/A' }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Purchase Date</label>
            <div class="form-control-plaintext">{{ date("d-M-Y", strtotime($purchase->purchase_date)) }}</div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Delivery Date</label>
            <div class="form-control-plaintext">{{ date("d-M-Y", strtotime($purchase->delivery_date)) }}</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <div>
              <span class="status-badge status-{{ $purchase->status }}">
                {{ ucfirst($purchase->status) }}
              </span>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Warehouse</label>
          <div class="form-control-plaintext">{{ $purchase->warehouse->name ?? 'N/A' }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Shipping Address</label>
          <div class="form-control-plaintext border rounded p-2 bg-light">{{ $purchase->shipping_address }}</div>
        </div>
      </div>

      <!-- Financial Information -->
      <div class="col-md-4">
        <div class="card bg-light border-0">
          <div class="card-body">
            <h6 class="card-title fw-bold mb-3">Financial Summary</h6>
            
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal:</span>
              <span class="fw-bold">{{ number_format($purchase->purchase_total, 2) }}</span>
            </div>
            
            <div class="d-flex justify-content-between mb-2">
              <span>Discount:</span>
              <span class="fw-bold text-danger">-{{ number_format($purchase->discount, 2) }}</span>
            </div>
            
            <div class="d-flex justify-content-between mb-2">
              <span>VAT ({{ $purchase->vat }}%):</span>
              <span class="fw-bold text-success">+{{ number_format(($purchase->purchase_total * $purchase->vat / 100), 2) }}</span>
            </div>
            
            <hr>
            
            <div class="d-flex justify-content-between mb-2">
              <span>Grand Total:</span>
              <span class="fw-bold fs-5 text-primary">
                {{ number_format($purchase->purchase_total - $purchase->discount + ($purchase->purchase_total * $purchase->vat / 100), 2) }}
              </span>
            </div>
            
            <div class="d-flex justify-content-between mb-2">
              <span>Paid Amount:</span>
              <span class="fw-bold text-success">{{ number_format($purchase->paid_amount, 2) }}</span>
            </div>
            
            <div class="d-flex justify-content-between">
              <span>Due Amount:</span>
              <span class="fw-bold text-danger">
                {{ number_format(($purchase->purchase_total - $purchase->discount + ($purchase->purchase_total * $purchase->vat / 100)) - $purchase->paid_amount, 2) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if($purchase->remark)
    <div class="mb-4">
      <label class="form-label">Remark</label>
      <div class="form-control-plaintext border rounded p-3 bg-light">{{ $purchase->remark }}</div>
    </div>
    @endif

    <!-- Purchase Items -->
    <h5 class="mb-3">Purchase Items</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>VAT</th>
            <th>Discount</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @php
            $subtotal = 0;
          @endphp
          @foreach($details as $index => $detail)
          @php
            $itemTotal = ($detail->qty * $detail->price) + $detail->vat - $detail->discount;
            $subtotal += $itemTotal;
          @endphp
          <tr class="item-row">
            <td>{{ $index + 1 }}</td>
            <td class="text-start">{{ $detail->name }}</td>
            <td>{{ $detail->qty }}</td>
            <td>{{ number_format($detail->price, 2) }}</td>
            <td>{{ number_format($detail->vat, 2) }}</td>
            <td>{{ number_format($detail->discount, 2) }}</td>
            <td class="fw-bold">{{ number_format($itemTotal, 2) }}</td>
          </tr>
          @endforeach
          
          <!-- Summary Row -->
          <tr class="total-row">
            <td colspan="5"></td>
            <td class="text-end fw-bold">Subtotal:</td>
            <td class="fw-bold">{{ number_format($subtotal, 2) }}</td>
          </tr>
          <tr class="total-row">
            <td colspan="5"></td>
            <td class="text-end fw-bold">Discount:</td>
            <td class="fw-bold text-danger">-{{ number_format($purchase->discount, 2) }}</td>
          </tr>
          <tr class="total-row">
            <td colspan="5"></td>
            <td class="text-end fw-bold">VAT:</td>
            <td class="fw-bold text-success">+{{ number_format($purchase->vat, 2) }}</td>
          </tr>
          <tr class="total-row">
            <td colspan="5"></td>
            <td class="text-end fw-bold">Grand Total:</td>
            <td class="fw-bold fs-6 text-primary">{{ number_format($purchase->purchase_total, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Footer Information -->
    <div class="row mt-4 no-print">
      <div class="col-md-6">
        <div class="card border-0 bg-light">
          <div class="card-body">
            <h6 class="card-title fw-bold">Supplier Information</h6>
            <p class="mb-1"><strong>Name:</strong> {{ $purchase->supplier->name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Contact:</strong> {{ $purchase->supplier->phone ?? 'N/A' }}</p>
            <p class="mb-0"><strong>Email:</strong> {{ $purchase->supplier->email ?? 'N/A' }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card border-0 bg-light">
          <div class="card-body">
            <h6 class="card-title fw-bold">Warehouse Information</h6>
            <p class="mb-1"><strong>Name:</strong> {{ $purchase->warehouse->name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Address:</strong> {{ $purchase->warehouse->address ?? 'N/A' }}</p>
            <p class="mb-0"><strong>Contact:</strong> {{ $purchase->warehouse->phone ?? 'N/A' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection