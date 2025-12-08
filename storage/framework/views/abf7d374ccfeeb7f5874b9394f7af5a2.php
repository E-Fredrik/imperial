<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('header', null, []); ?> 
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Images</h2>
   <?php $__env->endSlot(); ?>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <?php if(session('success')): ?>
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400"><?php echo e(session('success')); ?></div>
          <?php endif; ?>

          <div class="mb-4 flex items-center justify-between">
            <a href="<?php echo e(route('admin.images.create')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium">
              Upload Image
            </a>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
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

              <div class="border rounded overflow-hidden bg-white dark:bg-gray-700 shadow-sm">
                <div class="h-36 flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                  <?php if($url): ?>
                    <img src="<?php echo e($url); ?>" alt="" class="object-cover h-full w-full" />
                  <?php else: ?>
                    <div class="text-xs text-gray-500">No preview</div>
                  <?php endif; ?>
                </div>

                <div class="p-2 text-sm">
                  <div class="font-medium truncate"><?php echo e($img->description ?? '—'); ?></div>
                  <div class="text-xs text-gray-500">path: <span class="break-all"><?php echo e($img->image_path); ?></span></div>
                  <div class="flex items-center justify-between mt-2">
                    <form method="POST" action="<?php echo e(route('admin.images.toggleFeatured', $img)); ?>">
                      <?php echo csrf_field(); ?>
                      <button type="submit" class="inline-flex items-center px-2 py-1 text-xs rounded <?php echo e($img->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'); ?>">
                        <?php echo e($img->is_featured ? 'Featured' : 'Feature'); ?>

                      </button>
                    </form>

                    <form method="POST" action="<?php echo e(route('admin.images.destroy', $img)); ?>" onsubmit="return confirm('Delete image?');">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="inline-flex items-center px-2 py-1 text-xs rounded bg-rose-600 text-white">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div class="mt-4">
            <?php echo e($images->links()); ?>

          </div>

        </div>
      </div>
    </div>
  </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/images/index.blade.php ENDPATH**/ ?>