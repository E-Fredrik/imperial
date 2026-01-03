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
   <?php $__env->slot('title', null, []); ?> Images Management <?php $__env->endSlot(); ?>
   <?php $__env->slot('header', null, []); ?> Images Management <?php $__env->endSlot(); ?>
   <?php $__env->slot('icon', null, []); ?> bi-image <?php $__env->endSlot(); ?>

  <?php if(session('success')): ?>
    <div class="alert-success">
      <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <div class="admin-card">
    <div class="card-header">
      <h3>All Images</h3>
      <a href="<?php echo e(route('admin.images.create')); ?>" class="btn-admin-primary">
        <i class="bi bi-upload"></i> Upload Image
      </a>
    </div>

    <div class="row g-4">
      <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $p = $img->image_path ?? '';
          $publicCandidate = public_path($p);
          if ($p !== '' && file_exists($publicCandidate)) {
              $url = asset($p);
          } elseif ($p) {
              $url = asset('storage/' . ltrim($p, '/'));
          } else {
              $url = null;
          }
        ?>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div style="background: #2a2a2a; border: 2px solid #333; border-radius: 12px; overflow: hidden; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#FAEBD7'" onmouseout="this.style.borderColor='#333'">
            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
              <?php if($url): ?>
                <img src="<?php echo e($url); ?>" alt="" style="object-fit: cover; height: 100%; width: 100%;" />
              <?php else: ?>
                <span style="color: #666; font-size: 0.875rem;">No preview</span>
              <?php endif; ?>
            </div>

            <div style="padding: 1rem;">
              <div style="font-weight: 600; color: #FAEBD7; margin-bottom: 0.5rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo e($img->description ?? '—'); ?></div>
              <div style="font-size: 0.75rem; color: #999; word-break: break-all; margin-bottom: 1rem;"><?php echo e($img->image_path); ?></div>
              
              <div class="d-flex gap-2 justify-content-between">
                <form method="POST" action="<?php echo e(route('admin.images.toggleFeatured', $img)); ?>" class="flex-grow-1">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="w-100 <?php echo e($img->is_featured ? 'btn-admin-primary' : 'btn-admin-secondary'); ?>" style="padding: 0.5rem; font-size: 0.875rem;">
                    <?php if($img->is_featured): ?>
                      <i class="bi bi-star-fill"></i> Featured
                    <?php else: ?>
                      <i class="bi bi-star"></i> Feature
                    <?php endif; ?>
                  </button>
                </form>

                <form method="POST" action="<?php echo e(route('admin.images.destroy', $img)); ?>" onsubmit="return confirm('Delete image?');">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn-admin-danger" style="padding: 0.5rem 0.8rem; font-size: 0.875rem;">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div style="margin-top: 2rem;">
      <?php echo e($images->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/images/index.blade.php ENDPATH**/ ?>