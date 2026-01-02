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
     <?php $__env->slot('title', null, []); ?> Room Facilities Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Room Facilities Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-check2-square <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="card-header">
            <h3><i class="bi bi-check2-square me-2"></i>All Room Facilities</h3>
            <a href="<?php echo e(route('admin.roomfac.create')); ?>" class="btn-admin-primary">
                <i class="bi bi-plus-circle"></i> Add New Facility
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 200px;">Name</th>
                        <th>Description</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="ID"><?php echo e($facility->id); ?></td>
                            <td data-label="Name"><strong><?php echo e($facility->name); ?></strong></td>
                            <td data-label="Description">
                                <div style="max-height: 100px; overflow: auto; color: #FAEBD7;">
                                    <?php echo $facility->description; ?>

                                </div>
                            </td>
                            <td data-label="Actions">
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('admin.roomfac.edit', $facility)); ?>" class="btn-admin-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.roomfac.destroy', $facility)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
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
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No room facilities found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($facilities->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($facilities->links()); ?>

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
<?php /**PATH D:\Github\imperial\resources\views/admin/roomfac/index.blade.php ENDPATH**/ ?>