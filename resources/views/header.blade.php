<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('principal') }}"><img src="{{ asset('images/general/nav-logo.svg') }}" alt="..." /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('principal') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index')}}">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('about')}}">About Us</a></li>
                @auth
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <button class="btn btn-outline-dark text-light dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Data Management
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{route('gestion.products')}}">Products</a></li>
                                <li><a class="dropdown-item" href="{{route('categories.index')}}">Categories</a></li>
                                <li><a class="dropdown-item" href="{{route('providers.index')}}">Providers</a></li>
                                <li><a class="dropdown-item" href="{{route('staff.index')}}">Staff</a></li>
                            </ul>
                        </li>

                    @endif
                    <li class="nav-item">
                        <form class="d-flex cart">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="fas fa-cart-shopping mx-1"></i>
                                Cart
                                <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger" href="{{ route('logout') }}"><i class="fas fa-power-off"></i></button>
                        </form>
                    </li>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>
                @else
                    <li class="nav-item"><a class="btn btn-outline-light" href="{{ route('login') }}"><i class="fas fa-power-off"></i></i></a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
