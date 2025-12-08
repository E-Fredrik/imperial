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

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php if (isset($component)) { $__componentOriginal95950f824213f5cf8d19afcb8f4ecb86 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal95950f824213f5cf8d19afcb8f4ecb86 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '71ffe14e2608a75a2cb5aed52d105549::styles','data' => ['theme' => 'richtextlaravel','dataTurboTrack' => 'false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('rich-text::styles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['theme' => 'richtextlaravel','data-turbo-track' => 'false']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal95950f824213f5cf8d19afcb8f4ecb86)): ?>
<?php $attributes = $__attributesOriginal95950f824213f5cf8d19afcb8f4ecb86; ?>
<?php unset($__attributesOriginal95950f824213f5cf8d19afcb8f4ecb86); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal95950f824213f5cf8d19afcb8f4ecb86)): ?>
<?php $component = $__componentOriginal95950f824213f5cf8d19afcb8f4ecb86; ?>
<?php unset($__componentOriginal95950f824213f5cf8d19afcb8f4ecb86); ?>
<?php endif; ?>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main>
            <?php echo e($slot); ?>

        </main>
    </div>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-NuJm1Q6s8n1bY4E2zF2x1gKq0p3Z8v1c0a7d6s4r2e9t1u3w5i7y8o0p2q3r4t6"
            crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/layouts/app.blade.php ENDPATH**/ ?>