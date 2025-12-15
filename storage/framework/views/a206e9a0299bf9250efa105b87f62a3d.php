<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Dashboard <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Dashboard <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-speedometer2 <?php $__env->endSlot(); ?>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-door-closed"></i>
            </div>
            <div class="stat-value"><?php echo e(\App\Models\Room::count()); ?></div>
            <div class="stat-label">Total Rooms</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value"><?php echo e(\App\Models\Booking::where('status', 'booked')->count()); ?></div>
            <div class="stat-label">Active Bookings</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value"><?php echo e(\App\Models\Booking::where('status', 'pending')->count()); ?></div>
            <div class="stat-label">Pending Bookings</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-credit-card"></i>
            </div>
            <div class="stat-value"><?php echo e(\App\Models\Payment::where('status', 'pending')->count()); ?></div>
            <div class="stat-label">Pending Payments</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-lightning"></i> Quick Actions</h3>
        </div>
        
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.rooms.create')); ?>" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add New Room</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-calendar-plus"></i>
                    <span>New Booking</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.info.create')); ?>" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-file-plus"></i>
                    <span>Add Information</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.images.create')); ?>" class="btn-admin-primary w-100" style="padding: 1.25rem; justify-content: center;">
                    <i class="bi bi-upload"></i>
                    <span>Upload Image</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <h3><i class="bi bi-clock-history"></i> Recent Bookings</h3>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn-admin-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        View All
                    </a>
                </div>
                
                <?php
                    $recentBookings = \App\Models\Booking::with(['user', 'room'])
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                ?>
                
                <?php if($recentBookings->count() > 0): ?>
                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php echo e(optional($booking->user)->first_name); ?> <?php echo e(optional($booking->user)->last_name); ?><br>
                                            <small style="color: #999;"><?php echo e(optional($booking->user)->email); ?></small>
                                        </td>
                                        <td><strong>Room <?php echo e(optional($booking->room)->room_number); ?></strong></td>
                                        <td>
                                            <span class="badge-status badge-<?php echo e($booking->status); ?>">
                                                <?php echo e($booking->status); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="color: #999; text-align: center; padding: 2rem;">No bookings yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <h3><i class="bi bi-door-closed"></i> Room Status</h3>
                </div>
                
                <?php
                    $roomStats = [
                        'available' => \App\Models\Room::where('status', 'available')->count(),
                        'booked' => \App\Models\Room::where('status', 'booked')->count(),
                        'unavailable' => \App\Models\Room::where('status', 'unavailable')->count(),
                    ];
                    $total = array_sum($roomStats);
                ?>
                
                <div style="display: grid; gap: 1rem;">
                    <?php $__currentLoopData = $roomStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: #2a2a2a; border-radius: 10px; border-left: 4px solid <?php echo e($status === 'available' ? '#22c55e' : ($status === 'booked' ? '#ef4444' : '#6b7280')); ?>;">
                            <div>
                                <div style="font-size: 0.875rem; color: #999; text-transform: uppercase; margin-bottom: 0.25rem;"><?php echo e($status); ?></div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #FAEBD7;"><?php echo e($count); ?> <span style="font-size: 0.875rem; color: #999;">rooms</span></div>
                            </div>
                            <div style="width: 60px; height: 60px; border-radius: 12px; background: <?php echo e($status === 'available' ? '#22c55e' : ($status === 'booked' ? '#ef4444' : '#6b7280')); ?>; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff;">
                                <?php echo e($total > 0 ? round(($count / $total) * 100) : 0); ?>%
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

<?php /**PATH D:\Github\imperial\resources\views/dashboard.blade.php ENDPATH**/ ?>