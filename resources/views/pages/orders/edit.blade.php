@extends('layouts.master')
@section('page')

<?php
use App\Models\Customer;
use App\Models\Order;
?>

<style>
  body { background-color: #f2f4f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
  .invoice-header { background: linear-gradient(135deg, #2c3e50, #4ca1af); padding: 20px 30px; border-radius: 12px; color: #fff; display: flex; justify-content: center; align-items: center; margin-bottom: 30px; }
  .card { background: #fff; border: 1px solid #dee2e6; border-radius: 1rem; box-shadow: 0 0.5rem 1.2rem rgba(0, 0, 0, 0.05); }
  h1 { color: white; font-weight: bold; }
  h2, h5 { color: #0d6efd; font-weight: 600; }
  .form-label { font-weight: 600; color: #495057; }
  .form-control, .form-select, textarea { border-radius: 0.5rem; border: 1px solid #ced4da; transition: all 0.2s ease-in-out; }
  input:focus, select:focus, textarea:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.2); }
  .table { background-color: #fff; border-radius: 0.5rem; overflow: hidden; }
  .table th, .table td { vertical-align: middle !important; text-align: center; padding: 10px; }
  .table th { background: linear-gradient(135deg, #2c3e50, #4ca1af); color: #fff; }
  .btn { transition: all 0.2s ease-in-out; font-weight: 500; border-radius: 0.375rem; }
  .btn-outline-primary:hover { background-color: #0d6efd; color: #fff; transform: scale(1.03); }
  .btn-outline-danger:hover { background-color: #dc3545; color: #fff; transform: scale(1.03); }
  .btn-success:hover { background-color: #198754; color: #fff; transform: scale(1.03); }
  #addItem { font-size: 0.95rem; padding: 0.45rem 1rem; }
  .item-row:hover { background-color: #f8f9fa; }
  .total-field { font-weight: 600; text-align: right; }
  @media (max-width: 768px) { .form-label { font-size: 0.9rem; } h2 { font-size: 1.5rem; } #addItem, .btn-success { width: 100%; } }
</style>

<div class="container py-5">
  <div class="card shadow rounded-4 p-4 bg-light border-0">
    <div class="invoice-header">
      <h1 class="mb-0 fw-bold">Edit Order</h1>
    </div>
<form action="{{ route('orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Add these hidden fields for order totals -->
    <input type="hidden" name="order_total" id="order_total_input" value="{{ $order->order_total }}">
    <input type="hidden" name="vat" id="vat_input" value="{{ $order->vat }}">

    <!-- Customer & Order Info -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-select">
                @foreach(App\Models\Customer::all() as $cust)
                    <option value="{{ $cust->id }}" {{ $cust->id == $order->customer_id ? 'selected' : '' }}>
                        {{ $cust->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Order Date</label>
            <input type="date" name="order_date" value="{{ $order->order_date ? $order->order_date->format('Y-m-d') : now()->format('Y-m-d') }}" class="form-control">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Delivery Date</label>
            <input type="date" name="delivery_date" value="{{ $order->delivery_date ? $order->delivery_date->format('Y-m-d') : now()->format('Y-m-d') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Shipping Address</label>
            <textarea name="shipping_address" class="form-control">{{ $order->shipping_address }}</textarea>
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
                    <th>Discount</th>
                    <th>VAT</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="order-items">
                @foreach($details as $index => $detail)
                <tr class="item-row">
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <select name="items[{{ $index }}][product_id]" class="form-select product-select">
                            @foreach(App\Models\Product::all() as $product)
                                <option value="{{ $product->id }}" {{ $product->id == $detail->product_id ? 'selected' : '' }} data-price="{{ $product->price }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[{{ $index }}][qty]" value="{{ $detail->qty }}" class="form-control qty"></td>
                    <td><input type="number" name="items[{{ $index }}][price]" value="{{ $detail->price }}" class="form-control price" step="0.01"></td>
                    <td><input type="number" name="items[{{ $index }}][discount]" value="{{ $detail->discount }}" class="form-control discount" step="0.01"></td>
                    <td><input type="number" name="items[{{ $index }}][vat]" value="{{ $detail->vat }}" class="form-control vat" step="0.01"></td>
                    <td class="total-field">{{ number_format($detail->qty * $detail->price, 2) }}</td>
                    <td><button type="button" class="btn btn-outline-danger remove-item">Remove</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="button" id="addItem" class="btn btn-outline-primary mb-3">Add Item</button>

    <!-- Totals -->
    <div class="row justify-content-end">
        <div class="col-md-4">
            <table class="table table-borderless">
                <tr>
                    <td class="total-field">Subtotal</td>
                    <td class="total-field" id="subtotal">{{ number_format($order->order_total, 2) }}</td>
                </tr>
                <tr>
                    <td class="total-field">VAT (%)</td>
                    <td><input type="number" name="vat" value="{{ $order->vat }}" class="form-control" id="vat_percent" step="0.01"></td>
                </tr>
                <tr>
                    <td class="total-field">Grand Total</td>
                    <td class="total-field" id="grand-total">{{ number_format($order->order_total + ($order->order_total * $order->vat / 100), 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="text-end mt-4">
        <button type="submit" class="btn btn-success">Update Order</button>
    </div>
</form>
 
  </div>
</div>

<script>
 let itemIndex = {{ count($details) }};

function updateTotals() {
    let subtotal = 0;
    
    document.querySelectorAll('#order-items tr').forEach(row => {
        let qty = parseFloat(row.querySelector('.qty').value) || 0;
        let price = parseFloat(row.querySelector('.price').value) || 0;
        let discount = parseFloat(row.querySelector('.discount').value) || 0;
        let itemTotal = (qty * price) - discount;
        
        row.querySelector('.total-field').textContent = itemTotal.toFixed(2);
        subtotal += itemTotal;
    });

    let vatPercent = parseFloat(document.getElementById('vat_percent').value) || 0;
    let vatAmount = subtotal * vatPercent / 100;
    let grandTotal = subtotal + vatAmount;

    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
    
    // Update hidden inputs
    document.getElementById('order_total_input').value = subtotal;
}

// Add new row
document.getElementById('addItem').addEventListener('click', function() {
    let table = document.getElementById('order-items');
    let row = table.insertRow();
    row.classList.add('item-row');
    row.innerHTML = `
        <td>${table.rows.length}</td>
        <td>
            <select name="items[${itemIndex}][product_id]" class="form-select product-select">
                @foreach(App\Models\Product::all() as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="items[${itemIndex}][qty]" value="1" class="form-control qty"></td>
        <td><input type="number" name="items[${itemIndex}][price]" value="0" class="form-control price" step="0.01"></td>
        <td><input type="number" name="items[${itemIndex}][discount]" value="0" class="form-control discount" step="0.01"></td>
        <td><input type="number" name="items[${itemIndex}][vat]" value="0" class="form-control vat" step="0.01"></td>
        <td class="total-field">0.00</td>
        <td><button type="button" class="btn btn-outline-danger remove-item">Remove</button></td>
    `;
    itemIndex++;
    
    // Add event listeners to new inputs
    row.querySelectorAll('.qty, .price, .discount').forEach(input => {
        input.addEventListener('input', updateTotals);
    });
});

// Update product price when product selection changes
document.addEventListener('change', function(e) {
    if(e.target && e.target.classList.contains('product-select')) {
        let selectedOption = e.target.options[e.target.selectedIndex];
        let price = selectedOption.getAttribute('data-price');
        let priceInput = e.target.closest('tr').querySelector('.price');
        priceInput.value = price;
        updateTotals();
    }
});

// Update totals on input change
document.addEventListener('input', function(e) {
    if(e.target.classList.contains('qty') || e.target.classList.contains('price') || 
       e.target.classList.contains('discount') || e.target.id === 'vat_percent') {
        updateTotals();
    }
});

// Remove row
document.addEventListener('click', function(e) {
    if(e.target && e.target.classList.contains('remove-item')) {
        e.target.closest('tr').remove();
        updateTotals();
        
        // Renumber rows
        document.querySelectorAll('#order-items tr').forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }
});

// Initial calculation
updateTotals();
</script>

@endsection
