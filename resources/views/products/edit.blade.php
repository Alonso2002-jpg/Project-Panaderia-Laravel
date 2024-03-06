@php use App\Models\Product; @endphp

@extends('main')

@section('title', 'Miga de Oro - Gestion de Productos')

@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Know about our Products!</div>
            <div class="masthead-heading text-uppercase">Yum Yummy!</div>
        </div>
    </header>
    <div class="container">
        <h2>Edit Product</h2>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
                <label for="stock">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>

            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
            @endif
        </form>
    </div>
