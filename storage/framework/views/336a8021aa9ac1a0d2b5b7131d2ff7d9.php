<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?php echo e(asset('css/room.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 mb-5 mb-lg-0">
                <h1 class="hero-title">Your Premium Boarding Experience</h1>
                <p class="hero-description">
                    Discover comfort and convenience with our modern boarding house. Interactive room 
                    selection, instant booking, and premium amenities await you.
                </p>
                <div class="mb-4">
                    <span class="badge-tag"><i class="bi bi-star-fill me-1"></i>Premium Rooms</span>
                    <span class="badge-tag"><i class="bi bi-clock-fill me-1"></i>24/7 Available</span>
                    <span class="badge-tag"><i class="bi bi-heart-fill me-1"></i>High Satisfaction</span>
                </div>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo e(route('rooms')); ?>" class="btn-explore btn-primary btn-lg">
                        <i class="bi bi-compass me-2"></i>Explore Rooms
                    </a>
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn-learn">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('bookings.create')); ?>" class="btn-learn">
                            <i class="bi bi-calendar-check me-2"></i>Book Now
                        </a>
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
                        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                            <div class="carousel-inner">
                                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="carousel-item <?php echo e($i === 0 ? 'active' : ''); ?>">
                                        <img src="<?php echo e($url); ?>" class="d-block w-100" alt="Slide <?php echo e($i+1); ?>" style="border-radius:20px; height:100%; width:100%; object-fit:cover;">
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
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(250, 235, 215, 0.05); border-radius: 20px; height: 450px; border: 2px dashed rgba(250, 235, 215, 0.2);">
                            <div style="text-align: center;">
                                <i class="bi bi-image" style="font-size: 4rem; color: rgba(250, 235, 215, 0.3);"></i>
                                <p style="color: #666; margin-top: 1rem;">No featured image</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="rooms-section-home">
    <div class="container">
        <h2 class="section-title text-center">Available Rooms</h2>
        <p class="section-subtitle text-center">Browse through our carefully curated selection of premium boarding rooms</p>

        <?php
            $roomChunks = ($rooms ?? collect())->chunk(3);
        ?>

        <?php if(($rooms ?? collect())->isNotEmpty()): ?>
            
            <div id="roomsCarouselDesktop" class="carousel slide d-none d-lg-block" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <?php $__currentLoopData = $roomChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                            <div>
                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($roomChunks->count() > 1): ?>
                    <div class="carousel-indicators">
                        <?php $__currentLoopData = $roomChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-bs-target="#roomsCarouselDesktop" data-bs-slide-to="<?php echo e($index); ?>" class="<?php echo e($index === 0 ? 'active' : ''); ?>" aria-label="Slide <?php echo e($index + 1); ?>"></button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            
            <div id="roomsCarouselMobile" class="carousel slide d-lg-none" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                            <div class="d-flex justify-content-center">
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($rooms->count() > 1): ?>
                    <div class="carousel-indicators">
                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-bs-target="#roomsCarouselMobile" data-bs-slide-to="<?php echo e($index); ?>" class="<?php echo e($index === 0 ? 'active' : ''); ?>" aria-label="Slide <?php echo e($index + 1); ?>"></button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rooms-empty-state">
                <i class="bi bi-inbox"></i>
                <p>No rooms available at the moment</p>
            </div>
        <?php endif; ?>
    </div>
</section>


<?php if(($rooms ?? collect())->isNotEmpty()): ?>
    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('components.room-modal', ['room' => $room], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/roomModal.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\imperial\resources\views/home.blade.php ENDPATH**/ ?>