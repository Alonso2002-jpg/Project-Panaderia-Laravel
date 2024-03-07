@php use App\Models\Product; @endphp

@extends('main')

@section('title', 'Miga de Oro - Gestion de Productos')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Edit Image of the Product</h2>
        <p>ID:{{$product->id}}</p>
        <p>Name:{{$product->name}}</p>
        <p>  @if($product->image != Product::$IMAGE_DEFAULT)
                <img  src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"  style="width: 250px"/>
            @else
                <img  src="{{ Product::$IMAGE_DEFAULT}}" alt="{{ $product->name }}"  style="width: 250px"/>
            @endif</p>
        <form action="{{ route('products.updateImage', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="m-md-3">
                <label for="image">Select an Image for the Product</label>
                <input type="file" name="image" required class="form-control">
                <div class="invalid-feedback"> Please select an Image valid</div>
            </div>
            <button type="submit" class="btn btn-primary">Update Image</button>
            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
            @endif
        </form>
    </div>
