@extends('layouts.master')

@section('page')
<h2>Create Supplier</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Please fix the following:
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile" value="{{ old('mobile', $supplier->mobile ?? '') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-danger">Cancel</a>

</form>
@endsection