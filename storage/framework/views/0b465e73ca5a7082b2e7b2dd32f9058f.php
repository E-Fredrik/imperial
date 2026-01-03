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
     <?php $__env->slot('title', null, []); ?> Payments Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Payments Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-credit-card <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-credit-card me-2"></i>All Payments</h3>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-admin-primary">
                    <i class="bi bi-plus-circle"></i> New Booking
                </a>
            </div>
        </div>

        <div class="mb-3 p-3" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px;">
            <p style="color: #60a5fa; font-size: 0.9rem; margin: 0;">
                <i class="bi bi-info-circle me-1"></i>
                <strong>Note:</strong> Payments are processed via Midtrans. Status updates automatically when customers complete payment. You can still manually accept/decline payments for cash or offline transactions.
            </p>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 100px;">Booking</th>
                        <th style="width: 180px;">User</th>
                        <th style="width: 100px;">Room</th>
                        <th style="width: 120px;">Month</th>
                        <th style="width: 130px;">Amount</th>
                        <th style="width: 120px;">Payment Type</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="ID"><?php echo e($payment->id); ?></td>
                            <td data-label="Booking">
                                <a href="<?php echo e(route('admin.bookings.show', $payment->booking_id)); ?>" style="color: #60a5fa; text-decoration: underline;">
                                    #<?php echo e($payment->booking_id); ?>

                                </a>
                            </td>
                            <td data-label="User">
                                <div>
                                    <strong><?php echo e(optional($payment->booking->user)->first_name ?? '-'); ?> <?php echo e(optional($payment->booking->user)->last_name ?? ''); ?></strong>
                                </div>
                                <div style="font-size: 0.75rem; color: #999;">
                                    <?php echo e(optional($payment->booking->user)->email ?? ''); ?>

                                </div>
                            </td>
                            <td data-label="Room">
                                <strong><?php echo e(optional($payment->booking->room)->room_number ?? '-'); ?></strong>
                            </td>
                            <td data-label="Month">
                                <?php echo e($payment->payment_for_month); ?>

                            </td>
                            <td data-label="Amount">
                                <strong>Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></strong>
                                <?php if($payment->late_fee > 0): ?>
                                    <div style="font-size: 0.75rem; color: #f87171;">
                                        +Rp <?php echo e(number_format($payment->late_fee, 0, ',', '.')); ?> late fee
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td data-label="Payment Type">
                                <span style="font-size: 0.875rem; color: #999;">
                                    <?php echo e($payment->payment_type ?? 'N/A'); ?>

                                </span>
                            </td>
                            <td data-label="Status">
                                <span class="status-badge status-<?php echo e($payment->status); ?>">
                                    <?php echo e(ucfirst($payment->status)); ?>

                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="<?php echo e(route('admin.bookings.show', $payment->booking_id)); ?>" class="btn-admin-info" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    
                                    <?php if($payment->status === 'pending'): ?>
                                        <form method="POST" action="<?php echo e(route('admin.payments.update', $payment)); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="action" value="accept" />
                                            <button type="submit" class="btn-admin-primary" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;" title="Manual accept (for cash payments)">
                                                <i class="bi bi-check-circle"></i> Accept
                                            </button>
                                        </form>

                                        <form method="POST" action="<?php echo e(route('admin.payments.update', $payment)); ?>" onsubmit="return confirm('Decline this payment?');" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="hidden" name="action" value="decline" />
                                            <button type="submit" class="btn-admin-danger" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;">
                                                <i class="bi bi-x-circle"></i> Decline
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No payments found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($payments->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($payments->links()); ?>

            </div>
        <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>