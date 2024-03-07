@extends('main')

@section('title', 'Miga de Oro - Payment Method')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
@include('normalhead')
    <div class="container d-flex justify-content-center mt-5 mb-5">



    <div class="row g-3">

        <div class="col-md-6">

            <span>Payment Method</span>
            <div class="card">

                <div class="accordion" id="accordionExample">

                    <div class="card">
                        <div class="card-header p-0" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-light btn-block text-left collapsed p-3 rounded-0 border-bottom-custom" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <span>Shipping Information</span>
                                        <img src="{{asset('images/general/paypal.png')}}" width="30" alt="">

                                    </div>
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                           <div class="row mx-2">
                               <div class="card-body col-6">
                                   <span class="font-weight-normal card-text">Name</span>
                                   <div class="input">
                                       <input type="text" class="form-control" placeholder="John Doe">

                                   </div>
                               </div>
                               <div class="card-body col-6">
                                   <span class="font-weight-normal card-text">Last Name</span>
                                   <div class="input">
                                       <input type="text" class="form-control" placeholder="Doe Doe">

                                   </div>
                               </div>
                               <div class="card-body col-6">
                                   <span class="font-weight-normal card-text">DNI/NIE</span>
                                   <div class="input">
                                       <input type="text" class="form-control" placeholder="Y1234567W">

                                   </div>
                               </div>
                               <div class="col-6"></div>
                               <div class="card-body col-6">
                                   <span class="font-weight-normal card-text">Street</span>
                                   <div class="input">
                                       <input type="text" class="form-control">

                                   </div>
                               </div>
                               <div class="card-body col-3">
                                   <span class="font-weight-normal card-text">Number</span>
                                   <div class="input">
                                       <input type="text" class="form-control">
                                   </div>
                               </div>
                               <div class="card-body col-3">
                                   <span class="font-weight-normal card-text">City</span>
                                   <div class="input">
                                       <input type="text" class="form-control" >
                                   </div>
                               </div>
                               <div class="card-body col-4">
                                   <span class="font-weight-normal card-text">Province</span>
                                   <div class="input">
                                       <input type="text" class="form-control">
                                   </div>
                               </div>
                               <div class="col-4"></div>
                               <div class="card-body col-4">
                                   <span class="font-weight-normal card-text">Postal Code</span>
                                   <div class="input">
                                       <input type="text" class="form-control" >
                                   </div>
                               </div>
                               <div class="card-body col-6">
                                   <span class="font-weight-normal card-text">Aditional Information</span>
                                   <div class="input">
                                       <input type="text" class="form-control">
                                   </div>
                               </div>
                           </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header p-0">
                            <h2 class="mb-0">
                                <button class="btn btn-light btn-block text-left p-3 rounded-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="d-flex align-items-center justify-content-between">

                                        <span>Credit card</span>
                                        <div class="icons">
                                            <img src="{{asset('images/general/visa.png')}}" width="30">
                                            <img src="{{asset('images/general/mastercard.png')}}" width="30">
                                            <img src="{{asset('images/general/stripe.png')}}" width="30">
                                        </div>

                                    </div>
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body payment-card-body">

                                <span class="font-weight-normal card-text">Card Number</span>
                                <div class="input">

                                    <i class="fa fa-credit-card"></i>
                                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000">

                                </div>

                                <div class="row mt-3 mb-3">

                                    <div class="col-md-6">

                                        <span class="font-weight-normal card-text">Expiry Date</span>
                                        <div class="input">

                                            <i class="fa fa-calendar"></i>
                                            <input type="text" class="form-control" placeholder="MM/YY">

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <span class="font-weight-normal card-text">CVC/CVV</span>
                                        <div class="input">

                                            <i class="fa fa-lock"></i>
                                            <input type="text" class="form-control" placeholder="000">

                                        </div>

                                    </div>


                                </div>

                                <span class="text-muted certificate-text"><i class="fa fa-lock"></i> Your transaction is secured with ssl certificate</span>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">
            <span>Summary</span>

            <div class="card">

                <div class="d-flex justify-content-between p-3">

                    <div class="d-flex flex-column">
                        <span>Total To Pay (EUR) <i class="fa fa-caret-down"></i></span>
                    </div>

                    <div class="mt-1">
                        <span class="super-month">$9.99</span>
                    </div>

                </div>

                <hr class="mt-0 line">


                <div class="p-3 d-flex justify-content-between">

                    <div class="d-flex flex-column">

                        <span>Today you pay(US Dollars)</span>
                        <small>After 30 days $9.59</small>

                    </div>
                    <span>$0</span>



                </div>


                <div class="p-3">

                    <button class="btn btn-primary btn-block free-button">Realizar Pago</button>

                </div>




            </div>
        </div>

    </div>


</div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
@endsection
