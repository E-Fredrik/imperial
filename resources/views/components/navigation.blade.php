<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000; padding: 1.5rem 0;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Imperial F7 Logo" style="height: 50px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-white fw-bold" style="font-size: 1.1rem; {{ request()->routeIs('home') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : '' }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white fw-bold" style="font-size: 1.1rem; {{ request()->routeIs('rooms') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : '' }}">ROOM</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-white fw-bold" style="font-size: 1.1rem; {{ request()->routeIs('profile.*') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : '' }}">PROFILE</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>