@extends('layouts.master')
@section('page')

<?php
use App\Models\Customer;
use App\Models\Order;
?>

<div class="container py-5">
  <div class="order-card">
    <div class="order-header">
      <h1>Order #{{ $order->id }}</h1>
      <div class="header-actions">
        <a href="{{ route('orders.index') }}" class="btn-secondary">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M8 2L2 8L8 14M2 8H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Back
        </a>
        <a href="{{ route('orders.edit', $order->id) }}" class="btn-primary">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M11.5 2L14 4.5L5 13.5L2 14L2.5 11L11.5 2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Edit
        </a>
      </div>
    </div>

    <div class="info-grid">
      <div class="info-section">
        <div class="section-title">Customer Information</div>
        <div class="info-list">
          <div class="info-item">
            <span class="info-label">Name</span>
            <span class="info-value">{{ $order->customer->name ?? 'N/A' }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $order->customer->email ?? 'N/A' }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Phone</span>
            <span class="info-value">{{ $order->customer->mobile ?? 'N/A' }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Address</span>
            <span class="info-value">{{ $order->customer->address ?? 'N/A' }}</span>
          </div>
        </div>
      </div>

      <div class="info-section">
        <div class="section-title">Order Information</div>
        <div class="info-list">
          <div class="info-item">
            <span class="info-label">Order Date</span>
            <span class="info-value">{{ $order->order_date->format('d M Y') }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Delivery Date</span>
            <span class="info-value">{{ $order->delivery_date ? $order->delivery_date->format('d M Y') : 'Not set' }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status</span>
            <span class="info-value">
              @php
                $statusClasses = [
                  'pending' => 'status-pending',
                  'processing' => 'status-processing',
                  'completed' => 'status-completed',
                  'cancelled' => 'status-cancelled'
                ];
                $statusNames = [
                  'pending' => 'Pending',
                  'processing' => 'Processing',
                  'completed' => 'Completed',
                  'cancelled' => 'Cancelled'
                ];
              @endphp
              <span class="status-badge {{ $statusClasses[$order->status] ?? '' }}">
                {{ $statusNames[$order->status] ?? 'Unknown' }}
              </span>
            </span>
          </div>
          <div class="info-item">
            <span class="info-label">Shipping Address</span>
            <span class="info-value">{{ $order->shipping_address ?? 'Same as customer address' }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="section-divider"></div>

    <div class="section-header">
      <h2>Order Items</h2>
    </div>

    <div class="table-container">
      <table class="items-table">
        <thead>
          <tr>
            <th style="width: 40px">#</th>
            <th>Product</th>
            <th style="width: 100px">Quantity</th>
            <th style="width: 120px">Unit Price</th>
            <th style="width: 100px">VAT</th>
            <th style="width: 100px">Discount</th>
            <th style="width: 120px">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->details as $index => $detail)
          <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $detail->product->name ?? 'N/A' }}</td>
            <td class="text-center">{{ $detail->qty }}</td>
            <td class="text-right">{{ number_format($detail->price, 2) }}</td>
            <td class="text-right">{{ number_format($detail->vat, 2) }}</td>
            <td class="text-right">{{ number_format($detail->discount, 2) }}</td>
            <td class="text-right total-cell">
              {{ number_format(($detail->qty * $detail->price) + $detail->vat - $detail->discount, 2) }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="summary-container">
      <div class="summary-section">
        <div class="summary-row">
          <span>Subtotal</span>
          <span>{{ number_format($order->order_total + $order->discount - $order->vat, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Order Discount</span>
          <span>{{ number_format($order->discount, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Order VAT</span>
          <span>{{ number_format($order->vat, 2) }}</span>
        </div>
        <div class="summary-row total">
          <span>Grand Total</span>
          <span>{{ number_format($order->order_total, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Paid Amount</span>
          <span>{{ number_format($order->paid_amount, 2) }}</span>
        </div>
        @if($order->paid_amount < $order->order_total)
        <div class="summary-row due">
          <span>Due Amount</span>
          <span>{{ number_format($order->order_total - $order->paid_amount, 2) }}</span>
        </div>
        @endif
      </div>
    </div>

    @if($order->remark)
    <div class="remark-section">
      <div class="section-title">Remark</div>
      <p class="remark-text">{{ $order->remark }}</p>
    </div>
    @endif
  </div>
</div>

<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #fafafa;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.order-card {
  max-width: 1200px;
  margin: 0 auto;
  background: white;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  padding: 32px;
}

.order-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e5e7eb;
}

.order-header h1 {
  margin: 0;
  font-size: 24px;
  font-weight: 600;
  color: #111827;
}

.header-actions {
  display: flex;
  gap: 12px;
}

.btn-primary, .btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  font-size: 14px;
  font-weight: 500;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.15s ease;
  text-decoration: none;
}

.btn-primary {
  background: #3b82f6;
  color: white;
  border: none;
}

.btn-primary:hover {
  background: #2563eb;
}

.btn-secondary {
  background: white;
  color: #374151;
  border: 1px solid #d1d5db;
}

.btn-secondary:hover {
  background: #f9fafb;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 24px;
  margin-bottom: 32px;
}

.info-section {
  background: #f9fafb;
  border-radius: 6px;
  padding: 20px;
  border: 1px solid #e5e7eb;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
  color: #111827;
  margin-bottom: 16px;
}

.info-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.info-item {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
}

.info-label {
  font-size: 14px;
  font-weight: 500;
  color: #6b7280;
  min-width: 100px;
}

.info-value {
  font-size: 14px;
  color: #111827;
  text-align: right;
  flex: 1;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 500;
  display: inline-block;
}

.status-pending {
  background: #fef3c7;
  color: #92400e;
}

.status-processing {
  background: #dbeafe;
  color: #1e40af;
}

.status-completed {
  background: #d1fae5;
  color: #065f46;
}

.status-cancelled {
  background: #fee2e2;
  color: #991b1b;
}

.section-divider {
  height: 1px;
  background: #e5e7eb;
  margin: 32px 0;
}

.section-header {
  margin-bottom: 20px;
}

.section-header h2 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #111827;
}

.table-container {
  overflow-x: auto;
  margin-bottom: 32px;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
}

.items-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.items-table thead {
  background: #f9fafb;
}

.items-table th {
  padding: 12px;
  text-align: left;
  font-weight: 600;
  color: #374151;
  border-bottom: 1px solid #e5e7eb;
}

.items-table td {
  padding: 12px;
  border-bottom: 1px solid #f3f4f6;
  color: #374151;
}

.items-table tbody tr:last-child td {
  border-bottom: none;
}

.items-table tbody tr:hover {
  background: #f9fafb;
}

.text-center {
  text-align: center;
}

.text-right {
  text-align: right;
}

.total-cell {
  font-weight: 600;
  color: #111827;
}

.summary-container {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 32px;
}

.summary-section {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  background: #f9fafb;
  border-radius: 6px;
  border: 1px solid #e5e7eb;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  font-size: 14px;
  color: #374151;
}

.summary-row.total {
  margin-top: 12px;
  padding-top: 12px;
  border-top: 2px solid #e5e7eb;
  font-size: 18px;
  font-weight: 600;
  color: #111827;
}

.summary-row.due {
  margin-top: 8px;
  padding-top: 8px;
  border-top: 1px solid #e5e7eb;
  color: #ef4444;
  font-weight: 600;
}

.remark-section {
  background: #f9fafb;
  border-radius: 6px;
  padding: 20px;
  border: 1px solid #e5e7eb;
  margin-top: 32px;
}

.remark-text {
  margin: 0;
  font-size: 14px;
  color: #374151;
  line-height: 1.6;
}

@media print {
  body {
    background: white;
  }

  .order-card {
    border: none;
    box-shadow: none;
  }

  .header-actions {
    display: none;
  }
}

@media (max-width: 768px) {
  .order-card {
    padding: 20px;
  }

  .order-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }

  .info-grid {
    grid-template-columns: 1fr;
  }

  .info-item {
    flex-direction: column;
    gap: 4px;
  }

  .info-label {
    min-width: auto;
  }

  .info-value {
    text-align: left;
  }

  .table-container {
    font-size: 12px;
  }

  .items-table th,
  .items-table td {
    padding: 8px;
  }

  .summary-container {
    justify-content: stretch;
  }

  .summary-section {
    max-width: 100%;
  }
}
</style>

@endsection