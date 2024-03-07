@php use App\Models\Product; @endphp

@extends('main')

@section('title', 'Miga de Oro - Gestion de Productos')

@section('content')
    @include('normalhead')

    <div class="container">
        <h2>Create a Product</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" required>
                <label for="stock">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        @if($errors ->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all( ) as $error)
                        <li>{{ $error }}</li>
                    @endforeach</ul>
    @endif
