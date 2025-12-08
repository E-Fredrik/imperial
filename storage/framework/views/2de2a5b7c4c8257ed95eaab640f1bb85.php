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
            <?php echo e(__('Bookings')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <?php if(session('success')): ?>
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <a href="<?php echo e(route('admin.bookings.create')); ?>"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Create Booking
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-transparent">
                            <thead>
                                <tr class="text-left">
                                    <th class="py-2 px-4 border-b text-sm font-medium">ID</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">User</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Room</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Move-in</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Rent</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Proof</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Payments</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Status</th>
                                    <th class="py-2 px-4 border-b text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="odd:bg-white even:bg-gray-50 dark:even:bg-gray-700">
                                        <td class="py-2 px-4 border-b text-sm"><?php echo e($booking->id); ?></td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <?php echo e(optional($booking->user)->first_name ?? '-'); ?>

                                            <?php echo e(optional($booking->user)->last_name ?? ''); ?><br/>
                                            <span class="text-xs text-gray-500"><?php echo e(optional($booking->user)->email ?? ''); ?></span>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <?php echo e(optional($booking->room)->room_number ?? '-'); ?>

                                        </td>
                                        <td class="py-2 px-4 border-b text-sm"><?php echo e(optional($booking->move_in_date)->format('Y-m-d') ?? '-'); ?></td>
                                        <td class="py-2 px-4 border-b text-sm"><?php echo e($booking->monthly_rent); ?></td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <?php
                                                $p = $booking->payments->last();
                                                $proofPath = $p->proof ?? '';
                                                if ($proofPath !== '' && file_exists(public_path($proofPath))) {
                                                    $proofUrl = asset($proofPath);
                                                } elseif ($proofPath) {
                                                    $proofUrl = asset('storage/' . ltrim($proofPath, '/'));
                                                } else {
                                                    $proofUrl = null;
                                                }
                                            ?>
                                            <?php if($proofUrl): ?>
                                                <a href="<?php echo e($proofUrl); ?>" target="_blank" class="text-blue-600 hover:underline text-sm">View</a>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-500">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <?php $__currentLoopData = $booking->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="mb-1">
                                                    <span class="text-sm font-medium"><?php echo e($p->amount); ?></span>
                                                    <span class="text-xs text-gray-500"> — <?php echo e($p->status); ?></span>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs <?php echo e($booking->status === 'booked' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                                <?php echo e($booking->status); ?>

                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <div class="flex items-center gap-2">
                                                <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="inline-flex px-2 py-1 bg-blue-600 text-white rounded text-sm">View</a>

                                                <?php if($booking->status === 'pending'): ?>
                                                    <form action="<?php echo e(route('admin.bookings.decline', $booking)); ?>" method="POST" onsubmit="return confirm('Decline this booking and the latest payment?');">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="inline-flex px-2 py-1 bg-rose-600 text-white rounded text-sm">Decline</button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="py-6 px-4 text-center text-gray-600">No bookings found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo e($bookings->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>