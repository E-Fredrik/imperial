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
     <?php $__env->slot('title', null, []); ?> Add Kost Facility <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Add Kost Facility <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-building <?php $__env->endSlot(); ?>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-building me-2"></i>Create New Kost Facility</h3>
            <a href="<?php echo e(route('admin.kostfac.index')); ?>" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Facilities
            </a>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert-danger">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.kostfac.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Name -->
            <div class="form-group">
                <label for="name">
                    <i class="bi bi-tag me-1"></i>Facility Name
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="<?php echo e(old('name')); ?>"
                    required
                    placeholder="e.g., WiFi, Parking, Swimming Pool">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">
                    <i class="bi bi-card-text me-1"></i>Description
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    placeholder="Describe the facility details..."><?php echo e(old('description')); ?></textarea>
            </div>

            <!-- Images -->
            <div class="form-group">
                <label for="images">
                    <i class="bi bi-images me-1"></i>Facility Images (Optional)
                </label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    multiple 
                    accept="image/*">
                <small>
                    <i class="bi bi-info-circle me-1"></i>You can select multiple images (PNG, JPG, JPEG)
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.kostfac.index')); ?>" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Create Facility
                </button>
            </div>
        </form>
    </div>

    <script src="<?php echo e(asset('js/editRoom.js')); ?>"></script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/kostfac/create.blade.php ENDPATH**/ ?>