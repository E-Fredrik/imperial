<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['room']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['room']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="roomModal-<?php echo e($room->id); ?>" class="room-modal" style="display: none; opacity: 0; visibility: hidden;">
    <div class="modal-backdrop" onclick="closeRoomModal(<?php echo e($room->id); ?>)"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeRoomModal(<?php echo e($room->id); ?>)">
            <i class="bi bi-arrow-left"></i> Back
        </button>
        
        <div class="modal-body">
            <div class="modal-images">
                <div id="roomCarousel-<?php echo e($room->id); ?>" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        <?php if($room->images && $room->images->count() > 0): ?>
                            <?php $__currentLoopData = $room->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $imagePath = $image->image_path;
                                    $publicPath = public_path($imagePath);
                                    
                                    if (file_exists($publicPath)) {
                                        $imageUrl = asset($imagePath);
                                    } else {
                                        $imageUrl = asset('storage/' . ltrim($imagePath, '/'));
                                    }
                                ?>
                                <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e($imageUrl); ?>" alt="Room <?php echo e($room->room_number); ?>" style="width: 100%; height: 400px; object-fit: cover;">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="carousel-item active">
                                <div class="no-image-modal" style="width: 100%; height: 400px; display: flex; align-items: center; justify-content: center; background: #2a2a2a; color: #999;">
                                    <div style="text-align: center;">
                                        <i class="bi bi-image" style="font-size: 4rem;"></i>
                                        <p style="margin-top: 1rem;">No Image Available</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($room->images && $room->images->count() > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel-<?php echo e($room->id); ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel-<?php echo e($room->id); ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    <?php endif; ?>
                </div>
                
                <div class="room-3d-view">
                    <h4 style="color:#FAEBD7; margin-bottom:1rem;">3D Room View</h4>

                    <?php
                        // look for a 360 image attached to the room
                        $image360 = $room->images->firstWhere('is_360', true);
                    ?>

                    <?php if($image360): ?>
                        <div class="view-placeholder" style="height:400px;">
                            <iframe
                                src="<?php echo e($image360->image_path); ?>"
                                title="360 Room View - <?php echo e($room->room_number); ?>"
                                style="width:100%; height:100%; border:0; border-radius:15px; background:#000;"
                                allow="vr; fullscreen; accelerometer; gyroscope; autoplay"
                                loading="lazy"
                            ></iframe>
                        </div>
                    <?php else: ?>
                        <div class="view-placeholder">
                            <i class="bi bi-box" style="font-size:3rem; color:#666;"></i>
                            <p style="color:#999; margin-top:1rem;">Interactive 3D view coming soon</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="modal-info">
                <div class="info-header">
                    <div>
                        <h2>Room <?php echo e($room->room_number); ?></h2>
                        <p><?php echo e($room->type); ?> • <?php echo e($room->length); ?>x<?php echo e($room->width); ?>m • Floor <?php echo e($room->floor); ?></p>
                    </div>
                </div>
                
                <div class="price-section">
                    <div class="price-badge">
                        <span class="monthly-label">Monthly Rate</span>
                        <span class="price">Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?></span>
                    </div>
                    <span class="availability-tag <?php echo e($room->status); ?>">
                        <?php echo e(ucfirst($room->status)); ?>

                    </span>
                </div>
                
                <div class="facilities-section">
                    <h3>Facilities</h3>
                    <div class="facilities-grid">
                        <?php if($room->rooms_facilities && $room->rooms_facilities->count() > 0): ?>
                            <?php $__currentLoopData = $room->rooms_facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomFacility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($roomFacility->room_facility): ?>
                                    <div class="facility-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span><?php echo e($roomFacility->room_facility->name); ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p style="color:#999;">No facilities listed</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if($room->description): ?>
                    <div class="description-section">
                        <h3>Description</h3>
                        <p style="color:#ccc;"><?php echo e($room->description); ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="booking-section">
                    <h3>Book This Room</h3>
                    <form action="<?php echo e(route('bookings.create')); ?>" method="GET">
                        <input type="hidden" name="room_id" value="<?php echo e($room->id); ?>">
                        
                        <div class="date-input-group">
                            <label for="check_in_<?php echo e($room->id); ?>">Check-in Date</label>
                            <input type="date" 
                                   id="check_in_<?php echo e($room->id); ?>" 
                                   name="check_in" 
                                   class="form-control" 
                                   style="background:#2a2a2a; border:1px solid #666; color:#FAEBD7; padding:0.8rem; border-radius:8px;"
                                   min="<?php echo e(date('Y-m-d')); ?>"
                                   required>
                        </div>
                        
                        <div class="action-buttons">
                            <button type="button" class="btn-cancel" onclick="closeRoomModal(<?php echo e($room->id); ?>)">Cancel</button>
                            <?php if($room->status === 'available'): ?>
                                <?php if(auth()->guard()->check()): ?>
                                    <button type="submit" class="btn-book">Book Now</button>
                                <?php else: ?>
                                    <button type="button" class="btn-book" onclick="alert('Please login to book a room'); window.location.href='/login';">Book Now</button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button type="button" class="btn-book" disabled>Not Available</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('4947392b-c523-4c41-8e52-b20913f9a7fe')): $__env->markAsRenderedOnce('4947392b-c523-4c41-8e52-b20913f9a7fe'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openRoomModal(roomId) {
    console.log('Opening modal for room:', roomId);
    const modal = document.getElementById('roomModal-' + roomId);
    
    if (!modal) {
        console.error('Modal not found:', 'roomModal-' + roomId);
        return;
    }
    
    console.log('Modal found:', modal);
    
    // Show the modal
    modal.style.display = 'flex';
    modal.style.opacity = '0';
    modal.style.visibility = 'visible';
    
    // Trigger reflow
    modal.offsetHeight;
    
    // Add active class with animation
    setTimeout(() => {
        modal.classList.add('active');
        modal.style.opacity = '1';
    }, 10);
    
    document.body.style.overflow = 'hidden';
}

function closeRoomModal(roomId) {
    console.log('Closing modal for room:', roomId);
    const modal = document.getElementById('roomModal-' + roomId);
    
    if (!modal) {
        console.error('Modal not found:', 'roomModal-' + roomId);
        return;
    }
    
    modal.classList.remove('active');
    modal.style.opacity = '0';
    
    setTimeout(() => {
        modal.style.display = 'none';
        modal.style.visibility = 'hidden';
    }, 300);
    
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const activeModal = document.querySelector('.room-modal.active');
        if (activeModal) {
            const modalId = activeModal.id.replace('roomModal-', '');
            closeRoomModal(modalId);
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/components/room-modal.blade.php ENDPATH**/ ?>