<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Imperial')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS (CDN) - required for components/navigation -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Vite / app CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body style="background:#000; color:#FAEBD7; min-height:100vh; margin:0; font-family: ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;">
    <?php echo $__env->make('components.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main style="min-height:calc(100vh - 80px); display:flex; align-items:center; justify-content:center; padding:3rem 1rem;">
        <div style="width:100%; max-width:520px;">
            <div style="text-align:center; margin-bottom:1.25rem;">
                
            </div>

            <div style="background:#0a0a0a; padding:2rem; border-radius:12px; color:#FAEBD7; box-shadow:0 8px 30px rgba(0,0,0,0.6);">
                <?php echo e($slot); ?>

            </div>

            <div style="text-align:center; margin-top:1rem; color:#cfc6bc; font-size:0.9rem;">
                <a href="<?php echo e(route('home')); ?>" style="color:#cfc6bc; text-decoration:none; margin-right:1rem;">Home</a>
                <a href="<?php echo e(route('login')); ?>" style="color:#cfc6bc; text-decoration:none; margin-right:1rem;">Log in</a>
                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>" style="color:#FAEBD7; font-weight:600; text-decoration:none;">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Github\imperial\resources\views/layouts/guest.blade.php ENDPATH**/ ?>