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
     <?php $__env->slot('title', null, []); ?> Add Information <?php $__env->endSlot(); ?>
     <?php $__env->slot('header', null, []); ?> Add Information <?php $__env->endSlot(); ?>
     <?php $__env->slot('icon', null, []); ?> bi-info-circle <?php $__env->endSlot(); ?>

    <div class="admin-card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h3><i class="bi bi-info-circle me-2"></i>Create New Information</h3>
            <a href="<?php echo e(route('admin.info.index')); ?>" class="btn-admin-secondary">
                <i class="bi bi-arrow-left"></i> Back to Information
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

        <?php if(session('success')): ?>
            <div class="alert-success">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('info')): ?>
            <div class="alert-success">
                <i class="bi bi-info-circle"></i> <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.info.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Title -->
            <div class="form-group">
                <label for="title">
                    <i class="bi bi-tag me-1"></i>Title
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="<?php echo e(old('title')); ?>"
                    required
                    placeholder="e.g., Terms & Conditions, House Rules">
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content">
                    <i class="bi bi-card-text me-1"></i>Content
                </label>
                <?php if (isset($component)) { $__componentOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.trix-input','data' => ['id' => 'content','name' => 'content','value' => old('content'),'autocomplete' => 'off']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('trix-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'content','name' => 'content','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('content')),'autocomplete' => 'off']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1)): ?>
<?php $attributes = $__attributesOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1; ?>
<?php unset($__attributesOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1)): ?>
<?php $component = $__componentOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1; ?>
<?php unset($__componentOriginalfa45bdf63d5f546beb2b52c7dd7ad0c1); ?>
<?php endif; ?>
                <small>
                    <i class="bi bi-info-circle me-1"></i>Use the editor toolbar to format your content
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="<?php echo e(route('admin.info.index')); ?>" class="btn-admin-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-circle"></i> Create Information
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
<?php endif; ?>
<?php /**PATH D:\Github\imperial\resources\views/admin/info/create.blade.php ENDPATH**/ ?>