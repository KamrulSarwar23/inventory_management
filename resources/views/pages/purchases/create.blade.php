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

<div class="container py-5">
 
  <div class="card shadow rounded-4 p-4 bg-light border-0">
      <div class="invoice-header ">
        <h1 class=" mb-4 fw-bold ">Create Purchase Order</h1>
      </div>
    <form id="purchaseForm">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Supplier</label>
          <select class="form-select" name="supplier_id" required>
            <option value="">Select Supplier</option>
            @foreach ($suppliers as $supplier)
              <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Purchase Date</label>
          <input type="datetime-local" name="purchase_date" class="form-control" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">Delivery Date</label>
          <input type="datetime-local" name="delivery_date" class="form-control" required />
        </div>
      </div>

      {{-- Warehouse Select --}}
      <div class="mb-3">
        <label class="form-label">Warehouse</label>
        <select class="form-select" name="warehouse_id" required>
          <option value="">Select Warehouse</option>
          @foreach ($warehouses as $warehouse)
            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Shipping Address</label>
        <textarea class="form-control" name="shipping_address" rows="2" required></textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label">Purchase Total</label>
          <input type="number" step="0.01" name="purchase_total" class="form-control" required />
        </div>
        <div class="col-md-4">
          <label class="form-label">Paid Amount</label>
          <input type="number" step="0.01" name="paid_amount" class="form-control" />
        </div>
        <div class="col-md-4">
          <label class="form-label">Status ID</label>
          <input type="number" name="status_id" class="form-control" required />
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Discount</label>
          <input type="number" step="0.01" name="discount" class="form-control" />
        </div>
        <div class="col-md-6">
          <label class="form-label">VAT</label>
          <input type="number" step="0.01" name="vat" class="form-control" />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Remark</label>
        <textarea class="form-control" name="remark" rows="2"></textarea>
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
          <tr class="item-row">
            <td class="serial text-center">1</td>
            <td>
              <select class="form-select" name="items[0][product_id]" required>
                <option value="">Select</option>
                @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </select>
            </td>
            <td><input type="number" name="items[0][qty]" class="form-control calc" required></td>
            <td><input type="number" name="items[0][price]" class="form-control calc" required></td>
            <td><input type="number" name="items[0][vat]" class="form-control calc" value="0"></td>
            <td><input type="number" name="items[0][discount]" class="form-control calc" value="0"></td>
            <td><input type="text" class="form-control total-field" readonly value="0.00"></td>
            <td><button type="button" class="btn btn-outline-danger remove-item"><i class="fa-solid fa-trash"></i></button></td>
          </tr>
        </tbody>
      </table>

      <div class="text-end mb-4">
        <h5>Grand Total: <span id="grandTotal">0.00</span> ৳</h5>
      </div>

      <button type="button" class="btn btn-outline-primary mb-3" id="addItem">+ Add Item</button>
      <button type="submit" class="btn btn-success">Save</button>
    </form>
  </div>
</div>

<script>
let itemIndex = 1;

function updateSerials() {
  document.querySelectorAll('.serial').forEach((el, i) => el.textContent = i + 1);
}

function createRow(index) {
  return `
    <tr class="item-row">
      <td class="serial text-center">${index + 1}</td>
      <td>
        <select class="form-select" name="items[${index}][product_id]" required>
          <option value="">Select</option>
          @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="items[${index}][qty]" class="form-control calc" required></td>
      <td><input type="number" name="items[${index}][price]" class="form-control calc" required></td>
      <td><input type="number" name="items[${index}][vat]" class="form-control calc" value="0"></td>
      <td><input type="number" name="items[${index}][discount]" class="form-control calc" value="0"></td>
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
}

document.getElementById('addItem').addEventListener('click', function () {
  document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', createRow(itemIndex));
  itemIndex++;
  updateSerials();
  calculateTotals();
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('remove-item')) {
    e.target.closest('tr').remove();
    itemIndex--;
    updateSerials();
    calculateTotals();
  }
});

document.addEventListener('input', function (e) {
  if (e.target.classList.contains('calc')) {
    calculateTotals();
  }
});

document.getElementById('purchaseForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);
  const items = [];
  document.querySelectorAll('#itemsContainer .item-row').forEach(row => {
    items.push({
      product_id: row.querySelector('[name$="[product_id]"]').value,
      qty: row.querySelector('[name$="[qty]"]').value,
      price: row.querySelector('[name$="[price]"]').value,
      vat: row.querySelector('[name$="[vat]"]').value,
      discount: row.querySelector('[name$="[discount]"]').value
    });
  });
  const data = {
    supplier_id: formData.get('supplier_id'),
    purchase_date: formData.get('purchase_date'),
    delivery_date: formData.get('delivery_date'),
    warehouse_id: formData.get('warehouse_id'),
    shipping_address: formData.get('shipping_address'),
    purchase_total: formData.get('purchase_total'),
    paid_amount: formData.get('paid_amount'),
    status_id: formData.get('status_id'),
    discount: formData.get('discount'),
    vat: formData.get('vat'),
    remark: formData.get('remark'),
    items: items
  };

  fetch('http://127.0.0.1:8000/api/purchases/', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    },
    body: JSON.stringify(data)
  })
    .then(response => response.ok ? response.json() : response.json().then(err => { throw err; }))
    .then(result => {
      alert('✅ Purchase saved successfully!');
      form.reset();
      document.getElementById('itemsContaine').innerHTML = createRow(0);
      itemIndex = 1;
      updateSerials();
      calculateTotals();
    })
    .catch(error => {
      console.error(' Error:', error);
      alert(' Purchase saved successfully!');
    });
});
</script>

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
  h1{
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


@endsection
