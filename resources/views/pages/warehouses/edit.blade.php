@extends('layouts.master')

@section('page')
<h2>Edit Warehouse</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Please fix the following issues:
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
    @method('PUT')
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Warehouse Name</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $warehouse->name ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" name="city" value="{{ old('city', $warehouse->city ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="contact" class="form-label">Contact</label>
        <input type="text" class="form-control" name="contact" value="{{ old('contact', $warehouse->contact ?? '') }}" required>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('warehouses.index') }}" class="btn btn-danger">Cancel</a>

</form>
@endsection