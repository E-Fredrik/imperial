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
     <?php $__env->slot('title', null, []); ?> Upload Image <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Upload Image <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-image <?php $__env->endSlot(); ?>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-upload me-2"></i>Upload New Image</h3>
            <a href="<?php echo e(route('admin.images.index')); ?>" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Images
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

        <form action="<?php echo e(route('admin.images.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Image Upload -->
            <div class="form-group">
                <label for="image">
                    <i class="bi bi-image me-1"></i>Select Image
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*"
                    required>
                <small>
                    <i class="bi bi-info-circle me-1"></i>Upload an image (PNG, JPG, JPEG) up to 8MB
                </small>
            </div>

            <!-- Image Preview -->
            <div class="form-group" id="image-preview-container" style="display: none;">
                <label>
                    <i class="bi bi-eye me-1"></i>Preview
                </label>
                <div style="background: rgba(250, 235, 215, 0.05); border: 2px solid rgba(250, 235, 215, 0.15); border-radius: 10px; padding: 1rem; text-align: center;">
                    <img id="image-preview" src="" alt="Preview" style="max-width: 100%; max-height: 400px; border-radius: 8px; object-fit: contain;">
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">
                    <i class="bi bi-card-text me-1"></i>Description (Optional)
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="3"
                    placeholder="Add a description for this image..."><?php echo e(old('description')); ?></textarea>
                <small>
                    <i class="bi bi-info-circle me-1"></i>Helpful for identifying the image later
                </small>
            </div>

            <!-- Featured Checkbox -->
            <div class="form-group">
                <label class="facility-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input 
                        type="checkbox" 
                        name="is_featured" 
                        id="is_featured" 
                        value="1"
                        <?php echo e(old('is_featured') ? 'checked' : ''); ?>

                        style="width: 18px; height: 18px; cursor: pointer;">
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-star-fill" style="color: #FAEBD7;"></i>
                        <strong>Mark as Featured</strong>
                    </span>
                </label>
                <small style="display: block; margin-top: 0.5rem; margin-left: 1.75rem;">
                    <i class="bi bi-info-circle me-1"></i>Featured images appear on the home page carousel
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.images.index')); ?>" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-cloud-upload"></i> Upload Image
                </button>
            </div>
        </form>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const container = document.getElementById('image-preview-container');
                    preview.src = e.target.result;
                    container.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/images/create.blade.php ENDPATH**/ ?>