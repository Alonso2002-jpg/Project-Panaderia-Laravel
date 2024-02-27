@php use App\Models\Product; @endphp
@extends('main')

@section('title', 'Miga de Oro - Products')

@section('content')
<div class="container">
    <h2>Nuestros Productos</h2>
    <div class="position-relative marquee-container d-none d-sm-block">
        <div class="marquee d-flex justify-content-around">
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3">
                <div class="card">
                    @if($product->image != Product::$IMAGE_DEFAULT)
                        <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}" style="height: 200px; object-fit: cover;" alt="{{$product->name}}">
                    @else
                        <img class="card-img-top" src="{{ Product::$IMAGE_DEFAULT }}" style="height: 200px; object-fit: cover;" alt="{{$product->name}}">
                    @endif
                    <div class="card-body" style="height: 150px">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">Precio: ${{$product->price}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        </div>
</div>
@endsection
