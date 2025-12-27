<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?php echo e(asset('css/room.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <h1 class="hero-title">Your Premium Boarding Experience</h1>
                <p class="hero-description">
                    Discover comfort and convenience with our modern boarding house. Interactive room 
                    selection, instant booking, and premium amenities await you.
                </p>
                <div class="mb-4">
                    <span class="badge-tag">Premium Rooms</span>
                    <span class="badge-tag">24/7 Available</span>
                    <span class="badge-tag">High Satisfaction Rate</span>
                </div>
                <div>
                    <a href="<?php echo e(route('rooms')); ?>" class="btn-explore btn-primary btn-lg me-2">Explore Rooms</a>
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-learn">Book Now</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('bookings.create')); ?>" class="btn-learn">Book Now</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="hero-image">
                    <?php
                        $slides = collect();
                        if (!empty($featured) && $featured->isNotEmpty()) {
                            foreach ($featured as $item) {
                                $path = $item->image_path ?? null;
                                if (! $path) continue;
                                $publicCandidate = public_path($path);
                                if (file_exists($publicCandidate)) {
                                    $slides->push(asset($path));
                                } else {
                                    $slides->push(asset('storage/' . ltrim($path, '/')));
                                }
                            }
                        }
                    ?>

                    <?php if($slides->isNotEmpty()): ?>
                        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="1500">
                            <div class="carousel-inner">
                                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="carousel-item <?php echo e($i === 0 ? 'active' : ''); ?>">
                                        <img src="<?php echo e($url); ?>" class="d-block w-100" alt="Slide <?php echo e($i+1); ?>" style="border-radius:5px; height:100%; width:100%; object-fit:cover;">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="carousel-indicators">
                                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo e($i); ?>" class="<?php echo e($i === 0 ? 'active' : ''); ?>" aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Slide <?php echo e($i+1); ?>"></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-gray-400">No featured image</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-6" style="background:black;">
    <div class="container">
        <h3 style="color:#FAEBD7; margin-bottom:1.5rem; text-align:center;">Available Rooms</h3>

        <?php
            $roomChunks = ($rooms ?? collect())->chunk(3);
            // $roomChunks used for desktop (3-per-slide). Mobile will render one room per slide.
        ?>

        <?php if(($rooms ?? collect())->isNotEmpty()): ?>
            
            <div id="roomsCarouselDesktop" class="carousel slide d-none d-lg-block pb-4" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    <?php $__currentLoopData = $roomChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($si === 0 ? 'active' : ''); ?>">
                            <div class="row gy-4 justify-content-center">
                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <?php if (isset($component)) { $__componentOriginalb853c2f561e9cced24d4b94c482a0b71 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb853c2f561e9cced24d4b94c482a0b71 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.room-card','data' => ['room' => $room]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('room-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['room' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($room)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb853c2f561e9cced24d4b94c482a0b71)): ?>
<?php $attributes = $__attributesOriginalb853c2f561e9cced24d4b94c482a0b71; ?>
<?php unset($__attributesOriginalb853c2f561e9cced24d4b94c482a0b71); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb853c2f561e9cced24d4b94c482a0b71)): ?>
<?php $component = $__componentOriginalb853c2f561e9cced24d4b94c482a0b71; ?>
<?php unset($__componentOriginalb853c2f561e9cced24d4b94c482a0b71); ?>
<?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="carousel-indicators mt-3">
                    <?php $__currentLoopData = $roomChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" data-bs-target="#roomsCarouselDesktop" data-bs-slide-to="<?php echo e($i); ?>" class="<?php echo e($i === 0 ? 'active' : ''); ?>" aria-label="Slide <?php echo e($i+1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div id="roomsCarouselMobile" class="carousel slide d-lg-none pb-4" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-12 col-sm-10 col-md-8">
                                    <?php if (isset($component)) { $__componentOriginalb853c2f561e9cced24d4b94c482a0b71 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb853c2f561e9cced24d4b94c482a0b71 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.room-card','data' => ['room' => $room]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('room-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['room' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($room)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb853c2f561e9cced24d4b94c482a0b71)): ?>
<?php $attributes = $__attributesOriginalb853c2f561e9cced24d4b94c482a0b71; ?>
<?php unset($__attributesOriginalb853c2f561e9cced24d4b94c482a0b71); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb853c2f561e9cced24d4b94c482a0b71)): ?>
<?php $component = $__componentOriginalb853c2f561e9cced24d4b94c482a0b71; ?>
<?php unset($__componentOriginalb853c2f561e9cced24d4b94c482a0b71); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="carousel-indicators mt-3">
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" data-bs-target="#roomsCarouselMobile" data-bs-slide-to="<?php echo e($i); ?>" class="<?php echo e($i === 0 ? 'active' : ''); ?>" aria-label="Slide <?php echo e($i+1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <p style="color:#999; text-align:center;">No rooms available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


<?php if(($rooms ?? collect())->isNotEmpty()): ?>
    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if (isset($component)) { $__componentOriginalfbd3f2d6564a8096269114a76d561e48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfbd3f2d6564a8096269114a76d561e48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.room-modal','data' => ['room' => $room]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('room-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['room' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($room)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfbd3f2d6564a8096269114a76d561e48)): ?>
<?php $attributes = $__attributesOriginalfbd3f2d6564a8096269114a76d561e48; ?>
<?php unset($__attributesOriginalfbd3f2d6564a8096269114a76d561e48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfbd3f2d6564a8096269114a76d561e48)): ?>
<?php $component = $__componentOriginalfbd3f2d6564a8096269114a76d561e48; ?>
<?php unset($__componentOriginalfbd3f2d6564a8096269114a76d561e48); ?>
<?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Ensure modals are hidden on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing modals...');
        const modals = document.querySelectorAll('.room-modal');
        console.log('Found modals:', modals.length);
        
        modals.forEach(modal => {
            modal.classList.remove('active');
            modal.style.display = 'none';
            console.log('Hidden modal:', modal.id);
        });
        document.body.style.overflow = 'auto';
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/home.blade.php ENDPATH**/ ?>