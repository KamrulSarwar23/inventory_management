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

  .status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
  }
  .bg-pending { background-color: #fff3cd; color: #856404; }
  .bg-processing { background-color: #cce5ff; color: #004085; }
  .bg-completed { background-color: #d4edda; color: #155724; }
  .bg-cancelled { background-color: #f8d7da; color: #721c24; }
</style>

<div class="card shadow-sm border-0">
  <!-- Gradient Header with right-aligned buttons -->
  <div class="card-header card-header-gradient d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h3 class="card-title manage-title">Manage Orders</h3>
    
    <div class="card-header-actions d-flex gap-2 ms-auto">
      <a href="{{ route('orders.create') }}" class="btn btn-success text-dark fw-normal">
        <i class="fas fa-plus me-2"></i> Create Order
      </a>
      <a href="{{ url()->previous() }}" class="btn btn-primary fw-normal text-dark">
        <i class="fas fa-arrow-left me-2"></i> Back
      </a>
    </div>
  </div>

  {{-- Search Bar --}}
  <div class="card-body border-bottom">
    <form method="GET" class="row g-2">
      <div class="col-md-10">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
          placeholder="Search by customer name or order ID">
      </div>
      <div class="col-md-2">
        <button class="btn btn-dark w-100">
          <i class="fas fa-search me-1"></i> Search
        </button>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Order Date</th>
          <th>Delivery Date</th>
          <th>Total (৳)</th>
          <th>Status</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer->name ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-Y h:i A') }}</td>
            <td class="fw-semibold">{{ number_format($order->order_total, 2) }}</td>
            <td>
              @php
                $statusClasses = [
                  1 => 'bg-confirmed',
                  2 => 'bg-processing',
                  3 => 'bg-completed',
                  4 => 'bg-cancelled'
                ];
                $statusNames = [
                  1 => 'Confirmed',
                  2 => 'Processing',
                  3 => 'Completed',
                  4 => 'Cancelled'
                ];
              @endphp
              <span class="status-badge {{ $statusClasses[$order->status_id] ?? 'bg-light text-dark' }}">
                {{ $statusNames[$order->status_id] ?? 'Unknown' }}
              </span>
            </td>
            <td class="text-center">
              <div class="btn-group" role="group">
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-eye me-1"></i> View
                </a>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-success btn-sm">
                  <i class="fas fa-edit me-1"></i> Edit
                </a>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this order?')" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash me-1"></i> Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-3">No orders found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="card-footer">
    <div class="d-flex justify-content-end">
      {{ $orders->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>

@endsection
