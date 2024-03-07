@php use App\Models\Product; @endphp
@extends('main')

@section('title', 'Miga de Oro - Products')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @include('normalhead')
    <section class="py-2">

        <section class="pt-5 pb-5">
            <div class="container">
                @if(session()->has('cart') && session()->get('cart') != [])
                    <div class="row w-100">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h3 class="display-5 mb-2 text-center"><i class="fas fa-cart-shopping me-3"></i>Shopping Cart</h3>
                            <p class="mb-5 text-center">
                                <i class="font-weight-bold" style="color: #cca000;">{{ session()->get('totalItems') }}</i> delicious items in your cart
                            </p>
                            <table id="shoppingCart" class="table table-condensed table-responsive">
                                <thead>
                                <tr>
                                    <th style="width:60%">Product</th>
                                    <th style="width:12%">Price</th>
                                    <th style="width:10%">Quantity</th>
                                    <th style="width:16%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartItems as $key => $item)
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-md-3 text-left">
                                                    @if($item['product']->image != Product::$IMAGE_DEFAULT)
                                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                                    @else
                                                        <img src="{{ Product::$IMAGE_DEFAULT }}" alt="{{ $item['product']->name }}" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                                    @endif

                                                </div>
                                                <div class="col-md-9 text-left mt-sm-2">
                                                    <h4>{{ $item['product']->name }}</h4>
                                                    <p class="font-weight-light">{{ $item['product']->provider->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">€ {{ $item['product']->price }}</td>
                                        <form method="post" action="{{ route('cart.update', $item['product']->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <td data-th="Quantity">
                                                <input type="number" class="form-control form-control-lg text-center" name="stock" value="{{ $item['quantity'] }}">
                                            </td>
                                            <td data-th="id">
                                                <input hidden="" class="form-control form-control-lg text-center" name="id" value="{{ $item['product']->id }}">
                                            </td>
                                        <td class="actions" data-th="">
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <div class="input-group">
                                                    <button type="submit" class="btn btn-outline-primary btn-md ml-2">
                                                        <i class="fas fa-sync-alt"></i> Update
                                                    </button>
                                                </div>
                                        </td>
                                        </form>
                                        <td class="actions" data-th="">
                                            <form method="post" action="{{ route('cart.destroy', $item['product']->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <div class="text-right">
                                                    <button class="btn btn-outline-danger btn-md mb-2" type="submit">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="float-right text-right">
                                <p class="fs-5">Subtotal:</p>
                                <p class="fs-4 text-success">€ {{ $totalPrice }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 d-flex align-items-center">
                        <div class="col-sm-6 order-md-2 text-right">
                            <a href="catalog.html" class="btn btn-outline-warning mb-4 btn-lg pl-5 pr-5">Checkout</a>
                        </div>
                        <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                            <a href="{{ route('products.index') }}" style="color: #cca000;">
                                <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
                        </div>
                    </div>
                @else
                    <div class="row w-100">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h3 class="display-5 mb-2 text-center"><i class="fas fa-basket-shopping me-3"></i>Your Cart is Empty</h3>
                            <p class="mb-5 text-center">
                                <i class="font-weight-bold" style="color: #cca000;">Add products to your bread cart!</i>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-4 d-flex align-items-center">
                        <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                            <a href="{{ route('products.index') }}" style="color: #cca000;">
                                <i class="fas fa-arrow-left mr-2"></i> Go To Shopping</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
