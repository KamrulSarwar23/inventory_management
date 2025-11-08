@extends('layouts.master')
@section('page')

<?php
use App\Models\Customer;
use App\Models\Order;
?>

<div class="container py-5">
  <div class="order-card">
    <div class="order-header">
      <h1>Edit Order #{{ $order->id }}</h1>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Please fix the following errors:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST" id="orderForm">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <div class="form-group">
          <label>Customer <span class="required">*</span></label>
          <select name="customer_id" class="form-input @error('customer_id') is-invalid @enderror" required>
            @foreach($customers as $cust)
              <option value="{{ $cust->id }}" {{ $cust->id == old('customer_id', $order->customer_id) ? 'selected' : '' }}>
                {{ $cust->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label>Order Date <span class="required">*</span></label>
          <input type="date" name="order_date" value="{{ old('order_date', $order->order_date->format('Y-m-d')) }}" 
                 class="form-input @error('order_date') is-invalid @enderror" required>
        </div>

        <div class="form-group">
          <label>Delivery Date <span class="required">*</span></label>
          <input type="date" name="delivery_date" value="{{ old('delivery_date', $order->delivery_date ? $order->delivery_date->format('Y-m-d') : '') }}" 
                 class="form-input @error('delivery_date') is-invalid @enderror" required>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label>Shipping Address</label>
          <textarea name="shipping_address" class="form-input @error('shipping_address') is-invalid @enderror" rows="2">{{ old('shipping_address', $order->shipping_address) }}</textarea>
        </div>

        <div class="form-group">
          <label>Remark</label>
          <textarea name="remark" class="form-input @error('remark') is-invalid @enderror" rows="2">{{ old('remark', $order->remark) }}</textarea>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label>Order Total <span class="required">*</span></label>
          <input type="number" step="0.01" name="order_total" class="form-input @error('order_total') is-invalid @enderror" 
                 id="order_total_input" value="{{ old('order_total', $order->order_total) }}" readonly required>
        </div>

        <div class="form-group">
          <label>Paid Amount</label>
          <input type="number" step="0.01" name="paid_amount" class="form-input @error('paid_amount') is-invalid @enderror" 
                 value="{{ old('paid_amount', $order->paid_amount) }}">
        </div>

        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-input @error('status') is-invalid @enderror">
            @foreach(App\Models\Order::getStatuses() as $value => $label)
              <option value="{{ $value }}" {{ old('status', $order->status) == $value ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label>Order Discount</label>
          <input type="number" step="0.01" name="discount" class="form-input @error('discount') is-invalid @enderror" 
                 value="{{ old('discount', $order->discount) }}" id="order_discount">
        </div>

        <div class="form-group">
          <label>Order VAT</label>
          <input type="number" step="0.01" name="vat" class="form-input @error('vat') is-invalid @enderror" 
                 value="{{ old('vat', $order->vat) }}" id="order_vat">
        </div>
      </div>

      <div class="section-divider"></div>

      <div class="section-header">
        <h2>Order Items <span class="required">*</span></h2>
        <button type="button" id="addItem" class="btn-add">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M8 3V13M3 8H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Add Item
        </button>
      </div>

      <div class="table-container">
        <table class="items-table">
          <thead>
            <tr>
              <th style="width: 40px">#</th>
              <th>Product</th>
              <th style="width: 100px">Qty</th>
              <th style="width: 120px">Price</th>
              <th style="width: 100px">VAT</th>
              <th style="width: 100px">Discount</th>
              <th style="width: 120px">Total</th>
              <th style="width: 60px"></th>
            </tr>
          </thead>
          <tbody id="order-items">
            @foreach($order->details as $index => $detail)
            <tr class="item-row">
              <td class="serial">{{ $index + 1 }}</td>
              <td>
                <select name="items[{{ $index }}][product_id]" class="form-input product-select" required>
                  <option value="">Select Product</option>
                  @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" 
                      {{ $product->id == $detail->product_id ? 'selected' : '' }}>
                      {{ $product->name }}
                    </option>
                  @endforeach
                </select>
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][qty]" value="{{ $detail->qty }}" 
                       class="form-input qty calc" required min="1" step="0.01">
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][price]" value="{{ $detail->price }}" 
                       class="form-input price calc" required min="0" step="0.01">
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][vat]" value="{{ $detail->vat }}" 
                       class="form-input vat calc" min="0" step="0.01">
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][discount]" value="{{ $detail->discount }}" 
                       class="form-input discount calc" min="0" step="0.01">
              </td>
              <td>
                <input type="text" class="form-input item-total" readonly 
                       value="{{ number_format(($detail->qty * $detail->price) + $detail->vat - $detail->discount, 2) }}">
              </td>
              <td>
                <button type="button" class="btn-remove remove-item" 
                        {{ $order->details->count() <= 1 ? 'disabled' : '' }}>
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M3 4H13M5 4V3C5 2.44772 5.44772 2 6 2H10C10.5523 2 11 2.44772 11 3V4M6.5 7V11M9.5 7V11M4 4H12V13C12 13.5523 11.5523 14 11 14H5C4.44772 14 4 13.5523 4 13V4Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                  </svg>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="summary-section">
        <div class="summary-row">
          <span>Subtotal</span>
          <span id="subtotal">{{ number_format($order->order_total + $order->discount - $order->vat, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Order Discount</span>
          <span id="display_discount">{{ number_format($order->discount, 2) }}</span>
        </div>
        <div class="summary-row">
          <span>Order VAT</span>
          <span id="display_vat">{{ number_format($order->vat, 2) }}</span>
        </div>
        <div class="summary-row total">
          <span>Grand Total</span>
          <span id="grand-total">{{ number_format($order->order_total, 2) }}</span>
        </div>
      </div>

      <div class="form-actions">
        <a href="{{ route('orders.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary" id="submitBtn">Update Order</button>
      </div>
    </form>
  </div>
</div>

<script>
let itemIndex = {{ $order->details->count() }};

function initializeEventListeners() {
  document.querySelectorAll('.calc').forEach(input => {
    input.addEventListener('input', updateTotals);
  });
  
  document.querySelectorAll('.product-select').forEach(select => {
    select.addEventListener('change', function(e) {
      const selectedOption = e.target.options[e.target.selectedIndex];
      const price = selectedOption.getAttribute('data-price');
      const priceInput = e.target.closest('tr').querySelector('.price');
      if (price && !priceInput.value) {
        priceInput.value = price;
      }
      updateTotals();
    });
  });

  document.getElementById('order_discount').addEventListener('input', updateTotals);
  document.getElementById('order_vat').addEventListener('input', updateTotals);
}

function updateSerials() {
  document.querySelectorAll('.serial').forEach((el, i) => el.textContent = i + 1);
}

function updateTotals() {
  let subtotal = 0;
  
  document.querySelectorAll('#order-items .item-row').forEach(row => {
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const vat = parseFloat(row.querySelector('.vat').value) || 0;
    const discount = parseFloat(row.querySelector('.discount').value) || 0;
    
    const itemTotal = (qty * price) + vat - discount;
    row.querySelector('.item-total').value = itemTotal.toFixed(2);
    subtotal += itemTotal;
  });
  
  const orderDiscount = parseFloat(document.getElementById('order_discount').value) || 0;
  const orderVat = parseFloat(document.getElementById('order_vat').value) || 0;
  
  const grandTotal = subtotal - orderDiscount + orderVat;
  
  document.getElementById('subtotal').textContent = subtotal.toFixed(2);
  document.getElementById('display_discount').textContent = orderDiscount.toFixed(2);
  document.getElementById('display_vat').textContent = orderVat.toFixed(2);
  document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
  document.getElementById('order_total_input').value = grandTotal.toFixed(2);
  
  const removeButtons = document.querySelectorAll('.remove-item');
  removeButtons.forEach(btn => {
    btn.disabled = removeButtons.length <= 1;
  });
}

function createRow(index) {
  return `
    <tr class="item-row">
      <td class="serial">${index + 1}</td>
      <td>
        <select name="items[${index}][product_id]" class="form-input product-select" required>
          <option value="">Select Product</option>
          @foreach($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="items[${index}][qty]" value="1" class="form-input qty calc" required min="1" step="0.01"></td>
      <td><input type="number" name="items[${index}][price]" value="0" class="form-input price calc" required min="0" step="0.01"></td>
      <td><input type="number" name="items[${index}][vat]" value="0" class="form-input vat calc" min="0" step="0.01"></td>
      <td><input type="number" name="items[${index}][discount]" value="0" class="form-input discount calc" min="0" step="0.01"></td>
      <td><input type="text" class="form-input item-total" readonly value="0.00"></td>
      <td>
        <button type="button" class="btn-remove remove-item">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M3 4H13M5 4V3C5 2.44772 5.44772 2 6 2H10C10.5523 2 11 2.44772 11 3V4M6.5 7V11M9.5 7V11M4 4H12V13C12 13.5523 11.5523 14 11 14H5C4.44772 14 4 13.5523 4 13V4Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </button>
      </td>
    </tr>`;
}

document.getElementById('addItem').addEventListener('click', function() {
  const table = document.getElementById('order-items');
  table.insertAdjacentHTML('beforeend', createRow(itemIndex));
  itemIndex++;
  updateSerials();
  initializeEventListeners();
  updateTotals();
});

document.addEventListener('click', function(e) {
  if (e.target.closest('.remove-item')) {
    const row = e.target.closest('.item-row');
    if (document.querySelectorAll('#order-items .item-row').length > 1) {
      row.remove();
      updateSerials();
      updateTotals();
    } else {
      alert('At least one item is required!');
    }
  }
});

document.getElementById('orderForm').addEventListener('submit', function(e) {
  const submitBtn = document.getElementById('submitBtn');
  
  const hasValidItems = Array.from(document.querySelectorAll('.product-select')).some(select => select.value !== '');
  if (!hasValidItems) {
    e.preventDefault();
    alert('Please select at least one product!');
    return;
  }
  
  submitBtn.innerHTML = '<span style="opacity: 0.7">Updating...</span>';
  submitBtn.disabled = true;
});

document.addEventListener('DOMContentLoaded', function() {
  initializeEventListeners();
  updateTotals();
});
</script>

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

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  margin-bottom: 6px;
}

.required {
  color: #ef4444;
}

.form-input {
  height: 40px;
  padding: 0 12px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  color: #111827;
  background: white;
  transition: all 0.15s ease;
}

.form-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

textarea.form-input {
  height: auto;
  padding: 10px 12px;
  resize: vertical;
}

.section-divider {
  height: 1px;
  background: #e5e7eb;
  margin: 32px 0;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.section-header h2 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  color: #111827;
}

.btn-add {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: white;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  cursor: pointer;
  transition: all 0.15s ease;
}

.btn-add:hover {
  background: #f9fafb;
  border-color: #9ca3af;
}

.table-container {
  overflow-x: auto;
  margin-bottom: 24px;
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
}

.items-table .serial {
  text-align: center;
  color: #6b7280;
}

.items-table .item-row:last-child td {
  border-bottom: none;
}

.items-table .form-input {
  width: 100%;
}

.item-total {
  background: #f9fafb !important;
  font-weight: 500;
  text-align: right;
  color: #111827;
}

.btn-remove {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 4px;
  color: #6b7280;
  cursor: pointer;
  transition: all 0.15s ease;
}

.btn-remove:hover:not(:disabled) {
  background: #fef2f2;
  border-color: #fecaca;
  color: #ef4444;
}

.btn-remove:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.summary-section {
  max-width: 400px;
  margin-left: auto;
  margin-bottom: 32px;
  padding: 20px;
  background: #f9fafb;
  border-radius: 6px;
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

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding-top: 24px;
  border-top: 1px solid #e5e7eb;
}

.btn-primary, .btn-secondary {
  padding: 10px 24px;
  font-size: 14px;
  font-weight: 500;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.15s ease;
  text-decoration: none;
  display: inline-block;
}

.btn-primary {
  background: #3b82f6;
  color: white;
  border: none;
}

.btn-primary:hover:not(:disabled) {
  background: #2563eb;
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-secondary {
  background: white;
  color: #374151;
  border: 1px solid #d1d5db;
}

.btn-secondary:hover {
  background: #f9fafb;
}

.alert {
  padding: 12px 16px;
  border-radius: 6px;
  margin-bottom: 20px;
}

.alert-danger {
  background: #fef2f2;
  border: 1px solid #fecaca;
  color: #991b1b;
}

@media (max-width: 768px) {
  .order-card {
    padding: 20px;
  }
  
  .form-grid {
    grid-template-columns: 1fr;
  }
  
  .section-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  
  .table-container {
    font-size: 12px;
  }
  
  .items-table th,
  .items-table td {
    padding: 8px;
  }
}
</style>

@endsection