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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Information Management')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <?php if(Route::has('admin.info.create')): ?>
                                <a href="<?php echo e(route('admin.info.create')); ?>"
                                   class="inline-block px-4 py-2 rounded shadow-md border border-indigo-700 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold"
                                   style="background-color: #4f46e5; color: #ffffff;">
                                    Create New Information
                                </a>
                            <?php endif; ?>
                        </div>

                        
                        <div class="text-sm text-gray-600">
                            
                        </div>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="text-left">
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">ID</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">Title</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">Content</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $information): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="odd:bg-white even:bg-gray-50">
                                        <td class="py-2 px-4 border-b text-sm text-gray-800"><?php echo e($information->id); ?></td>
                                        <td class="py-2 px-4 border-b text-sm text-gray-800"><?php echo e($information->title); ?></td>
                                        <td class="py-2 px-4 border-b text-sm text-gray-800 align-top">
                                            <div class="prose max-w-none text-sm text-gray-800 dark:text-black" style="max-height:6rem; overflow:auto;">
                                                <?php echo $information->content; ?>

                                            </div>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <div class="flex items-center gap-2">
                                                <!-- Edit button: force visible filled style -->
                                                <a href="<?php echo e(route('admin.info.edit', $information)); ?>"
                                                   class="inline-flex items-center px-3 py-1 rounded shadow-md text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                   style="background-color:#4f46e5; border:1px solid #4338ca; color:#ffffff;">
                                                    Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.info.destroy', $information)); ?>" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="inline-block px-3 py-1 rounded bg-rose-600 hover:bg-rose-700 text-white text-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-6 px-4 text-center text-gray-600">
                                            No information entries found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo e($info->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/info/index.blade.php ENDPATH**/ ?>