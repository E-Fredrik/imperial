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
     <?php $__env->slot('title', null, []); ?> Information Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Information Management <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-info-circle <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="admin-card">
        <div class="card-header">
            <h3>All Information</h3>
            <?php if(Route::has('admin.info.create')): ?>
                <a href="<?php echo e(route('admin.info.create')); ?>" class="btn-admin-primary">
                    <i class="bi bi-plus-circle"></i> Create New Information
                </a>
            <?php endif; ?>
        </div>

        <div style="overflow-x: auto;">

        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 200px;">Title</th>
                    <th>Content</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $information): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($information->id); ?></td>
                        <td><strong><?php echo e($information->title); ?></strong></td>
                        <td>
                            <div style="max-height: 100px; overflow: auto; color: #FAEBD7;">
                                <?php echo $information->content; ?>

                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.info.edit', $information)); ?>" class="btn-admin-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="<?php echo e(route('admin.info.destroy', $information)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
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
                        <td colspan="4" style="text-align: center; padding: 3rem; color: #666;">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p style="margin-top: 1rem;">No information entries found.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </div>

        <div style="margin-top: 2rem;">
            <?php echo e($info->links()); ?>

        </div>
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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/info/index.blade.php ENDPATH**/ ?>