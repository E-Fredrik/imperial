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
            <?php echo e(__('Booking Details')); ?> — #<?php echo e($booking->id); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <?php if(session('success')): ?>
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->has('move_out_date')): ?>
                        <div class="mb-4 text-sm text-rose-600">
                            <?php echo e($errors->first('move_out_date')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="mb-4 flex items-center justify-between">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-500">Booking ID</div>
                            <div class="text-lg font-medium"><?php echo e($booking->id); ?></div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium hover:opacity-90">
                                Back to Bookings
                            </a>

                            <?php if($booking->status === 'pending'): ?>
                                <form action="<?php echo e(route('admin.bookings.decline', $booking)); ?>" method="POST" onsubmit="return confirm('Decline this booking and the latest payment?');">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded text-sm">Decline Booking</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="col-span-2">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">User</h3>
                            <div class="mt-2 text-sm">
                                <div class="font-medium"><?php echo e(optional($booking->user)->first_name ?? '-'); ?> <?php echo e(optional($booking->user)->last_name ?? ''); ?></div>
                                <div class="text-xs text-gray-500 dark:text-white"><?php echo e(optional($booking->user)->email ?? ''); ?></div>
                                <?php if(optional($booking->user)->phone_number): ?>
                                    <div class="text-xs text-gray-500"><?php echo e($booking->user->phone_number); ?></div>
                                <?php endif; ?>
                            </div>

                            <hr class="my-4">

                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Room</h3>
                            <div class="mt-2 text-sm">
                                <div class="font-medium"><?php echo e(optional($booking->room)->room_number ?? '-'); ?> — <?php echo e(optional($booking->room)->type ?? ''); ?></div>
                                <div class="text-xs text-gray-500 dark:text-white">Price: <?php echo e(number_format(optional($booking->room)->price ?? $booking->monthly_rent)); ?></div>
                                <div class="text-xs text-gray-500 dark:text-white">Status: <?php echo e(optional($booking->room)->status ?? '-'); ?></div>
                            </div>

                            <hr class="my-4">

                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Booking Info</h3>
                            <div class="mt-2 text-sm space-y-1">
                                <div>Move-in: <span class="font-medium"><?php echo e(optional($booking->move_in_date)->format('Y-m-d') ?? '-'); ?></span></div>
                                <div>
                                    <span class="text-sm">Move-out:</span>
                                    <form method="POST" action="<?php echo e(route('admin.bookings.update', $booking)); ?>" class="inline-block ml-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input
                                            id="move_out_date"
                                            name="move_out_date"
                                            type="date"
                                            value="<?php echo e(old('move_out_date', optional($booking->move_out_date)->format('Y-m-d'))); ?>"
                                            class="rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-1"
                                        />
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white rounded text-sm ms-2">Save</button>
                                    </form>
                                </div>
                                <div>Monthly Rent: <span class="font-medium"><?php echo e(number_format($booking->monthly_rent)); ?></span></div>
                                <div>Status: 
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs <?php echo e($booking->status === 'booked' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                        <?php echo e($booking->status); ?>

                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Summary</h3>
                            <div class="mt-3 bg-gray-50 dark:bg-gray-700 p-4 rounded">
                                <div class="text-sm text-gray-500 dark:text-white">Total payments</div>
                                <div class="text-lg font-semibold mt-1"><?php echo e(number_format($booking->payments->sum('amount'))); ?></div>

                                <div class="mt-4">
                                    <div class="text-sm text-gray-500 dark:text-white">Payments count</div>
                                    <div class="font-medium"><?php echo e($booking->payments->count()); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 mb-3">Payments</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Month</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Proof</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-transparent divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $booking->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="odd:bg-white even:bg-gray-50 dark:even:bg-gray-800">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100"><?php echo e($payment->id); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100"><?php echo e($payment->payment_for_month); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100"><?php echo e(number_format($payment->amount)); ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            <?php
                                                $path = $payment->proof ?? '';
                                                if ($path !== '' && file_exists(public_path($path))) {
                                                    $url = asset($path);
                                                } elseif ($path) {
                                                    $url = asset('storage/' . ltrim($path, '/'));
                                                } else {
                                                    $url = null;
                                                }
                                            ?>
                                            <?php if($url): ?>
                                                <a href="<?php echo e($url); ?>" target="_blank" class="text-blue-600 hover:underline text-sm">View</a>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-500">—</span>
                                            <?php endif; ?>
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
                                                <?php if($payment->status !== 'accepted'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.payments.update', $payment)); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="action" value="accept" />
                                                        <button type="submit" class="inline-flex px-3 py-1 bg-green-600 hover:bg-green-500 text-white rounded text-sm">Accept</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if($payment->status !== 'declined'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.payments.update', $payment)); ?>" onsubmit="return confirm('Decline this payment?');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="action" value="decline" />
                                                        <button type="submit" class="inline-flex px-3 py-1 bg-rose-600 hover:bg-rose-500 text-white rounded text-sm">Decline</button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-600 dark:text-gray-400">No payments recorded.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm rounded-md">
                            Back
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
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>