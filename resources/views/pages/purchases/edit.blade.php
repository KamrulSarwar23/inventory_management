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

  .product-select {
    min-width: 200px;
  }

  @media (max-width: 768px) {
    .form-label {
      font-size: 0.9rem;
    }

    #addItem, .btn-success {
      width: 100%;
    }
  }
</style>

<div class="container py-5">
  <div class="card shadow rounded-4 p-4 bg-light border-0">
    <div class="invoice-header">
      <h1 class="mb-4 fw-bold">Edit Purchase Order #{{ $purchase->id }}</h1>
    </div>

    <form action="{{ url('purchases/' . $purchase->id) }}" method="POST" id="purchaseForm">
      @csrf
      @method('PUT')

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Supplier</label>
          <select class="form-select" name="supplier_id" required>
            <option value="">Select Supplier</option>
            @foreach ($suppliers as $supplier)
              <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                {{ $supplier->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Purchase Date</label>
          <input type="datetime-local" name="purchase_date" class="form-control"
                 value="{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d\TH:i') }}" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">Delivery Date</label>
          <input type="datetime-local" name="delivery_date" class="form-control"
                 value="{{ \Carbon\Carbon::parse($purchase->delivery_date)->format('Y-m-d\TH:i') }}" required />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Warehouse</label>
          <select class="form-select" name="warehouse_id" required>
            <option value="">Select Warehouse</option>
            @foreach ($warehouses as $warehouse)
              <option value="{{ $warehouse->id }}" {{ $purchase->warehouse_id == $warehouse->id ? 'selected' : '' }}>
                {{ $warehouse->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select class="form-select" name="status" required>
            <option value="pending" {{ $purchase->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $purchase->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancel" {{ $purchase->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Shipping Address</label>
        <textarea class="form-control" name="shipping_address" rows="2" required>{{ $purchase->shipping_address }}</textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label">Purchase Total</label>
          <input type="number" step="0.01" name="purchase_total" class="form-control" value="{{ $purchase->purchase_total }}" required readonly />
        </div>
        <div class="col-md-4">
          <label class="form-label">Paid Amount</label>
          <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ $purchase->paid_amount }}" />
        </div>
        <div class="col-md-4">
          <label class="form-label">Remaining Amount</label>
          <input type="number" step="0.01" name="remaining_amount" class="form-control" value="{{ $purchase->purchase_total - $purchase->paid_amount }}" readonly />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Discount</label>
          <input type="number" step="0.01" name="discount" class="form-control" value="{{ $purchase->discount }}" />
        </div>
        <div class="col-md-6">
          <label class="form-label">VAT</label>
          <input type="number" step="0.01" name="vat" class="form-control" value="{{ $purchase->vat }}" />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Remark</label>
        <textarea class="form-control" name="remark" rows="2">{{ $purchase->remark }}</textarea>
      </div>

      <h5 class="mb-3">Purchase Items</h5>
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary text-center">
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>VAT</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="itemsContainer">
          @foreach ($purchaseDetails as $index => $item)
            <tr class="item-row">
              <td class="serial text-center">{{ $index + 1 }}</td>
              <td>
                <select class="form-select product-select" name="items[{{ $index }}][product_id]" required>
                  <option value="">Select Product</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" 
                            data-price="{{ $product->price ?? 0 }}"
                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                      {{ $product->name }}
                    </option>
                  @endforeach
                </select>
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][qty]" class="form-control calc" 
                       value="{{ $item->qty }}" required min="1" step="1">
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][price]" class="form-control calc price-input" 
                       value="{{ $item->price }}" required step="0.01" min="0">
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][vat]" class="form-control calc" 
                       value="{{ $item->vat }}" step="0.01" min="0">
              </td>
              <td>
                <input type="number" name="items[{{ $index }}][discount]" class="form-control calc" 
                       value="{{ $item->discount }}" step="0.01" min="0">
              </td>
              <td>
                <input type="text" class="form-control total-field" readonly 
                       value="{{ number_format(($item->qty * $item->price) + $item->vat - $item->discount, 2) }}">
              </td>
              <td>
                @if($index > 0)
                  <button type="button" class="btn btn-outline-danger remove-item">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                @else
                  <button type="button" class="btn btn-outline-danger" disabled>
                    <i class="fa-solid fa-trash"></i>
                  </button>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="text-end mb-4">
        <h5>Grand Total: <span id="grandTotal">{{ number_format($purchase->purchase_total, 2) }}</span> ৳</h5>
      </div>

      <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-outline-primary mb-3" id="addItem">
          <i class="fa-solid fa-plus me-2"></i>Add Item
        </button>
        <div>
          <a href="{{ url('purchases') }}" class="btn btn-secondary me-2">
            <i class="fa-solid fa-arrow-left me-2"></i>Cancel
          </a>
          <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-check me-2"></i>Update Purchase
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
let itemIndex = {{ count($purchaseDetails) }};

function updateSerials() {
  document.querySelectorAll('.serial').forEach((el, i) => el.textContent = i + 1);
}

function createRow(index) {
  return `
    <tr class="item-row">
      <td class="serial text-center">${index + 1}</td>
      <td>
        <select class="form-select product-select" name="items[${index}][product_id]" required>
          <option value="">Select Product</option>
          @foreach ($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price ?? 0 }}">
              {{ $product->name }}
            </option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="items[${index}][qty]" class="form-control calc" value="1" required min="1" step="1"></td>
      <td><input type="number" name="items[${index}][price]" class="form-control calc price-input" value="0" required step="0.01" min="0"></td>
      <td><input type="number" name="items[${index}][vat]" class="form-control calc" value="0" step="0.01" min="0"></td>
      <td><input type="number" name="items[${index}][discount]" class="form-control calc" value="0" step="0.01" min="0"></td>
      <td><input type="text" class="form-control total-field" readonly value="0.00"></td>
      <td><button type="button" class="btn btn-outline-danger remove-item"><i class="fa-solid fa-trash"></i></button></td>
    </tr>`;
}

function calculateTotals() {
  let grandTotal = 0;
  document.querySelectorAll('#itemsContainer .item-row').forEach(row => {
    const qty = parseFloat(row.querySelector('[name$="[qty]"]').value) || 0;
    const price = parseFloat(row.querySelector('[name$="[price]"]').value) || 0;
    const vat = parseFloat(row.querySelector('[name$="[vat]"]').value) || 0;
    const discount = parseFloat(row.querySelector('[name$="[discount]"]').value) || 0;
    const total = (qty * price) + vat - discount;
    row.querySelector('.total-field').value = total.toFixed(2);
    grandTotal += total;
  });
  
  document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
  document.querySelector('[name="purchase_total"]').value = grandTotal.toFixed(2);
  
  // Calculate remaining amount
  const paidAmount = parseFloat(document.querySelector('[name="paid_amount"]').value) || 0;
  document.querySelector('[name="remaining_amount"]').value = (grandTotal - paidAmount).toFixed(2);
}

// Add event listener for product selection to auto-fill price
document.addEventListener('change', function (e) {
  if (e.target.classList.contains('product-select')) {
    const selectedOption = e.target.options[e.target.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const priceInput = e.target.closest('tr').querySelector('.price-input');
    if (price && priceInput && !priceInput.value) {
      priceInput.value = price;
      calculateTotals();
    }
  }
});

document.getElementById('addItem').addEventListener('click', function () {
  document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', createRow(itemIndex));
  itemIndex++;
  updateSerials();
  calculateTotals();
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
    const removeBtn = e.target.classList.contains('remove-item') ? e.target : e.target.closest('.remove-item');
    if (document.querySelectorAll('.item-row').length > 1) {
      removeBtn.closest('tr').remove();
      updateSerials();
      calculateTotals();
    } else {
      alert('At least one item is required.');
    }
  }
});

document.addEventListener('input', function (e) {
  if (e.target.classList.contains('calc')) {
    calculateTotals();
  }
  
  if (e.target.name === 'paid_amount') {
    calculateTotals();
  }
});

// Initialize calculations on page load
document.addEventListener('DOMContentLoaded', function() {
  calculateTotals();
});

// Form validation
document.getElementById('purchaseForm').addEventListener('submit', function (e) {
  const items = document.querySelectorAll('.item-row');
  if (items.length === 0) {
    e.preventDefault();
    alert('Please add at least one item to the purchase.');
    return;
  }
  
  let hasErrors = false;
  document.querySelectorAll('.item-row').forEach((row, index) => {
    const productSelect = row.querySelector('[name$="[product_id]"]');
    const qtyInput = row.querySelector('[name$="[qty]"]');
    const priceInput = row.querySelector('[name$="[price]"]');
    
    if (!productSelect.value) {
      hasErrors = true;
      productSelect.focus();
    } else if (!qtyInput.value || parseFloat(qtyInput.value) <= 0) {
      hasErrors = true;
      qtyInput.focus();
    } else if (!priceInput.value || parseFloat(priceInput.value) < 0) {
      hasErrors = true;
      priceInput.focus();
    }
  });
  
  if (hasErrors) {
    e.preventDefault();
    alert('Please check all item fields. Product, Quantity, and Price are required.');
  }
});
</script>

@endsection