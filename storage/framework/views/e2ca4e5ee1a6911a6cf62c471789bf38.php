<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
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
                    <a href="<?php echo e(route('rooms')); ?>" class="btn-explore">Explore Rooms →</a>
                    <a href="#" class="btn-learn">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6">
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
                                        <img src="<?php echo e($url); ?>" class="d-block w-100" alt="Slide <?php echo e($i+1); ?>" style="border-radius:5px; height:400px; object-fit:cover;">
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

<!-- available rooms cards (keeps page black background) -->
<section class="py-6" style="background:black;">
    <div class="container">
        <h3 style="color:#FAEBD7; margin-bottom:1rem;">Available Rooms</h3>

        <?php
            $roomChunks = ($rooms ?? collect())->chunk(3);
        ?>

        <?php if(($rooms ?? collect())->isNotEmpty()): ?>
            <div id="roomsCarousel" class="carousel slide pb-4" data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                    <?php $__currentLoopData = $roomChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $si => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($si === 0 ? 'active' : ''); ?>">
                            <div class="row gy-4">
                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-md-6 col-lg-4">
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
                        <button type="button" data-bs-target="#roomsCarousel" data-bs-slide-to="<?php echo e($i); ?>" class="<?php echo e($i === 0 ? 'active' : ''); ?>" aria-label="Slide <?php echo e($i+1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-muted" style="color:#cfc6bc;">No rooms available at the moment.</div>
        <?php endif; ?>
     </div>
 </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<!-- Bootstrap bundle for carousel (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/home.blade.php ENDPATH**/ ?>