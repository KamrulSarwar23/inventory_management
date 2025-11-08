@extends('layouts.master')

@section('page')
<div class="container">
    <h1>{{ $product->name }}</h1>

    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
    <p><strong>SKU:</strong> {{ $product->sku }}</p>
    <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
    <p><strong>Description:</strong><br>{{ $product->description }}</p>

    @if($product->photo)
        <p><img src="{{ asset('storage/'.$product->photo) }}" style="max-width:300px;object-fit:cover"></p>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
