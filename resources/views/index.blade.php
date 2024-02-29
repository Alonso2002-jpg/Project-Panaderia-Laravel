@php use App\Models\Category; @endphp
@extends('main')

@section('title', 'Miga de Oro - Home')

@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Welcome to Our Bakery!</div>
            <div class="masthead-heading text-uppercase">Explore Our Products</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="{{ route('products.index') }}">Go to the Bakery</a>
        </div>
    </header>
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">CHOOSE TO YOUR LIKING</h2>
                <h3 class="section-subheading text-muted">Browse through our categories.</h3>
            </div>
        <div class="position-relative marquee-container d-none d-sm-block">
         <div class="marquee d-flex justify-content-around">
            <div class="row">
                @foreach($categories as $category)
                    @if($category->id != 1)
                        <div class="col-lg-3 col-sm-3 mb-4 category">
                            <!-- Portfolio item 1-->
                            <div class="portfolio-item">
                                <a class="portfolio-link" data-bs-toggle="modal" href="*">
                                    <div class="portfolio-hover">
                                        <div class="portfolio-hover-content"><i class="fas fa-bread-slice fa-3x"></i></div>
                                    </div>
                                    @if($category->image != Category::$IMAGE_DEFAULT)
                                        <img class="img-fluid" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="height: 200px; object-fit: cover;"/>
                                    @else
                                        <img class="img-fluid" src="{{ Category::$IMAGE_DEFAULT }}" alt="{{ $category->name }}" />
                                    @endif

                                </a>
                                <div class="portfolio-caption">
                                    <div class="portfolio-caption-heading">{{ $category->name }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        </div>
        </div>

    </section>
@endsection
