@extends('layouts.master')

@section('page')
<div class="container">
    <h1>Products</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Category</th><th>Photo</th><th>Action</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>${{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->category->name ?? 'N/A' }}</td>
            <td>
                @if($product->photo)
                    <img src="{{ asset('storage/'.$product->photo) }}" width="100px">
                @endif
            </td>
            <td>
                <a href="{{ route('products.show',$product) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('products.edit',$product) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('products.destroy',$product) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $products->links() }}
</div>
@endsection
