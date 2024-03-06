@extends('layouts.app')

@section('title', 'Migas de Oro - Register')

@section('content')
    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">
        <style>
            .background-radial-gradient {
                background-color: hsl(38, 100%, 55%);
                background-image: radial-gradient(650px circle at 0% 0%, hsl(36, 88%, 45%) 15%, hsl(35, 100%, 42%) 35%, hsl(36, 100%, 47%) 75%, hsl(46, 100%, 42%) 80%, transparent 100%), radial-gradient(1250px circle at 100% 100%, hsl(38, 100%, 65%) 15%, hsl(37, 100%, 42%) 35%, hsl(39, 100%, 50%) 75%, hsl(45, 100%, 40%) 80%, transparent 100%);
            }

            #radius-shape-1 {
                height: 220px;
                width: 220px;
                top: -60px;
                left: -130px;
                background: radial-gradient(hsl(35, 73%, 40%), hsl(38, 87%, 50%)); /* Gradiente de café oscuro a amarillo */
            }

            #radius-shape-2 {
                border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
                bottom: -60px;
                right: -110px;
                width: 300px;
                height: 300px;
                background: radial-gradient(hsl(35, 73%, 40%), hsl(38, 87%, 50%)); /* Gradiente de morado oscuro a rosa */
            }

            .bg-glass {
                background-color: hsla(0, 0%, 100%, 0.5) !important;
                backdrop-filter: saturate(200%) blur(25px);
            }

        </style>

        <div class="container px-4 py-4 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        Sign up <br />
                        <span style="color: hsl(51,48%,32%)">in our bakery</span>
                    </h1>
                    <p class="mb-4 opacity-70 fs-5" style="color: hsl(0,0%,0%)">
                        Join our community of bread lovers! In our bakery, every bite is a journey of flavors and textures. Discover the freshness of our artisanal products and let yourself be seduced by the irresistible aroma of freshly baked bread. Sign up now and be part of a unique gastronomic experience that will awaken your senses and brighten your day.
                    </p>

                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form method="post" action="{{ route('register') }}">
                                @csrf
                                <div class="py-2 text-center fs-2">Sign Up</div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe" name="name"/>
                                            <label class="form-label" for="name">Full Name</label>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="+34" maxlength="9"/>
                                            <label class="form-label" for="phone_number">Phone Number</label>
                                            @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@example.com"/>
                                    <label class="form-label" for="email">Email address</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Password input -->
                                <div class="row">
                                    <div class="form-outline mb-4 col-md-6">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" />
                                        <label class="form-label" for="password">Password</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-outline mb-4 col-md-6">
                                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control @error('password-confirm') is-invalid @enderror" />
                                        <label class="form-label" for="password-confirm">Confirm Password</label>
                                    </div>
                                </div>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-dark btn-block mb-4 w-100">
                                    Sign up
                                </button>

                                <!-- Register buttons -->
                                <div class="text-center">
                                    <p>or sign up with:</p>
                                    <button type="button" class="btn btn-outline-dark btn-floating mx-1">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>

                                    <button type="button" class="btn btn-outline-dark btn-floating mx-1">
                                        <i class="fab fa-google"></i>
                                    </button>

                                    <button type="button" class="btn btn-outline-dark btn-floating mx-1">
                                        <i class="fab fa-twitter"></i>
                                    </button>

                                    <button type="button" class="btn btn-outline-dark btn-floating mx-1">
                                        <i class="fab fa-github"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->
@endsection
