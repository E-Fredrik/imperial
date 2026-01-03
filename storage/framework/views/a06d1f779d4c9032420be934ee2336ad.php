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

    <!-- Link to Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Link to external dashboard CSS -->
    <link href="<?php echo e(asset('css/admin-dashboard.css')); ?>" rel="stylesheet">

    <!-- Quick Actions Section -->
    <div class="mb-5 dashboard-quick-actions">
        <h2 class="h5 mb-4 fw-semibold dashboard-heading">
            <i class="bi bi-lightning-fill me-2"></i>Quick Actions
        </h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.rooms.create')); ?>" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-door-closed-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Add New Room</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-calendar-check-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">New Booking</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.info.create')); ?>" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-info-circle-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Add Information</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.images.create')); ?>" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-image-fill fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Upload Image</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.roomfac.index')); ?>" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-check2-square fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Manage Room Facilities</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="<?php echo e(route('admin.kostfac.index')); ?>" class="btn w-100 text-start d-flex align-items-center gap-3 admin-action-btn dashboard-btn">
                    <div class="action-icon-box">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <span class="fw-semibold fs-6">Manage Kost Facilities</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(route('admin.rooms.index')); ?>" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-building fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2"><?php echo e(\App\Models\Room::count()); ?></h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Total Rooms</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(route('admin.bookings.index')); ?>?status=booked" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-bookmark-check-fill fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2"><?php echo e(\App\Models\Booking::where('status', 'booked')->count()); ?></h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Active Bookings</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(route('admin.bookings.index')); ?>?status=pending" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-clock-history fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2"><?php echo e(\App\Models\Booking::where('status', 'pending')->count()); ?></h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Pending Bookings</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(route('admin.payments.index')); ?>?status=pending" class="text-decoration-none stat-card-link">
                <div class="card h-100 stat-card" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 16px;">
                    <div class="card-body" style="padding: 1.25rem;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="stat-icon" style="background: rgba(255, 255, 255, 0.25);">
                                <i class="bi bi-wallet2 fs-3 text-white"></i>
                            </div>
                            <i class="bi bi-arrow-right fs-4 text-white"></i>
                        </div>
                        <h3 class="display-4 fw-bold mb-2"><?php echo e(\App\Models\Payment::where('status', 'pending')->count()); ?></h3>
                        <p class="mb-0 text-uppercase small fw-semibold">Pending Payments</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Bookings & Room Status Row -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100 p-4" style="background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
                <div class="card-header bg-transparent border-0 p-0 pb-3" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 class="h5 mb-0 fw-semibold dashboard-heading d-flex align-items-center">
                        <i class="bi bi-clock-history me-2"></i>Recent Bookings
                    </h3>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-sm admin-secondary-btn">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body px-4 pb-4">
                    <?php
                        $recentBookings = \App\Models\Booking::with(['user', 'room'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    ?>
                    
                    <?php if($recentBookings->count() > 0): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="booking-item rounded-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="fw-semibold mb-1 dashboard-heading">
                                                <?php echo e(optional($booking->user)->first_name); ?> <?php echo e(optional($booking->user)->last_name); ?>

                                            </div>
                                            <small class="dashboard-text-muted">
                                                <?php echo e(optional($booking->user)->email); ?>

                                            </small>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2 booking-badge-<?php echo e($booking->status); ?>">
                                            <?php echo e(ucfirst($booking->status)); ?>

                                        </span>
                                    </div>
                                    <div class="d-flex gap-3 small dashboard-text-muted">
                                        <span><i class="bi bi-door-closed me-1"></i>Room <?php echo e(optional($booking->room)->room_number); ?></span>
                                        <span><i class="bi bi-calendar me-1"></i><?php echo e($booking->created_at->format('M d, Y')); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted opacity-25"></i>
                            <p class="dashboard-text-muted mt-3 mb-0">No bookings yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 p-4" style="background: linear-gradient(135deg, #1a1a1a 0%, #0f0f0f 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;">
                <div class="card-header bg-transparent border-0 p-0 pb-3">
                    <h3 class="h5 mb-0 fw-semibold dashboard-heading d-flex align-items-center">
                        <i class="bi bi-pie-chart-fill me-2"></i>Room Status Overview
                    </h3>
                </div>
                <div class="card-body p-0">
                    <?php
                        $roomStats = [
                            'available' => ['count' => \App\Models\Room::where('status', 'available')->count(), 'color' => '#ffffff', 'bg' => 'linear-gradient(135deg, #e5e5e5 0%, #ffffff 100%)', 'icon' => 'check-circle-fill', 'label' => 'Available'],
                            'booked' => ['count' => \App\Models\Room::where('status', 'booked')->count(), 'color' => '#ffffff', 'bg' => 'linear-gradient(135deg, #e5e5e5 0%, #ffffff 100%)', 'icon' => 'x-circle-fill', 'label' => 'Booked'],
                            'unavailable' => ['count' => \App\Models\Room::where('status', 'unavailable')->count(), 'color' => '#ffffff', 'bg' => 'linear-gradient(135deg, #e5e5e5 0%, #ffffff 100%)', 'icon' => 'exclamation-circle-fill', 'label' => 'Unavailable']
                        ];
                        $totalRooms = array_sum(array_column($roomStats, 'count'));
                    ?>

                    <?php $__currentLoopData = $roomStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $percentage = $totalRooms > 0 ? round(($data['count'] / $totalRooms) * 100) : 0;
                        ?>
                        <div class="mb-4 room-status-item">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="status-icon-box d-flex align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.1); width: 56px; height: 56px; border-radius: 12px;">
                                        <i class="bi bi-<?php echo e($data['icon']); ?> fs-3" style="color: <?php echo e($data['color']); ?>"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold" style="color: #ffffff; font-size: 1.5rem;"><?php echo e($data['count']); ?></h5>
                                        <small style="color: #999; font-size: 0.9rem;"><?php echo e($data['label']); ?> Rooms</small>
                                    </div>
                                </div>
                                <div class="percentage-circle" style="border: 3px solid <?php echo e($data['color']); ?>; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold" style="color: #ffffff; font-size: 1.1rem;"><?php echo e($percentage); ?>%</span>
                                </div>
                            </div>
                            <div class="progress room-progress" style="height: 12px; border-radius: 10px; background: rgba(255,255,255,0.1);">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo e($percentage); ?>%; background: <?php echo e($data['bg']); ?>; border-radius: 10px;" aria-valuenow="<?php echo e($percentage); ?>" aria-valuemin="0" aria-valuemax="100"></div>
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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/dashboard.blade.php ENDPATH**/ ?>