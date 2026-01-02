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
     <?php $__env->slot('title', null, []); ?> Add New Room <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Add New Room <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-door-closed <?php $__env->endSlot(); ?>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-door-closed me-2"></i>Create New Room</h3>
            <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Rooms
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

        <form action="<?php echo e(route('admin.rooms.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Room Number -->
            <div class="form-group">
                <label for="room_number">
                    <i class="bi bi-hash me-1"></i>Room Number
                </label>
                <input 
                    type="text" 
                    name="room_number" 
                    id="room_number" 
                    value="<?php echo e(old('room_number')); ?>"
                    required
                    placeholder="e.g., A, B, C, 101, 102">
            </div>

            <div class="row g-3">
                <!-- Price -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">
                            <i class="bi bi-cash-coin me-1"></i>Monthly Price (Rp)
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                value="<?php echo e(old('price')); ?>"
                                required
                                placeholder="1850000">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('price').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('price').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">
                            <i class="bi bi-collection me-1"></i>Room Type
                        </label>
                        <input 
                            type="text" 
                            name="type" 
                            id="type" 
                            value="<?php echo e(old('type')); ?>"
                            required
                            placeholder="e.g., Single, Double, Suite">
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <!-- Length -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="length">
                            <i class="bi bi-arrows-expand me-1"></i>Length (m)
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                step="0.01"
                                name="length" 
                                id="length" 
                                value="<?php echo e(old('length')); ?>"
                                required
                                placeholder="3">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('length').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('length').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Width -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="width">
                            <i class="bi bi-arrows-expand me-1"></i>Width (m)
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                step="0.01"
                                name="width" 
                                id="width" 
                                value="<?php echo e(old('width')); ?>"
                                required
                                placeholder="2">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('width').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('width').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floor -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="floor">
                            <i class="bi bi-building me-1"></i>Floor
                        </label>
                        <div class="number-input-wrapper">
                            <input 
                                type="number" 
                                name="floor" 
                                id="floor" 
                                value="<?php echo e(old('floor')); ?>"
                                required
                                placeholder="1">
                            <div class="number-controls">
                                <button type="button" onclick="document.getElementById('floor').stepUp()">▲</button>
                                <button type="button" onclick="document.getElementById('floor').stepDown()">▼</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">
                    <i class="bi bi-toggle-on me-1"></i>Status
                </label>
                <select name="status" id="status" required>
                    <option value="available" <?php echo e(old('status') == 'available' ? 'selected' : ''); ?>>Available</option>
                    <option value="booked" <?php echo e(old('status') == 'booked' ? 'selected' : ''); ?>>Booked</option>
                    <option value="unavailable" <?php echo e(old('status') == 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                </select>
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
                    placeholder="Describe the room features and amenities..."><?php echo e(old('description')); ?></textarea>
            </div>

            <!-- Images -->
            <div class="form-group">
                <label for="images">
                    <i class="bi bi-images me-1"></i>Room Images (Optional)
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

            <!-- Facilities -->
            <div class="form-group">
                <label>
                    <i class="bi bi-check2-square me-1"></i>Facilities
                </label>
                <div class="facilities-grid">
                    <label class="facility-label">
                        <input type="checkbox" name="facilities[]" value="Kamar Mandi Dalam" <?php echo e(is_array(old('facilities')) && in_array('Kamar Mandi Dalam', old('facilities')) ? 'checked' : ''); ?>>
                        <span>Kamar Mandi Dalam</span>
                    </label>
                    <label class="facility-label">
                        <input type="checkbox" name="facilities[]" value="Water Heater" <?php echo e(is_array(old('facilities')) && in_array('Water Heater', old('facilities')) ? 'checked' : ''); ?>>
                        <span>Water Heater</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Create Room
                </button>
            </div>
        </form>
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
<?php endif; ?><?php /**PATH D:\Github\imperial\resources\views/admin/rooms/create.blade.php ENDPATH**/ ?>