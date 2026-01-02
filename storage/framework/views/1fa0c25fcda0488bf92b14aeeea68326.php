<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - <?php echo e(config('app.name', 'Imperial Kost')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Admin CSS -->
    <link href="<?php echo e(asset('css/admin-dashboard.css')); ?>" rel="stylesheet">

    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body style="background: #000; color: #FAEBD7; min-height: 100vh;">
    <!-- Admin Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border-bottom: 2px solid rgba(250, 235, 215, 0.1); padding: 1rem 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
        <div class="container-fluid px-4">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('dashboard')); ?>" style="gap: 0.75rem;">
                <img src="<?php echo e(asset('images/imperial-kost-logo.png')); ?>" alt="Imperial Kost Logo" style="height: 45px;">
                <span style="font-size: 1.1rem; font-weight: 600; color: #FAEBD7;">Admin Panel</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <!-- Navigation Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="gap: 0.5rem; margin-left: 2rem;">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('dashboard') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.rooms.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.rooms.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.rooms.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-door-closed me-1"></i>Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.bookings.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.bookings.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-calendar-check me-1"></i>Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.roomfac.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.roomfac.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.roomfac.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-check2-square me-1"></i>Room Facilities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.kostfac.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.kostfac.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.kostfac.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-building me-1"></i>Kost Facilities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.info.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.info.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.info.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-info-circle me-1"></i>Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.images.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.images.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.images.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-image me-1"></i>Images
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.payments.index')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 6px; <?php echo e(request()->routeIs('admin.payments.*') ? 'background: rgba(250, 235, 215, 0.1);' : ''); ?>">
                            <i class="bi bi-credit-card me-1"></i>Payments
                        </a>
                    </li>
                </ul>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(250, 235, 215, 0.05); border: 1px solid rgba(250, 235, 215, 0.2); color: #FAEBD7; padding: 0.5rem 1rem; border-radius: 8px;">
                        <i class="bi bi-person-circle" style="font-size: 1.25rem;"></i>
                        <span><?php echo e(Auth::user()->first_name ?? Auth::user()->name ?? 'Admin'); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="background: #1a1a1a; border: 1px solid rgba(250, 235, 215, 0.2); min-width: 200px;">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="<?php echo e(route('home')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem;">
                                <i class="bi bi-house"></i>
                                <span>View Site</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="<?php echo e(route('profile.edit')); ?>" style="color: #FAEBD7; padding: 0.5rem 1rem;">
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" style="border-color: rgba(250, 235, 215, 0.2);"></li>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2" style="color: #ef4444; padding: 0.5rem 1rem;">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div style="background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border-bottom: 1px solid rgba(250, 235, 215, 0.1); padding: 2rem 0;">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center gap-3">
                <div style="background: rgba(250, 235, 215, 0.1); border-radius: 12px; padding: 1rem; display: inline-flex;">
                    <i class="bi <?php echo $__env->yieldContent('icon', 'bi-speedometer2'); ?>" style="font-size: 2rem; color: #FAEBD7;"></i>
                </div>
                <div>
                    <h1 style="font-size: 2rem; font-weight: 700; color: #FAEBD7; margin: 0;">
                        <?php echo $__env->yieldContent('header', 'Admin Dashboard'); ?>
                    </h1>
                    <p style="color: #999; margin: 0; font-size: 0.95rem;">
                        Manage your boarding house operations
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main style="padding: 2rem 0; min-height: calc(100vh - 200px);">
        <div class="container-fluid px-4">
            <?php echo e($slot); ?>

        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #0a0a0a; border-top: 1px solid rgba(250, 235, 215, 0.1); padding: 1.5rem 0; margin-top: auto;">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p style="color: #666; margin: 0; font-size: 0.9rem;">
                    &copy; <?php echo e(date('Y')); ?> Imperial Kost. All rights reserved.
                </p>
                <p style="color: #666; margin: 0; font-size: 0.9rem;">
                    Admin Panel v1.0
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/layouts/app.blade.php ENDPATH**/ ?>