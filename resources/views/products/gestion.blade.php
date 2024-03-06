@extends('main')

@section('title', 'Miga de Oro -Gestion Products')

@section('content')
    @include('products.producthead')
    <section>
        <div class="container">
            <h2>Our Products</h2>
            <div class="row">
                <div class="col-md-3">
                    <a class="btn btn-primary" href="{{ route('products.create') }}">Create a Product</a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            @if($product->id!=1)
                                <td><img src="{{ asset('storage/' . $product->image) }}" style="width: 45px"></td>
                                <td>{{ $product->name }}</td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td><button><a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a></button>
                                    <button><a class="btn btn-secondary" href="{{ route('products.editImage', $product->id) }}">EditImage</a></button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @endif
                                </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-container">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
