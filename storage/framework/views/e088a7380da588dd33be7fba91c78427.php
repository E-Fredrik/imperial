<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="text-end mb-3">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="background:#FAEBD7; color:#000; border-radius:8px; padding:0.45rem 0.75rem; border:none; font-weight:600;">
                        Log out
                    </button>
                </form>
            </div>
                
            <div class="profile-card">
                <div class="profile-header" style="display:flex; align-items:center; gap:1rem;">
                    <div class="profile-info">
                        <div class="profile-avatar">
                            <?php echo e(strtoupper(substr($user->name ?? 'U', 0, 1))); ?>

                        </div>
                        <div>
                            <h2 class="profile-name"><?php echo e($user->name ?? 'John Doe'); ?></h2>
                            <p class="profile-email"><?php echo e($user->email ?? 'johndoe@gmail.com'); ?></p>
                        </div>
                    </div>

                    <?php if($user->currentBooking ?? null): ?>
                    <div class="room-badge">
                        <h6><i class="bi bi-geo-alt-fill"></i>Current Room</h6>
                        <p class="room-name">Room <?php echo e($user->currentBooking->room->room_number ?? 'A'); ?></p>
                        <p class="room-details"><?php echo e($user->currentBooking->room->type ?? 'Single'); ?> • Floor <?php echo e($user->currentBooking->room->floor ?? '1'); ?></p>
                    </div>
                    <?php else: ?>
                    <div class="room-badge">
                        <h6><i class="bi bi-geo-alt-fill"></i>Current Room</h6>
                        <p class="room-name">No Room</p>
                        <p class="room-details">Not currently renting</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="transaction-card">
                <h3>Transaction History</h3>
                <?php if(!empty($transactions) && $transactions->isNotEmpty()): ?>
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $date = $payment->paid_at ? $payment->paid_at->format('d - m - Y') : optional($payment->created_at)->format('d - m - Y');
                            $amount = 'Rp ' . number_format($payment->amount, 0, ',', '.');
                        ?>
                        <div class="transaction-item">
                            <div>
                                <div class="transaction-date"><?php echo e($date); ?></div>
                                <div class="transaction-amount">
                                    <i class="bi bi-receipt"></i>
                                    <?php echo e($amount); ?>

                                </div>
                                <div class="text-xs text-muted mt-1">
                                    Booking: #<?php echo e($payment->booking_id); ?>

                                    <?php if(optional($payment->booking)->room): ?>
                                        — Room <?php echo e(optional($payment->booking->room)->room_number); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                            <button class="transaction-info-btn" type="button" onclick="window.location.href='<?php echo e(route('bookings.show', $payment->booking_id)); ?>'">
                                <i class="bi bi-info-lg"></i>
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p>No transactions yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/profile.blade.php ENDPATH**/ ?>