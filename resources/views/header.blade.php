<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/general/nav-logo.svg') }}" alt="..." /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">

                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index')}}">Products</a></li>
                @auth
                    @if(auth()->user()->role == 'admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index')}}">Categories</a></li>
                    @endif
                    @endauth
                <li class="nav-item"><a class="nav-link" href="{{route('about')}}">About Us</a></li>

                @auth
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>
                        @else
                    <li class="nav-item"><a class="nav-link nav-link-login" href="{{ route('login') }}">Login</a></li>
                @endauth

                <li class="nav-item">
                    <div class="bg-warning-subtle rounded">
                        <a>{{auth()->user()->role ?? '¡ Bienvenido invitado! '}}</a>
                    </div>
                </li>

                <li class="nav-item">
                    <form class="d-flex cart">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-cart-shopping mx-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>

