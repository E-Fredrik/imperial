<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0, 0, 0, 0.9); padding: 1.25rem 0; position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/imperial-kost-logo.png') }}" alt="Imperial F7 Logo" style="height: 55px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-white" style="{{ request()->routeIs('home') ? 'border-bottom: 3px solid #FAEBD7;' : '' }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rooms') }}" class="nav-link text-white" style="{{ request()->routeIs('rooms') ? 'border-bottom: 3px solid #FAEBD7;' : '' }}">ROOMS</a>
                    </li>
                    <li class="nav-item">
                        @auth
                            @if((auth()->user()->role ?? '') === 'admin')
                                <a href="{{ route('dashboard') }}" class="nav-link text-white" style="{{ request()->routeIs('dashboard') ? 'border-bottom: 3px solid #FAEBD7;' : '' }}">DASHBOARD</a>
                            @else
                                <a href="{{ route('profile') }}" class="nav-link text-white" style="{{ request()->routeIs('profile') || request()->is('profile*') ? 'border-bottom: 3px solid #FAEBD7;' : '' }}">PROFILE</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="nav-link btn text-white">
                                <i class="bi bi-box-arrow-in-right me-1"></i>LOGIN
                            </a>
                        @endauth
                    </li>
                    @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn text-white" style="background: none; border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444 !important;">
                                    <i class="bi bi-box-arrow-right me-1"></i>LOGOUT
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">

<script>
// Add scrolled class to navbar on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
</script>