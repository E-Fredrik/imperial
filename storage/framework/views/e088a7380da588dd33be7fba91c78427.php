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
                                <div class="text-center" style="color: #999;">
                                    <i class="bi bi-house-x" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p style="margin-top: 0.5rem; font-size: 0.875rem;">No active booking</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Payments Section (NEW) -->
            <?php if(!empty($upcomingPayments) && $upcomingPayments->isNotEmpty()): ?>
                <div class="upcoming-payments-card mb-4">
                    <div class="upcoming-payments-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-check-fill" style="font-size: 1.5rem; color: #3b82f6;"></i>
                            <h3 class="upcoming-payments-title">Upcoming Payments</h3>
                        </div>
                        <a href="<?php echo e(route('payments.upcoming')); ?>" class="btn-view-all">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="upcoming-payments-list">
                        <?php $__currentLoopData = $upcomingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $paymentMonth = \Carbon\Carbon::createFromFormat('Y-m', $payment->payment_for_month);
                                $dueDate = $paymentMonth->copy()->startOfMonth();
                                $today = now()->startOfDay();
                                $daysUntilDue = $today->diffInDays($dueDate, false);
                                $isOverdue = $daysUntilDue < 0;
                                $isDueSoon = $daysUntilDue >= 0 && $daysUntilDue <= 7;
                                
                                if ($isOverdue) {
                                    $statusBadgeClass = 'status-overdue';
                                    $statusText = 'Overdue';
                                } elseif ($isDueSoon) {
                                    $statusBadgeClass = 'status-due-soon';
                                    $statusText = 'Due Soon';
                                } else {
                                    $statusBadgeClass = 'status-upcoming';
                                    $statusText = 'Upcoming';
                                }
                            ?>

                            <div class="upcoming-payment-item <?php echo e($isOverdue ? 'overdue' : ''); ?>">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-8">
                                        <div class="upcoming-payment-info">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <h4 class="upcoming-payment-month"><?php echo e($paymentMonth->format('F Y')); ?></h4>
                                                <span class="upcoming-status-badge <?php echo e($statusBadgeClass); ?>">
                                                    <?php echo e($statusText); ?>

                                                </span>
                                            </div>
                                            <div class="upcoming-payment-details">
                                                <span class="detail-item">
                                                    <i class="bi bi-door-closed"></i>
                                                    Room <?php echo e(optional($payment->booking->room)->room_number ?? '-'); ?>

                                                </span>
                                                <span class="detail-item">
                                                    <i class="bi bi-calendar3"></i>
                                                    Due: <?php echo e($dueDate->format('M d, Y')); ?>

                                                </span>
                                                <span class="detail-item">
                                                    <i class="bi bi-clock"></i>
                                                    <?php if($isOverdue): ?>
                                                        <span style="color: #f87171;"><?php echo e(abs($daysUntilDue)); ?> days overdue</span>
                                                    <?php else: ?>
                                                        In <?php echo e($daysUntilDue); ?> days
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column align-items-md-end gap-2">
                                            <div class="upcoming-payment-amount">
                                                Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                                            </div>
                                            <?php if($payment->late_fee > 0): ?>
                                                <small style="color: #f87171; font-size: 0.75rem;">
                                                    +Rp <?php echo e(number_format($payment->late_fee, 0, ',', '.')); ?> late fee
                                                </small>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('payment.show', $payment)); ?>" class="btn-pay-upcoming">
                                                <i class="bi bi-credit-card"></i> Pay Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Urgent Payments Card -->
            <?php if(!empty($pendingPayments) && $pendingPayments->isNotEmpty()): ?>
                <div class="urgent-payments-card mb-4">
                    <div class="urgent-payments-header">
                        <h3 class="urgent-payments-title">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Action Required
                        </h3>
                        <span class="badge" style="background: #fbbf24; color: #000; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                            <?php echo e($pendingPayments->count()); ?> <?php echo e($pendingPayments->count() === 1 ? 'Payment' : 'Payments'); ?>

                        </span>
                    </div>

                    <div class="urgent-payments-list">
                        <?php $__currentLoopData = $pendingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $paymentDate = \Carbon\Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
                                $daysUntilDue = now()->diffInDays($paymentDate, false);
                                $isOverdue = $daysUntilDue < 0;
                            ?>

                            <div class="payment-item <?php echo e($isOverdue ? 'payment-item-overdue' : ''); ?>">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-8">
                                        <div class="payment-item-info">
                                            <div class="payment-item-date">
                                                <i class="bi bi-calendar-event"></i>
                                                <?php echo e($paymentDate->format('F Y')); ?>

                                                <?php if($isOverdue): ?>
                                                    <span class="badge badge-danger">Overdue by <?php echo e(abs($daysUntilDue)); ?> days</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Due in <?php echo e($daysUntilDue); ?> days</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="payment-item-amount">
                                                Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                                            </div>
                                            <div class="payment-item-room">
                                                <i class="bi bi-door-closed"></i>
                                                Room <?php echo e(optional($payment->booking->room)->room_number ?? '-'); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-md-end">
                                            <a href="<?php echo e(route('payment.show', $payment)); ?>" class="btn-pay-now">
                                                <i class="bi bi-credit-card"></i> Pay Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="urgent-payments-footer">
                        <a href="<?php echo e(route('payments.upcoming')); ?>" class="btn-schedule-view">
                            <i class="bi bi-calendar-range"></i>
                            View Full Payment Schedule
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Transaction History Card -->
            <div class="transaction-history-card">
                <div class="transaction-history-header">
                    <h3 class="transaction-history-title">
                        <i class="bi bi-clock-history"></i>
                        Transaction History
                    </h3>
                    <?php if($totalPendingCount > 0): ?>
                        <span class="badge" style="background: #f87171; color: #fff; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                            <?php echo e($totalPendingCount); ?> Pending
                        </span>
                    <?php endif; ?>
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