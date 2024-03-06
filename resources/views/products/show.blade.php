@php use App\Models\Product; @endphp
@extends('main')

@section('title', 'Product Details')
@section('content')
    @include('normalhead')
    <section id="product_{{ $product->id }}" class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    @if($product->image != Product::$IMAGE_DEFAULT)
                        <img class="card-img-top mb-5 mb-md-0" src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}" style="height: 400px; object-fit: cover;"/>
                    @else
                        <img class="card-img-top mb-5 mb-md-0" src="{{ Product::$IMAGE_DEFAULT }}"
                             alt="{{ $product->name }}" style="height: 400px; object-fit: cover;"/>
                    @endif

                </div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                    <div class="fs-5 mb-5">
                        <span>${{ $product->price }}</span>
                    </div>
                    <p class="lead">{{ $product->description }}</p>
                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="num" value="0"
                               style="max-width: 3rem"/>
                        <button class="btn btn-outline-dark flex-shrink-0" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2>Related Products</h2>
            <div class="row my-3">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-4">
                        <div class="card">
                            @if($relatedProduct->image != Product::$IMAGE_DEFAULT)
                                <img class="card-img-top" src="{{ asset('storage/' . $relatedProduct->image) }}"
                                     alt="{{ $product->name }}" style="height: 250px; object-fit: cover;"/>
                            @else
                                <img class="card-img-top" src="{{ Product::$IMAGE_DEFAULT }}"
                                     alt="{{ $relatedProduct->name }}" style="height: 250px; object-fit: cover;"/>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                <p class="card-text">${{ $relatedProduct->price }}</p>
                                <a href="{{ route('products.show', $relatedProduct->id) }}"
                                   class="btn btn-outline-dark mt-auto">View Product</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
