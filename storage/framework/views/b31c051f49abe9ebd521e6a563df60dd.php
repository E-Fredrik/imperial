<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Admin Dashboard CSS -->
    <link href="<?php echo e(asset('css/admin-dashboard.css')); ?>" rel="stylesheet">

    <!-- Custom Override Styles - MUST come after Bootstrap -->
    <style>
        body {
            background: linear-gradient(180deg, #030303 0%, #0a0a0a 45%, #111111 100%) !important;
            color: #FAEBD7 !important;
            min-height: 100vh;
        }
        
        .bg-white {
            background: transparent !important;
        }
        
        .dark\:bg-gray-800 {
            background: transparent !important;
        }
    </style>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen app-bg">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="app-header shadow-sm" style="background: rgba(10, 10, 10, 0.8); border-bottom: 1px solid rgba(250, 235, 215, 0.1);">
                <div class="container max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl" style="color: #FAEBD7; display: flex; align-items: center; gap: 0.5rem;">
                        <?php if(isset($icon)): ?>
                            <i class="bi bi-<?php echo e($icon); ?>"></i>
                        <?php endif; ?>
                        <?php echo e($header); ?>

                    </h2>
                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="container max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            <?php echo e($slot); ?>

        </main>
    </div>

    <!-- Bootstrap JS Bundle (at the end of body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH D:\Github\imperial\resources\views/layouts/app.blade.php ENDPATH**/ ?>