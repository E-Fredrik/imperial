<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - <?php echo e(config('app.name', 'Imperial Kost')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Admin CSS (includes responsive styles) -->
    <link href="<?php echo e(asset('css/admin-dashboard.css')); ?>" rel="stylesheet">

    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body style="background: #000; color: #FAEBD7; min-height: 100vh;">
    <!-- Admin Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0, 0, 0, 0.95); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 1030; border-bottom: 1px solid rgba(250, 235, 215, 0.1); padding: 1rem 0;">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('dashboard')); ?>" style="color: #FAEBD7; font-weight: 600;">
                <img src="<?php echo e(asset('images/imperial-kost-logo.png')); ?>" alt="Imperial F7 Logo" style="height: 45px; margin-right: 0.75rem;">
                <span>Admin Panel</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.rooms.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.rooms.index')); ?>">
                            <i class="bi bi-door-closed"></i> Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.bookings.index')); ?>">
                            <i class="bi bi-calendar-check"></i> Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.payments.index')); ?>">
                            <i class="bi bi-credit-card"></i> Payments
                        </a>
                    </li>
                    <?php if(Route::has('admin.users.index')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.images.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.images.index')); ?>">
                            <i class="bi bi-image"></i> Images
                        </a>
                    </li>
                    <?php if(Route::has('admin.info.index')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.info.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.info.index')); ?>">
                            <i class="bi bi-info-circle"></i> Info
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(Route::has('admin.roomfac.index')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.roomfac.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.roomfac.index')); ?>">
                            <i class="bi bi-check2-square"></i> Room Facilities
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(Route::has('admin.kostfac.index')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.kostfac.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.kostfac.index')); ?>">
                            <i class="bi bi-building"></i> Kost Facilities
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: rgba(250, 235, 215, 0.3);">
                            <i class="bi bi-person-circle"></i> <?php echo e(Auth::user()->name); ?>

                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('home')); ?>">
                                    <i class="bi bi-house-door"></i> View Site
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <?php if(isset($header) && isset($icon)): ?>
    <div style="background: linear-gradient(135deg, #0a0a0a 0%, #111111 100%); padding: 2rem 0; border-bottom: 1px solid rgba(250, 235, 215, 0.1);">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 50px; height: 50px; background: rgba(250, 235, 215, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi <?php echo e($icon); ?>" style="font-size: 1.75rem; color: #FAEBD7;"></i>
                </div>
                <div>
                    <h1 style="margin: 0; color: #FAEBD7; font-weight: 600; font-size: 1.75rem;"><?php echo e($header); ?></h1>
                    <p style="margin: 0; color: rgba(250, 235, 215, 0.6); font-size: 0.9rem;">Manage and monitor <?php echo e(strtolower($header)); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="container-fluid px-4" style="padding: 2rem 0; min-height: calc(100vh - 200px);">
        <?php echo e($slot); ?>

    </div>

    <!-- Footer -->
    <footer style="background: #0a0a0a; border-top: 1px solid rgba(250, 235, 215, 0.1); padding: 1.5rem 0; margin-top: auto;">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p style="margin: 0; color: rgba(250, 235, 215, 0.6); font-size: 0.9rem;">
                    © <?php echo e(date('Y')); ?> Imperial F7 Kost. All rights reserved.
                </p>
                <p style="margin: 0; color: rgba(250, 235, 215, 0.6); font-size: 0.9rem;">
                    Admin Dashboard v1.0
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\Github\imperial\resources\views/layouts/app.blade.php ENDPATH**/ ?>