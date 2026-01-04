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
     <?php $__env->slot('title', null, []); ?> Edit Kost Facility <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Edit Kost Facility <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-building <?php $__env->endSlot(); ?>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-building me-2"></i>Edit Kost Facility</h3>
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

        <form action="<?php echo e(route('admin.kostfac.update', $kostfac)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Name -->
            <div class="form-group">
                <label for="name">
                    <i class="bi bi-tag me-1"></i>Facility Name
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="<?php echo e(old('name', $kostfac->name)); ?>"
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
                    placeholder="Describe the facility details..."><?php echo e(old('description', $kostfac->description)); ?></textarea>
            </div>

            <!-- Existing Images -->
            <?php if($kostfac->facilities_images->isNotEmpty()): ?>
                <div class="form-group">
                    <label>
                        <i class="bi bi-images me-1"></i>Existing Images
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                        <?php $__currentLoopData = $kostfac->facilities_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $image = $fi->image;
                                $path = $image->image_path ?? '';
                                $publicCandidate = public_path($path);
                                if ($path !== '' && file_exists($publicCandidate)) {
                                    $imgUrl = asset($path);
                                } else {
                                    $imgUrl = asset('storage/' . ltrim($path, '/'));
                                }
                            ?>
                            <div style="position: relative; background: rgba(250, 235, 215, 0.05); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 10px; padding-top: 0.75rem; padding-right: 0.75rem; padding-left: 0.75rem;">
                                <img
                                    id="thumb-<?php echo e($image->id); ?>"
                                    data-image-id="<?php echo e($image->id); ?>"
                                    data-original-src="<?php echo e($imgUrl); ?>"
                                    src="<?php echo e($imgUrl); ?>"
                                    alt="Facility image"
                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 0.8rem;"
                                />
                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <label for="replace-<?php echo e($image->id); ?>" style="cursor: pointer; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 6px; padding: 0.5rem; text-align: center; color: #60a5fa; font-size: 0.875rem; transition: all 0.2s;">
                                        <i class="bi bi-arrow-repeat me-1"></i>Replace
                                    </label>
                                    <input 
                                        id="replace-<?php echo e($image->id); ?>"
                                        type="file"
                                        name="replace_images[<?php echo e($image->id); ?>]"
                                        accept="image/*"
                                        class="replace-input"
                                        data-image-id="<?php echo e($image->id); ?>"
                                        style="display: none;">
                                    <span id="status-<?php echo e($image->id); ?>" style="font-size: 0.75rem; color: #999; text-align: center; min-height: 1rem;"></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Add New Images -->
            <div class="form-group">
                <label for="images">
                    <i class="bi bi-images me-1"></i>Add New Images (Optional)
                </label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    multiple 
                    accept="image/*">
                <small>
                    <i class="bi bi-info-circle me-1"></i>Upload additional images (PNG, JPG, JPEG)
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.kostfac.index')); ?>" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Update Facility
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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/kostfac/edit.blade.php ENDPATH**/ ?>