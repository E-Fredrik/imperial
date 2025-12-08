<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000; padding: 1.5rem 0;">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('images/imperial-kost-logo.png')); ?>" alt="Imperial F7 Logo" style="height: 50px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                        <a href="<?php echo e(route('home')); ?>" class="nav-link text-white fw-bold" style="font-size: 1.1rem; <?php echo e(request()->routeIs('home') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : ''); ?>">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('rooms')); ?>" class="nav-link text-white fw-bold" style="font-size: 1.1rem; <?php echo e(request()->routeIs('rooms') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : ''); ?>">ROOM</a>
                    </li>
                    <li class="nav-item">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if((auth()->user()->role ?? '') === 'admin'): ?>
                                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link text-white fw-bold" style="font-size: 1.1rem; <?php echo e(request()->routeIs('dashboard') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : ''); ?>">PROFILE</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('profile')); ?>" class="nav-link text-white fw-bold" style="font-size: 1.1rem; <?php echo e(request()->routeIs('profile') || request()->is('profile*') ? 'border-bottom: 2px solid white; padding-bottom: 5px;' : ''); ?>">PROFILE</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="nav-link text-white fw-bold" style="font-size: 1.1rem;">PROFILE</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/components/navigation.blade.php ENDPATH**/ ?>