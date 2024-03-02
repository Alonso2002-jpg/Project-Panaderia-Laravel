@php use App\Models\Product; @endphp
@extends('main')

@section('title', 'Miga de Oro - Products')

@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Find Our Products!</div>
            <div class="masthead-heading text-uppercase">Yum Yum Yummy</div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5 row">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center col-md-10">
                @foreach($products as $product)
                    <div class="col mb-5">
                        <div class="card h-100">
                            @if($product->image != Product::$IMAGE_DEFAULT)
                                <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;"/>
                            @else
                                <img class="card-img-top" src="{{ Product::$IMAGE_DEFAULT }}" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;"/>
                            @endif

                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    ${{ $product->price }}
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <!-- Enlace al detalle del producto -->
                                    <a class="btn btn-outline-dark mt-auto" href="#product_{{ $product->id }}">See Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="container col-2">
            </div>
        </div>
    </section>

    <!-- Detalle de los productos -->
    @foreach($products as $product)
        <section id="product_{{ $product->id }}" class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" /></div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                        <div class="fs-5 mb-5">
                            <span>${{ $product->price }}</span>
                        </div>
                        <p class="lead">{{ $product->description }}</p>
                        <div class="d-flex">
                            <input class="form-control text-center me-3" id="inputQuantity" type="num" value="0" style="max-width: 3rem" />
                            <button class="btn btn-outline-dark flex-shrink-0" type="button">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endforeach
@endsection
