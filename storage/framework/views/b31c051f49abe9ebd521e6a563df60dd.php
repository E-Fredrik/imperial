<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-XL0s8m3G1kQjB2u6r6bFjVwq0n6z1jY6p0QZpIu3j8lJqv8b3K2S5Z1y7E5v2hE" crossorigin="anonymous">

    <!-- Trix Editor CSS -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    <!-- App CSS (Vite) -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Admin theme (served from public/css) -->
    <link href="<?php echo e(asset('css/admin-theme.css')); ?>" rel="stylesheet">
</head>
<body class="app-root">
    <div class="min-h-screen app-bg">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="app-header shadow-sm">
                <div class="container max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="container my-5">
            <?php echo e($slot); ?>

        </main>
    </div>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-NuJm1Q6s8n1bY4E2zF2x1gKq0p3Z8v1c0a7d6s4r2e9t1u3w5i7y8o0p2q3r4t6"
            crossorigin="anonymous"></script>
    
    <!-- Trix Editor JS -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
</body>
</html>
<?php /**PATH D:\Github\imperial\resources\views/layouts/app.blade.php ENDPATH**/ ?>