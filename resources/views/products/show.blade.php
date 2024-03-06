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
                    <form method="post" action="{{ route('addToCart', $product->id) }}" id="formCart">
                        @csrf
                        <div class="d-flex">
                            <button class="btn btn-outline-dark" type="button" onclick="decrementQuantity()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="hidden" id="stock" name="stock" value="0">
                            <input class="form-control text-center mx-2" id="temporalStock" name="temporalStock" type="text" value="0" style="max-width: 3rem" disabled>
                            <button class="btn btn-outline-dark me-3" type="button" onclick="incrementQuantity()">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </div>
                    </form>
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
    <script>
        document.getElementById('formCart').addEventListener('submit', function(event) {
            var inputQuantity = document.getElementById('temporalStock');
            var hiddenInputQuantity = document.getElementById('stock');
            hiddenInputQuantity.value = inputQuantity.value;
        });
        function incrementQuantity() {
            var inputQuantity = document.getElementById('temporalStock');
            var currentValue = parseInt(inputQuantity.value);
            if (currentValue < {{ $product->stock }}) {
                inputQuantity.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            var inputQuantity = document.getElementById('temporalStock');
            var newValue = parseInt(inputQuantity.value) - 1;
            if (newValue >= 0) {
                inputQuantity.value = newValue;
            }
        }
    </script>
@endsection
