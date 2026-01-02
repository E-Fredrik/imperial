<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <!-- Session Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <span><?php echo e(session('info')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Profile Header Card -->
            <div class="profile-header-card mb-4">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="profile-avatar-modern">
                                <?php echo e(strtoupper(substr($user->name ?? 'U', 0, 1))); ?>

                            </div>
                            <div class="flex-grow-1">
                                <h2 class="profile-name-modern"><?php echo e($user->name ?? 'John Doe'); ?></h2>
                                <p class="profile-email-modern">
                                    <i class="bi bi-envelope-fill me-2"></i><?php echo e($user->email ?? 'johndoe@gmail.com'); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-lg-end">
                            <?php if($user->currentBooking ?? null): ?>
                                <div class="room-badge-modern">
                                    <div class="room-badge-header">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>Current Room</span>
                                    </div>
                                    <h4 class="room-badge-room">Room <?php echo e($user->currentBooking->room->room_number ?? 'A'); ?></h4>
                                    <p class="room-badge-details">
                                        <?php echo e($user->currentBooking->room->type ?? 'Single'); ?> • Floor <?php echo e($user->currentBooking->room->floor ?? '1'); ?>

                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="room-badge-modern room-badge-empty">
                                    <div class="room-badge-header">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>Current Room</span>
                                    </div>
                                    <h4 class="room-badge-room">No Room</h4>
                                    <p class="room-badge-details">Not currently renting</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History Card -->
            <div class="transaction-history-card">
                <div class="transaction-history-header">
                    <h3 class="transaction-history-title">
                        <i class="bi bi-clock-history"></i> Transaction History
                    </h3>
                </div>

                <?php if(!empty($transactions) && $transactions->isNotEmpty()): ?>
                    <div class="transaction-list">
                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $date = $payment->paid_at ? $payment->paid_at->format('d M Y') : optional($payment->created_at)->format('d M Y');
                                $amount = 'Rp ' . number_format($payment->amount, 0, ',', '.');
                                $statusClass = match($payment->status) {
                                    'accepted' => 'success',
                                    'pending' => 'warning',
                                    'declined' => 'danger',
                                    default => 'secondary'
                                };
                            ?>
                            <div class="transaction-item-modern">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-8">
                                        <div class="transaction-info">
                                            <div class="transaction-date">
                                                <i class="bi bi-calendar3"></i>
                                                <?php echo e($date); ?>

                                            </div>
                                            <div class="transaction-amount">
                                                <i class="bi bi-receipt"></i>
                                                <?php echo e($amount); ?>

                                            </div>
                                            <div class="transaction-booking">
                                                <i class="bi bi-hash"></i>
                                                Booking: <?php echo e($payment->booking_id); ?>

                                                <?php if(optional($payment->booking)->room): ?>
                                                    — <i class="bi bi-door-closed ms-1"></i> Room <?php echo e(optional($payment->booking->room)->room_number); ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column align-items-md-end gap-2">
                                            <span class="badge badge-<?php echo e($statusClass); ?>">
                                                <?php echo e(ucfirst($payment->status)); ?>

                                            </span>
                                            <?php if($payment->status === 'pending'): ?>
                                                <a href="<?php echo e(route('payment.show', $payment)); ?>" class="link-complete-payment">
                                                    Complete Payment <i class="bi bi-arrow-right"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="transaction-empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>No transactions yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/profile.blade.php ENDPATH**/ ?>