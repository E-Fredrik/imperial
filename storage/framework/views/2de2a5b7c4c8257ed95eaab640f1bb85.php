<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Bookings Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Bookings Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-calendar-check <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="card-header">
            <h3>All Bookings</h3>
            <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Create Booking
            </a>
        </div>

        <div style="overflow-x: auto;">

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Room</th>
                    <th>Move-in</th>
                    <th>Rent</th>
                    <th>Proof</th>
                    <th>Payments</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($booking->id); ?></td>
                        <td>
                            <?php echo e(optional($booking->user)->first_name ?? '-'); ?>

                            <?php echo e(optional($booking->user)->last_name ?? ''); ?><br/>
                            <span style="font-size: 0.75rem; color: #999;"><?php echo e(optional($booking->user)->email ?? ''); ?></span>
                        </td>
                        <td><strong><?php echo e(optional($booking->room)->room_number ?? '-'); ?></strong></td>
                        <td><?php echo e(optional($booking->move_in_date)->format('Y-m-d') ?? '-'); ?></td>
                        <td>Rp <?php echo e(number_format($booking->monthly_rent, 0, ',', '.')); ?></td>
                        <td>
                                            <?php
                                                $p = $booking->payments->last();
                                                $proofPath = $p->proof ?? '';
                                                if ($proofPath !== '' && file_exists(public_path($proofPath))) {
                                                    $proofUrl = asset($proofPath);
                                                } elseif ($proofPath) {
                                                    $proofUrl = asset('storage/' . ltrim($proofPath, '/'));
                                                } else {
                                                    $proofUrl = null;
                                                }
                                            ?>
                            <?php if($proofUrl): ?>
                                <a href="<?php echo e($proofUrl); ?>" target="_blank" class="btn-admin-info" style="padding: 0.3rem 0.8rem; font-size: 0.8rem;">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            <?php else: ?>
                                <span style="color: #666;">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php $__currentLoopData = $booking->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="margin-bottom: 0.5rem;">
                                    <strong>Rp <?php echo e(number_format($p->amount, 0, ',', '.')); ?></strong>
                                    <span style="color: #999; font-size: 0.75rem;"> — <?php echo e($p->status); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                            <span class="badge-status badge-<?php echo e($booking->status); ?>">
                                <?php echo e($booking->status); ?>

                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="btn-admin-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <?php if($booking->status === 'pending'): ?>
                                    <form action="<?php echo e(route('admin.bookings.decline', $booking)); ?>" method="POST" onsubmit="return confirm('Decline this booking and the latest payment?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn-admin-danger">
                                            <i class="bi bi-x-circle"></i> Decline
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 3rem; color: #666;">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p style="margin-top: 1rem;">No bookings found.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </div>

        <div style="margin-top: 2rem;">
            <?php echo e($bookings->links()); ?>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>