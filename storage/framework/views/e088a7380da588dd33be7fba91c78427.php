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

            <?php if(session('success')): ?>
                <div class="alert alert-success" style="background:#1a3a1a; color:#4ade80; border:1px solid #166534; border-radius:8px; padding:1rem; margin-bottom:1rem;">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger" style="background:#3a1a1a; color:#f87171; border:1px solid #991b1b; border-radius:8px; padding:1rem; margin-bottom:1rem;">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info" style="background:#1a2a3a; color:#60a5fa; border:1px solid #1e40af; border-radius:8px; padding:1rem; margin-bottom:1rem;">
                    <?php echo e(session('info')); ?>

                </div>
            <?php endif; ?>
                
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

            
            <?php if($totalPendingCount > 0): ?>
            <div class="transaction-card" style="background:#1a1a1a; border:1px solid #3b82f6; margin-bottom:1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="color:#3b82f6; margin: 0;">
                            <i class="bi bi-calendar-event"></i> Payment Schedule
                        </h3>
                        <p style="color: #999; margin: 0.5rem 0 0 0; font-size: 0.875rem;">
                            You have <strong><?php echo e($totalPendingCount); ?></strong> upcoming payment(s)
                            <?php if($pendingPayments->isNotEmpty()): ?>
                                <span style="color: #fbbf24;">• <?php echo e($pendingPayments->count()); ?> due soon</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <a href="<?php echo e(route('payments.upcoming')); ?>" 
                       class="btn" 
                       style="background:#3b82f6; color:#fff; font-weight:600; padding:0.75rem 1.5rem; border-radius:8px; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem;">
                        <i class="bi bi-calendar-check"></i>
                        View Payment Schedule
                    </a>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if($pendingPayments->isNotEmpty()): ?>
            <div class="transaction-card" style="background:#1a1a0a; border:1px solid #fbbf24; margin-bottom:1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="color:#fbbf24; margin: 0;">
                        <i class="bi bi-exclamation-triangle"></i> Urgent Payments
                        <span style="font-size: 0.75rem; background: #f87171; color: #fff; padding: 0.25rem 0.5rem; border-radius: 4px; margin-left: 0.5rem;">
                            <?php echo e($pendingPayments->count()); ?>

                        </span>
                    </h3>
                    <?php if($totalPendingCount > $pendingPayments->count()): ?>
                        <a href="<?php echo e(route('payments.upcoming')); ?>" 
                           style="color:#60a5fa; font-size:0.875rem; text-decoration:none;">
                            View all <?php echo e($totalPendingCount); ?> payments →
                        </a>
                    <?php endif; ?>
                </div>
                
                <?php $__currentLoopData = $pendingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $paymentDate = \Carbon\Carbon::createFromFormat('Y-m', $payment->payment_for_month)->startOfMonth();
                        $daysUntilDue = now()->diffInDays($paymentDate, false);
                        $isOverdue = $daysUntilDue < 0;
                    ?>
                    <div class="transaction-item" style="display:flex; justify-content:space-between; align-items:center; <?php echo e($isOverdue ? 'border-left: 3px solid #f87171; padding-left: 1rem;' : ''); ?>">
                        <div style="flex: 1;">
                            <div class="transaction-date">
                                <?php echo e($payment->payment_for_month); ?>

                                <?php if($isOverdue): ?>
                                    <span style="color: #f87171; font-size: 0.75rem; margin-left: 0.5rem;">
                                        <i class="bi bi-exclamation-circle"></i> OVERDUE
                                    </span>
                                <?php else: ?>
                                    <span style="color: #fbbf24; font-size: 0.75rem; margin-left: 0.5rem;">
                                        <i class="bi bi-clock"></i> Due in <?php echo e($daysUntilDue); ?> days
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="transaction-amount">
                                Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                            </div>
                            <div class="text-xs text-muted mt-1">
                                Room <?php echo e(optional($payment->booking->room)->room_number ?? '-'); ?>

                            </div>
                        </div>
                        <a href="<?php echo e(route('payment.show', $payment)); ?>" 
                           class="btn" 
                           style="background:#FAEBD7; color:#000; font-weight:600; padding:0.5rem 1.5rem; border-radius:8px; text-decoration:none;">
                            Pay Now
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($totalPendingCount > $pendingPayments->count()): ?>
                    <div style="margin-top: 1rem; padding: 0.75rem; background: #1a1a1a; border-radius: 8px; text-align: center;">
                        <a href="<?php echo e(route('payments.upcoming')); ?>" 
                           style="color:#60a5fa; text-decoration:none; font-weight:600;">
                            <i class="bi bi-calendar-check"></i> 
                            View <?php echo e($totalPendingCount - $pendingPayments->count()); ?> more upcoming payment(s)
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="transaction-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="margin: 0;">Transaction History</h3>
                    <?php if($totalPendingCount > 0 && $pendingPayments->isEmpty()): ?>
                        <a href="<?php echo e(route('payments.upcoming')); ?>" 
                           class="btn btn-sm" 
                           style="background:#3b82f6; color:#fff; font-weight:600; padding:0.5rem 1rem; border-radius:8px; text-decoration:none; font-size:0.875rem;">
                            <i class="bi bi-calendar-check"></i> View Payment Schedule
                        </a>
                    <?php endif; ?>
                </div>
                <?php if(!empty($transactions) && $transactions->isNotEmpty()): ?>
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $date = $payment->paid_at ? $payment->paid_at->format('d - m - Y') : optional($payment->created_at)->format('d - m - Y');
                            $amount = 'Rp ' . number_format($payment->amount, 0, ',', '.');
                            $statusColor = match($payment->status) {
                                'accepted' => '#4ade80',
                                'pending' => '#fbbf24',
                                'declined' => '#f87171',
                                default => '#999'
                            };
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
                            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:0.5rem;">
                                <span style="color:<?php echo e($statusColor); ?>; font-weight:600; font-size:0.85rem; text-transform:uppercase;">
                                    <?php echo e($payment->status); ?>

                                </span>
                                <?php if($payment->status === 'pending'): ?>
                                    <a href="<?php echo e(route('payment.show', $payment)); ?>" 
                                       style="color:#FAEBD7; font-size:0.85rem; text-decoration:underline;">
                                        Complete Payment →
                                    </a>
                                <?php endif; ?>
                            </div>
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