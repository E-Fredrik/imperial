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

    <link href="<?php echo e(asset('css/booking.css')); ?>" rel="stylesheet">

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-calendar-check me-2"></i>All Bookings</h3>
            <a href="<?php echo e(route('admin.bookings.create')); ?>" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Booking
            </a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Room</th>
                        <th>ID Card</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="ID">#<?php echo e($booking->id); ?></td>
                            <td data-label="User">
                                <div>
                                    <strong style="color: #FAEBD7;"><?php echo e($booking->user->name ?? 'N/A'); ?></strong>
                                    <small style="display: block; opacity: 0.8;"><?php echo e($booking->user->email ?? ''); ?></small>
                                </div>
                            </td>
                            <td data-label="Room">
                                <strong style="color: #FAEBD7;"><?php echo e($booking->room->room_number ?? 'N/A'); ?></strong>
                                <small style="display: block; opacity: 0.8;">Floor <?php echo e($booking->room->floor ?? ''); ?></small>
                            </td>
                            <td data-label="ID Card">
                                <?php if($booking->user->id_card): ?>
                                    <button class="btn-admin-info btn-sm" data-bs-toggle="modal" data-bs-target="#idCardModal<?php echo e($booking->id); ?>">
                                        <i class="bi bi-card-image"></i> View ID Card
                                    </button>
                                <?php else: ?>
                                    <span style="opacity: 0.6;">No ID Card</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Duration">
                                <div>
                                    <strong style="color: #FAEBD7;">Start:</strong>
                                    <span><?php echo e($booking->start_date ? \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') : 'Not set'); ?></span>
                                    <br>
                                    <strong style="color: #FAEBD7;">End:</strong>
                                    <span><?php echo e($booking->end_date ? \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') : 'Not set'); ?></span>
                                </div>
                            </td>
                            <td data-label="Status">
                                <span class="status-badge status-<?php echo e(strtolower($booking->status)); ?>">
                                    <?php echo e(strtoupper($booking->status)); ?>

                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="btn-admin-secondary btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Delete this booking?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-admin-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- ID Card Modal -->
                        <?php if($booking->user->id_card): ?>
                        <div class="modal fade" id="idCardModal<?php echo e($booking->id); ?>" tabindex="-1" aria-labelledby="idCardModalLabel<?php echo e($booking->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="background: #1a1a1a; border: 2px solid rgba(250, 235, 215, 0.2);">
                                    <div class="modal-header" style="border-bottom: 1px solid rgba(250, 235, 215, 0.1);">
                                        <h5 class="modal-title" style="color: #FAEBD7;">
                                            <i class="bi bi-card-image me-2"></i>ID Card - <?php echo e($booking->user->name); ?>

                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center" style="padding: 2rem;">
                                        <img src="<?php echo e(asset('storage/' . $booking->user->id_card)); ?>" 
                                             alt="ID Card" 
                                             style="max-width: 100%; height: auto; border-radius: 8px; cursor: zoom-in;"
                                             onclick="this.style.transform = this.style.transform === 'scale(1.5)' ? 'scale(1)' : 'scale(1.5)'">
                                        <p style="margin-top: 1rem; color: rgba(250, 235, 215, 0.7); font-size: 0.875rem;">
                                            <i class="bi bi-info-circle"></i> Click image to zoom
                                        </p>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid rgba(250, 235, 215, 0.1);">
                                        <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem;">
                                <div class="empty-state">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <p style="margin-top: 1rem; opacity: 0.7;">No bookings found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($bookings->hasPages()): ?>
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(250, 235, 215, 0.1);">
                <?php echo e($bookings->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>