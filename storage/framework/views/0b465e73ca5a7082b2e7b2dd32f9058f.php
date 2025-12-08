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
            <?php echo e(__('Payments')); ?>

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

                    

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Booking</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">User</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Room</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Month</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-transparent divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="odd:bg-white even:bg-gray-50 dark:even:bg-gray-800">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100"><?php echo e($payment->id); ?></td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="<?php echo e(route('admin.bookings.show', $payment->booking_id)); ?>" class="text-blue-600 hover:underline">
                                                #<?php echo e($payment->booking_id); ?>

                                            </a>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <?php echo e(optional($payment->booking->user)->first_name ?? '-'); ?>

                                            <?php echo e(optional($payment->booking->user)->last_name ?? ''); ?><br />
                                            <span class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(optional($payment->booking->user)->email ?? ''); ?></span>
                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <?php echo e(optional($payment->booking->room)->room_number ?? '-'); ?>

                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <?php echo e($payment->payment_for_month); ?>

                                        </td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <?php echo e(number_format($payment->amount)); ?>

                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs
                                                <?php if($payment->status === 'accepted'): ?> bg-green-100 text-green-800
                                                <?php elseif($payment->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                <?php elseif($payment->status === 'declined'): ?> bg-rose-100 text-rose-800
                                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                <?php echo e($payment->status); ?>

                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex items-center gap-2">
                                                <a href="<?php echo e(route('admin.bookings.show', $payment->booking_id)); ?>" class="inline-flex px-3 py-1 bg-blue-600 text-white rounded text-sm">View Booking</a>

                                                <form method="POST" action="<?php echo e(route('admin.payments.update', $payment)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="action" value="accept" />
                                                    <button type="submit" class="inline-flex px-3 py-1 bg-green-600 hover:bg-green-500 text-white rounded text-sm">Accept</button>
                                                </form>

                                                <form method="POST" action="<?php echo e(route('admin.payments.update', $payment)); ?>" onsubmit="return confirm('Decline this payment?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="action" value="decline" />
                                                    <button type="submit" class="inline-flex px-3 py-1 bg-rose-600 hover:bg-rose-500 text-white rounded text-sm">Decline</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-gray-600 dark:text-gray-400">No payments found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <?php echo e($payments->links()); ?>

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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>