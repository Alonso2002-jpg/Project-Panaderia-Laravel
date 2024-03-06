@php use App\Models\Category; @endphp
@extends('main')

@section('title', 'Miga de Oro - Home')

@section('content')
    @include('masthead')
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">CRAVE IT!</h2>
                <h3 class="section-subheading text-muted">Let yourself be tempted.</h3>
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
    <div class="card mb-1 m-4">
        <div class="row col-lg-12">
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $categories[0]->image) }}" class="img-fluid rounded-start" style="height: 200px; width: 300px">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Chocolate Cookies!</h5>
                    <p class="card-text">Our Chocolate Cookies is the best chocolate cookies ever made by hand!
                    Savoured by our costumers, this is the best chocolate cookies ever!, Don't miss this amazing
                        cookies from us! Take a look!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 m-4">
        <div class="row col-lg-12">
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Chocolate Cupcakes!</h5>
                    <p class="card-text">Our Chocolate Cupcakes is the most precious chocolate you had ever tasted, made by hand!
                        Savoured by our costumers, this is the best of the best ever!, Don't miss this amazing
                        product from us! Take a look!
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $categories[0]->image) }}" class="img-fluid rounded-start" style="height: 200px; width: 300px">
            </div>
        </div>
    </div>

    <div class="card mb-1 m-4">
        <div class="row col-lg-12">
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $categories[0]->image) }}" class="img-fluid rounded-start" style="height: 200px; width: 300px">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Mineral Water!</h5>
                    <p class="card-text">Our Mineral Water is the best water you had ever tasted, taking freshly from the mountains!
                        Savoured by our costumers, this is the best water they had ever tried!, Don't miss this amazing
                        water from us! Take a look!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-1 m-4">
        <div class="row col-lg-12">
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Milk Bread!</h5>
                    <p class="card-text">Our Milk Bread is the best bread you had ever received from the farm!
                        Savoured by our customers, this is the best of the best they had ever tried!, Don't miss this amazing
                        opportunity from tasting this bread from us! Take a look!
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $categories[0]->image) }}" class="img-fluid rounded-start" style="height: 200px; width: 300px">
            </div>
        </div>
    </div>

@endsection
