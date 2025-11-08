@extends("layouts.master")
@section("page")

<style>
  .card-header-gradient {
    background: linear-gradient(90deg,rgb(253, 253, 255),rgb(217, 218, 219));
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
    <h3 class="card-title manage-title">Manage Purchase</h3>
    
    <div class="card-header-actions d-flex gap-2 ms-auto">
      <a href="{{ url('purchases/create') }}" class="btn btn-success text-dark fw-normal">
        <i class="fas fa-plus me-2"></i> Create Purchase
      </a>
      <a href="{{ url()->previous() }}" class="btn btn-primary fw-normal text-dark">
        <i class="fas fa-arrow-left me-2"></i> Back
      </a>
    </div>
  </div>

 <table class="table table-bordered table-striped">
    <tr>
      <th>ID</th>
      <th>Date</th>
      <th>Supplier </th>
      <th>Shipping Address</th>
      <th>Total</th>
      <th class="d-flex justify-content-center">Action</th>
    </tr>
    @foreach($purchases as $purchase)
    <tr>
      <td>{{$purchase->id}}</td>
      <td>{{date("d-m-Y",strtotime($purchase->created_at))}}</td>
      <td>{{$purchase->supplier}}</td>
      <td>{{$purchase->shipping_address}}</td>
      <td>{{$purchase->purchase_total}}</td>
      <td class="d-flex justify-content-center">
        <div class="btn-group">
          <a class="btn btn-primary" href="{{url('purchases/'.$purchase->id)}}">View</a>
          <a class="btn btn-success" href="{{url('purchases/'.$purchase->id.'/edit')}}">Edit</a>
          <a class="btn btn-danger" href="{{url('purchases/'.$purchase->id.'/delete')}}">Delete</a>

        </div>
      </td>
    </tr>
   @endforeach
   
  </table>
</div>
</div>
@endsection