@php use App\Models\Product; @endphp
@extends('main')

@section('title', 'Miga de Oro - Products')

@section('content')
    @include('products.producthead')
    <section class="py-2">
        <div class=" px-4 px-lg-5 mt-5 row">
            <div class="col-8 my-3 ms-4"><h1 class="fw-bolder">Products</h1></div>
            <div class="col-3 my-3 ms-5"><h2>Filter by:</h2></div>
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-3 justify-content-center col-md-9">
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
                                    <a class="btn btn-outline-dark mt-auto" href="{{ route('products.show', $product->id) }}">See Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-3">
                <form
                    action="{{ route('products.index') }}"
                    class="d-none d-sm-inline-block form-inline ms-4 m-3 mw-100 navbar-search"
                    id="form-name"
                    method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search your product..."
                               aria-label="search" id="search" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                Search
                            </button>
                        </div>
                    </div>
                    <div class="col-12 mt-4 mb-2"><h5>Category:</h5></div>
                    @foreach($categories as $category)
                        @if($category->id != 1)
                            <div class="form-check form-check-inline w-25 mx-4 my-2">
                                <input class="form-check-input" name="category" type="radio" id="{{ $category->name}}" value="{{ $category->id }}">
                                <label class="form-check-label" for="{{ $category->name}}">{{ ucwords(strtolower($category->name)) }}</label>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-12 mt-4 mb-2"><h5>Providers:</h5></div>
                    @foreach($providers as $provider)
                        @if($provider->id != 1)
                            <div class="form-check form-check-inline w-25 mx-3 my-2">
                                <input class="form-check-input" name="provider" type="radio" id="{{ $provider->name}}" value="{{ $provider->id }}">
                                <label class="form-check-label" for="{{ $provider->name}}">{{ $provider->name }}</label>
                            </div>
                        @endif
                    @endforeach
                </form>
            </div>
                <div class="pagination-container d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
        </div>
    </section>

@endsection
