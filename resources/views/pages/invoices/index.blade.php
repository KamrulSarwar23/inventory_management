@extends("layouts.master")
@section("page")

<style>
  .card-header-gradient {
    background: linear-gradient(90deg, rgb(253, 253, 255), rgb(217, 218, 219));
    color: black;
  }

  .card-title.manage-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
  }

  .card-header-actions .btn {
    min-width: 150px;
  }
</style>

<div class="card shadow-sm border-0">
  <!-- Gradient Header with right-aligned buttons -->
  <div class="card-header card-header-gradient d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h3 class="card-title manage-title">Manage Invoices</h3>

    <div class="card-header-actions d-flex gap-2 ms-auto">
      <a href="{{ url('invoices/create') }}" class="btn btn-light text-dark fw-normal">
        <i class="fas fa-plus me-2"></i> Create Invoice
      </a>
      <a href="{{ url()->previous() }}" class="btn btn-light fw-normal text-dark">
        <i class="fas fa-arrow-left me-2"></i> Back
      </a>
    </div>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Customer</th>
        <th>Shipping Address</th>
        <th>Total</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($invoices as $invoice)
      <tr>
        <td>{{ $invoice->id }}</td>
        <td>{{ date("d-m-Y", strtotime($invoice->created_at)) }}</td>
        <td>{{ $invoice->customer }}</td>
        <td>{{ $invoice->shipping_address ? $invoice->shipping_address : 'NA' }}</td>
        <td>{{ $invoice->invoice_total }}</td>
        <td class="text-center">
          <div class="btn-group">
            <a class="btn btn-primary" href="{{ url('invoices/' . $invoice->id) }}">View</a>
            <a class="btn btn-danger" href="{{ url('invoices/' . $invoice->id . '/delete') }}">Delete</a>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection
