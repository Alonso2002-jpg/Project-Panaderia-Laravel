@extends('layouts.app')

@section('title', 'Migas de Oro - Reset Password')

@section('content')
    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">
        <style>
            .background-radial-gradient {
                background-color: hsl(36, 74%, 71%); /* Modificado el 55% a 70% */
                background-image: radial-gradient(650px circle at 0% 0%, hsl(36, 88%, 60%) 15%, hsl(34, 85%, 59%) 35%, hsl(36, 100%, 62%) 75%, hsl(46, 100%, 57%) 80%, transparent 100%), radial-gradient(1250px circle at 100% 100%, hsl(38, 100%, 80%) 15%, hsl(37, 100%, 57%) 35%, hsl(39, 100%, 65%) 75%, hsl(45, 100%, 55%) 80%, transparent 100%);
            }

            #radius-shape-1 {
                height: 220px;
                width: 220px;
                top: -60px;
                left: -130px;
                background: radial-gradient(hsl(35, 73%, 50%), hsl(38, 87%, 60%)); /* Modificado el 40% a 50% y 50% a 60% */
            }

            #radius-shape-2 {
                border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
                bottom: -60px;
                right: -110px;
                width: 300px;
                height: 300px;
                background: radial-gradient(hsl(35, 73%, 50%), hsl(38, 87%, 60%)); /* Modificado el 40% a 50% y 50% a 60% */
            }


            .bg-glass {
                background-color: hsla(0, 0%, 100%, 0.5) !important;
                backdrop-filter: saturate(200%) blur(25px);
            }

        </style>
        <div class="container px-4 py-4 px-md-4 text-center text-lg-start my-5" style="height: 87vh;">
            <div class="row gx-lg-5 align-items-center my-5 py-5">
                <div class="col-lg-12 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass my-5">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form action="{{ route('password.email') }}" method="post">
                                @csrf
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@example.com" value="{{ old('email') }}" name="email"/>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-dark btn-block mb-4 w-100">
                                    Send Email
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
