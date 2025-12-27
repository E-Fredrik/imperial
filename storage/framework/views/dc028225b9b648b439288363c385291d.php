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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Rooms')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <table class="table-auto w-full text-white">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-sm font-medium text-white">ID</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Room Number</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Type</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Status</th>
                                <th class="px-4 py-2 text-sm font-medium text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="border px-4 py-2 text-white"><?php echo e($room->id); ?></td>
                                    <td class="border px-4 py-2 text-white"><?php echo e($room->room_number); ?></td>
                                    <td class="border px-4 py-2 text-white"><?php echo e($room->type); ?></td>
                                    <td class="border px-4 py-2 text-white"><?php echo e($room->status); ?></td>
                                    <td class="border px-4 py-2">
                                        <a href="<?php echo e(route('admin.rooms.edit', $room)); ?>" class="inline-block px-2 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded text-sm me-2">Edit</a>
                                        <form action="<?php echo e(route('admin.rooms.destroy', $room)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="inline-block px-2 py-1 bg-red-600 hover:bg-red-500 text-white rounded text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                     
                     <div class="mt-4">
                         <a href="<?php echo e(route('admin.rooms.create')); ?>"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                             Add New Room
                         </a>
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
<?php endif; ?>
<?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/rooms/index.blade.php ENDPATH**/ ?>