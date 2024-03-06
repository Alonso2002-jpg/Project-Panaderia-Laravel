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
                <div class="row w-100">
                    <div class="col-lg-12 col-md-12 col-12">
                        <h3 class="display-5 mb-2 text-center"><i class="fas fa-cart-shopping me-3"></i>Shopping Cart</h3>
                        <p class="mb-5 text-center">
                            <i class="font-weight-bold" style="color: #cca000;">3</i> delicious items in your cart</p>
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
                            <tr>
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-md-3 text-left">
                                            <img src="https://via.placeholder.com/250x250/5fa9f8/ffffff" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                        </div>
                                        <div class="col-md-9 text-left mt-sm-2">
                                            <h4>Product Name</h4>
                                            <p class="font-weight-light">Brand &amp; Name</p>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">€ 49.00</td>
                                <td data-th="Quantity">
                                    <input type="number" class="form-control form-control-lg text-center" value="1">
                                </td>
                                <td class="actions" data-th="">
                                    <div class="text-right">
                                        <button class="btn btn-white border-secondary bg-white btn-md mb-2">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button class="btn btn-white border-secondary bg-white btn-md mb-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="float-right text-right">
                            <p class="fs-5">Subtotal:</p>
                            <p class="fs-4 text-success">€ 99.00</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 d-flex align-items-center">
                    <div class="col-sm-6 order-md-2 text-right">
                        <a href="catalog.html" class="btn btn-outline-warning mb-4 btn-lg pl-5 pr-5">Checkout</a>
                    </div>
                    <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                        <a href="catalog.html" style="color: #cca000;">
                            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
                    </div>
                </div>
            </div>
        </section>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
@endsection
