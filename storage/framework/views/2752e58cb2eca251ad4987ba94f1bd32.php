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
                            <td>#<?php echo e($booking->id); ?></td>
                            <td>
                                <div>
                                    <strong><?php echo e($booking->user->name); ?></strong><br>
                                    <small style="color: rgba(250, 235, 215, 0.6);"><?php echo e($booking->user->email); ?></small>
                                </div>
                            </td>
                            <td>
                                <span style="background: rgba(250, 235, 215, 0.1); padding: 0.5rem 0.75rem; border-radius: 8px; display: inline-block;">
                                    Room <?php echo e($booking->room->room_number); ?> - Floor <?php echo e($booking->room->floor); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($booking->id_card_image): ?>
                                    <button type="button" class="btn-admin-info btn-sm" data-bs-toggle="modal" data-bs-target="#idCardModal<?php echo e($booking->id); ?>">
                                        <i class="bi bi-image"></i> View ID Card
                                    </button>
                                <?php else: ?>
                                    <span style="color: rgba(250, 235, 215, 0.4);">
                                        <i class="bi bi-x-circle"></i> No ID Card
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-size: 0.9rem;">
                                    <?php if($booking->start_date): ?>
                                        <strong>Start:</strong> <?php echo e($booking->start_date->format('M d, Y')); ?><br>
                                    <?php else: ?>
                                        <strong>Start:</strong> <span style="color: rgba(250, 235, 215, 0.4);">Not set</span><br>
                                    <?php endif; ?>
                                    
                                    <?php if($booking->end_date): ?>
                                        <strong>End:</strong> <?php echo e($booking->end_date->format('M d, Y')); ?>

                                    <?php else: ?>
                                        <strong>End:</strong> <span style="color: rgba(250, 235, 215, 0.4);">Not set</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                    $statusColors = [
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'completed' => 'secondary',
                                        'cancelled' => 'danger',
                                        'booked' => 'success'
                                    ];
                                    $color = $statusColors[$booking->status] ?? 'secondary';
                                ?>
                                <span class="status-badge status-<?php echo e($color); ?>">
                                    <?php echo e(ucfirst($booking->status)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="btn-admin-info btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="<?php echo e(route('admin.bookings.edit', $booking)); ?>" class="btn-admin-secondary btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this booking?')">
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
                        <?php if($booking->id_card_image): ?>
                        <div class="modal fade" id="idCardModal<?php echo e($booking->id); ?>" tabindex="-1" aria-labelledby="idCardModalLabel<?php echo e($booking->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="background: #0a0a0a; border: 1px solid rgba(250, 235, 215, 0.2); border-radius: 16px;">
                                    <div class="modal-header" style="border-bottom: 1px solid rgba(250, 235, 215, 0.1);">
                                        <h5 class="modal-title" id="idCardModalLabel<?php echo e($booking->id); ?>" style="color: #FAEBD7;">
                                            <i class="bi bi-card-image me-2"></i>ID Card - <?php echo e($booking->user->name); ?>

                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding: 2rem;">
                                        <div class="text-center">
                                            <img src="<?php echo e(Storage::url($booking->id_card_image)); ?>" 
                                                 alt="ID Card for <?php echo e($booking->user->name); ?>" 
                                                 style="max-width: 100%; height: auto; border-radius: 12px; border: 1px solid rgba(250, 235, 215, 0.2);">
                                        </div>
                                        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(250, 235, 215, 0.05); border-radius: 12px; border: 1px solid rgba(250, 235, 215, 0.1);">
                                            <p style="margin: 0; color: rgba(250, 235, 215, 0.8); font-size: 0.9rem;">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <strong>Booking ID:</strong> #<?php echo e($booking->id); ?> | 
                                                <strong>Room:</strong> <?php echo e($booking->room->room_number); ?> | 
                                                <strong>Status:</strong> <?php echo e(ucfirst($booking->status)); ?>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="border-top: 1px solid rgba(250, 235, 215, 0.1);">
                                        <a href="<?php echo e(Storage::url($booking->id_card_image)); ?>" 
                                           download="ID_Card_<?php echo e($booking->user->name); ?>_Booking_<?php echo e($booking->id); ?>.jpg" 
                                           class="btn-admin-primary">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <button type="button" class="btn-admin-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem;">
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x" style="font-size: 3rem; color: rgba(250, 235, 215, 0.3); margin-bottom: 1rem;"></i>
                                    <p style="color: rgba(250, 235, 215, 0.6); margin: 0;">No bookings found.</p>
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
<?php endif; ?>

<style>
.btn-sm {
    padding: 0.4rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.modal-content .modal-body img {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
}

@media (max-width: 575px) {
    .modal-dialog {
        margin: 1rem;
    }
    
    .modal-body {
        padding: 1rem !important;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-buttons form {
        width: 100%;
    }
    
    .action-buttons .btn-sm {
        width: 100%;
        justify-content: center;
    }
}
</style><?php /**PATH D:\Github\imperial\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>