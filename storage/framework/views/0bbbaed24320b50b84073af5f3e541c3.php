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
     <?php $__env->slot('title', null, []); ?> Rooms Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Rooms Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-door-closed <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-door-closed me-2"></i>All Rooms</h3>
            <a href="<?php echo e(route('admin.rooms.create')); ?>" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Room
            </a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Floor</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="ID"><?php echo e($room->id); ?></td>
                            <td data-label="Room"><strong style="font-size: 1.1rem; color: #FAEBD7;"><?php echo e($room->room_number); ?></strong></td>
                            <td data-label="Type"><?php echo e($room->type); ?></td>
                            <td data-label="Floor"><?php echo e($room->floor); ?>F</td>
                            <td data-label="Size"><?php echo e($room->length); ?>x<?php echo e($room->width); ?>m</td>
                            <td data-label="Price"><strong>Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?></strong></td>
                            <td data-label="Status">
                                <span class="status-badge status-<?php echo e($room->status); ?>">
                                    <?php echo e(ucfirst($room->status)); ?>

                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.rooms.edit', $room)); ?>" class="btn-admin-secondary">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.rooms.destroy', $room)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Delete this room?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-admin-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No rooms found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($rooms->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($rooms->links()); ?>

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
<?php /**PATH D:\Github\imperial\resources\views/admin/rooms/index.blade.php ENDPATH**/ ?>