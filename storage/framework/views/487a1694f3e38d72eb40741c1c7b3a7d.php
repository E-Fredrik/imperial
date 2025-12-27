<?php $__env->startSection('title', 'Rooms'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/room.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="rooms-section">
    <div class="container-fluid" style="max-width: 1600px;">
        <h1 class="page-title text-center">Building Floor Plan</h1>
        <p class="page-subtitle text-center">Interactive building layout - Click any room for details</p>
        
        <div class="legend" style="display: flex; gap: 2rem; margin-bottom: 3rem; justify-content: center;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #00ff00; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #999;">Available</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #ff0000; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #999;">Booked</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 25px; height: 25px; background: #808080; border-radius: 4px; border: 2px solid #fff;"></div>
                <span style="color: #999;">Unavailable</span>
            </div>
        </div>

        <?php
            $roomsByFloor = $rooms->groupBy('floor')->sortKeys();
        ?>

        <?php $__currentLoopData = $roomsByFloor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor => $floorRooms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="floor-plan-container" style="margin-bottom: 4rem;">
                <div class="floor-title" style="text-align: center; margin-bottom: 2rem;">
                    <h2 style="color: #FAEBD7; font-size: 2.5rem; font-weight: 700;">
                        <i class="bi bi-building"></i> <?php echo e($floor); ?>F
                    </h2>
                </div>
                
                <div class="floor-map" style="background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%); border: 4px solid #fff; border-radius: 20px; padding: 3rem; position: relative; min-height: 600px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);">
                    
                    <?php if($floor == 1): ?>
                        
                        <div style="position: absolute; top: 20px; left: 20px; background: #c0c0c0; padding: 1rem 1.5rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center; font-size: 0.9rem;">TANGGA</div>
                        </div>
                        
                        <div style="position: absolute; top: 20px; right: 20px; background: #333; padding: 0.8rem 1.2rem; border-radius: 8px; border: 2px solid #fff;">
                            <div style="color: #fff; font-weight: 600; font-size: 0.8rem; writing-mode: vertical-rl; text-orientation: mixed;">MESIN CUCI</div>
                        </div>
                        
                        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: #c0c0c0; padding: 0.8rem 2rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center;">PINTU MASUK</div>
                        </div>
                        
                        <div style="position: absolute; left: 60px; top: 140px; display: flex; flex-direction: column; gap: 20px;">
                            <?php $__currentLoopData = $floorRooms->whereIn('room_number', ['A', 'B', 'C'])->sortBy('room_number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $bgColor = match($room->status) {
                                        'available' => '#00ff00',
                                        'booked' => '#ff0000',
                                        default => '#808080'
                                    };
                                ?>
                                <div class="room-plan-box" data-room-id="<?php echo e($room->id); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="width: 140px; height: 110px; background: <?php echo e($bgColor); ?>; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.5);"><?php echo e($room->room_number); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                        <div style="position: absolute; right: 60px; top: 140px; display: flex; flex-direction: column; gap: 30px;">
                            <?php $__currentLoopData = $floorRooms->whereNotIn('room_number', ['A', 'B', 'C'])->sortBy('room_number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $bgColor = match($room->status) {
                                        'available' => '#00ff00',
                                        'booked' => '#ff0000',
                                        default => '#808080'
                                    };
                                ?>
                                <div class="room-plan-box" data-room-id="<?php echo e($room->id); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="width: 140px; height: 110px; background: <?php echo e($bgColor); ?>; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.5);"><?php echo e($room->room_number); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        
                        <div style="position: absolute; top: 20px; left: 20px; background: #c0c0c0; padding: 1rem 1.5rem; border-radius: 10px; border: 3px solid #fff;">
                            <div style="color: #000; font-weight: 700; text-align: center; font-size: 0.9rem;">TANGGA</div>
                        </div>
                        
                        <div style="position: absolute; right: 60px; top: 140px; display: flex; flex-direction: column; gap: 30px;">
                            <?php $__currentLoopData = $floorRooms->sortBy('room_number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $bgColor = match($room->status) {
                                        'available' => '#00ff00',
                                        'booked' => '#ff0000',
                                        default => '#808080'
                                    };
                                ?>
                                <div class="room-plan-box" data-room-id="<?php echo e($room->id); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="width: 140px; height: 110px; background: <?php echo e($bgColor); ?>; border: 4px solid #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(250, 235, 215, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.5)';">
                                    <div style="text-align: center;">
                                        <div style="font-size: 2.5rem; font-weight: 900; color: #000; text-shadow: 2px 2px 4px rgba(255,255,255,0.5);"><?php echo e($room->room_number); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 8rem; font-weight: 900; color: rgba(250, 235, 215, 0.08); pointer-events: none; z-index: 0;"><?php echo e($floor); ?>F</div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <div style="margin-top: 3rem; text-align: center; padding-bottom: 3rem;">
            <p style="color: #999; font-size: 1rem;">
                <i class="bi bi-info-circle"></i> Click on any room to view detailed information and book
            </p>
        </div>
    </div>
</section>


<?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if (isset($component)) { $__componentOriginalfbd3f2d6564a8096269114a76d561e48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfbd3f2d6564a8096269114a76d561e48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.room-modal','data' => ['room' => $room]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('room-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['room' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($room)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfbd3f2d6564a8096269114a76d561e48)): ?>
<?php $attributes = $__attributesOriginalfbd3f2d6564a8096269114a76d561e48; ?>
<?php unset($__attributesOriginalfbd3f2d6564a8096269114a76d561e48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfbd3f2d6564a8096269114a76d561e48)): ?>
<?php $component = $__componentOriginalfbd3f2d6564a8096269114a76d561e48; ?>
<?php unset($__componentOriginalfbd3f2d6564a8096269114a76d561e48); ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/room.blade.php ENDPATH**/ ?>