@extends('layouts.master')

@section('page')
<div class="container mt-4">
    <h2>Edit Customer</h2>

    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        @php $customer = $customer ?? null; @endphp

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $customer->mobile ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address', $customer->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
            @if(!empty($customer) && $customer->photo)
            <img src="{{ asset('storage/' . $customer->photo) }}" width="80" class="mt-2">
            @endif
        </div>


        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection