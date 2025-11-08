@extends('layouts.master')
@section('page')

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

      <div class="mb-3">
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

      <div class="mb-3">
        <label class="form-label">Shipping Address</label>
        <textarea class="form-control" name="shipping_address" rows="2" required>{{ $purchase->shipping_address }}</textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label">Purchase Total</label>
          <input type="number" step="0.01" name="purchase_total" class="form-control" value="{{ $purchase->purchase_total }}" required />
        </div>
        <div class="col-md-4">
          <label class="form-label">Paid Amount</label>
          <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ $purchase->paid_amount }}" />
        </div>
        <div class="col-md-4">
          <label class="form-label">Status ID</label>
          <input type="number" name="status_id" class="form-control" value="{{ $purchase->status_id }}" required />
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
                <select class="form-select" name="items[{{ $index }}][product_id]" required>
                  <option value="">Select</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                      {{ $product->name }}
                    </option>
                  @endforeach
                </select>
              </td>
              <td><input type="number" name="items[{{ $index }}][qty]" class="form-control calc" value="{{ $item->qty }}" required></td>
              <td><input type="number" name="items[{{ $index }}][price]" class="form-control calc" value="{{ $item->price }}" required></td>
              <td><input type="number" name="items[{{ $index }}][vat]" class="form-control calc" value="{{ $item->vat }}"></td>
              <td><input type="number" name="items[{{ $index }}][discount]" class="form-control calc" value="{{ $item->discount }}"></td>
              <td><input type="text" class="form-control total-field" readonly></td>
              <td><button type="button" class="btn btn-outline-danger remove-item"><i class="fa-solid fa-trash"></i></button></td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="text-end mb-4">
        <h5>Grand Total: <span id="grandTotal">0.00</span> ৳</h5>
      </div>

      <button type="button" class="btn btn-outline-primary mb-3" id="addItem">+ Add Item</button>
      <button type="submit" class="btn btn-success">Update</button>
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
    updateSerials();
    calculateTotals();
  }
});
document.addEventListener('input', function (e) {
  if (e.target.classList.contains('calc')) {
    calculateTotals();
  }
});
window.addEventListener('DOMContentLoaded', calculateTotals);
</script>

@endsection
