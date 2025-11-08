@extends('layouts.master')

@section('page')
<div class="container mt-4">
    <h2>Customer Details</h2>

    <div class="mb-3">
        <strong>Name:</strong> {{ $customer->name }}
    </div>

    <div class="mb-3">
        <strong>Mobile:</strong> {{ $customer->mobile }}
    </div>

    <div class="mb-3">
        <strong>Email:</strong> {{ $customer->email }}
    </div>

    <div class="mb-3">
        <strong>Address:</strong> {{ $customer->address }}
    </div>

    @if($customer->photo)
        <div class="mb-3">
            <strong>Photo:</strong><br>
            <img src="{{ asset('storage/' . $customer->photo) }}" style="max-width:300px;object-fit:cover">
        </div>
    @endif

    <a href="{{ route('customers.index') }}" class="btn btn-success">Back</a>
</div>
@endsection
