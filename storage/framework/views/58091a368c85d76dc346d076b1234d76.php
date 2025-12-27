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

<?php
    $imgPath = optional($room->images->first())->image_path ?? null;
    
    if ($imgPath) {
        $publicCandidate = public_path($imgPath);
        if (file_exists($publicCandidate)) {
            $imgUrl = asset($imgPath);
        } else {
            $imgUrl = asset('storage/' . ltrim($imgPath, '/'));
        }
    } else {
        $imgUrl = asset('images/rooms/default.jpg');
    }
    
    // Determine border and overlay color based on status
    $borderColor = match($room->status) {
        'available' => '#4ade80',
        'booked' => '#ef4444',
        'unavailable' => '#64748b',
        default => '#666'
    };
    
    $overlayColor = match($room->status) {
        'available' => 'transparent',
        'booked' => 'rgba(239, 68, 68, 0.15)',
        'unavailable' => 'rgba(100, 116, 139, 0.15)',
        default => 'transparent'
    };
?>

<div class="room-card" data-room-id="<?php echo e($room->id); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="background:#FAEBD7; color:#000; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.25); cursor:pointer; transition: all 0.3s ease; border: 3px solid <?php echo e($borderColor); ?>; position: relative;">
    
    <?php if($room->status !== 'available'): ?>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: <?php echo e($overlayColor); ?>; z-index: 1; pointer-events: none;"></div>
    <?php endif; ?>
    
    <div style="height:200px; overflow:hidden; position: relative;">
        <img src="<?php echo e($imgUrl); ?>" alt="Room <?php echo e($room->room_number); ?>" style="width:100%; height:100%; object-fit:cover; display:block; transition: transform 0.3s ease;">
        
        <?php if($room->status === 'booked'): ?>
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(239, 68, 68, 0.95); color: white; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 700; font-size: 1.2rem; z-index: 2;">
                OCCUPIED
            </div>
        <?php elseif($room->status === 'unavailable'): ?>
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(100, 116, 139, 0.95); color: white; padding: 0.8rem 2rem; border-radius: 8px; font-weight: 700; font-size: 1.2rem; z-index: 2;">
                UNAVAILABLE
            </div>
        <?php endif; ?>
    </div>
    
    <div style="padding:1.5rem;">
        <h3 style="font-size:1.5rem; font-weight:700; margin-bottom:0.5rem; color:#000;">Room <?php echo e($room->room_number); ?></h3>
        <p style="color:#555; margin-bottom:1rem; font-size:0.9rem;"><?php echo e($room->type); ?> • Floor <?php echo e($room->floor); ?></p>
        <p style="color:#000; font-size:1.25rem; font-weight:700; margin-bottom:1rem;">Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?><span style="font-size:0.9rem; font-weight:400;">/month</span></p>
        
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="padding:0.4rem 1rem; background:#333; color:#fff; border-radius:20px; font-size:0.85rem; font-weight:600;">
                <?php echo e(ucfirst($room->status)); ?>

            </span>
            <span style="color:#555; font-size:0.9rem;"><?php echo e($room->length); ?>x<?php echo e($room->width); ?>m</span>
        </div>
    </div>
</div>

<style>
.room-card:hover {
    transform: translateY(-8px) scale(1.03);
    background-color: #2a2a2a !important;
    color: #FAEBD7 !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
}

.room-card:hover img {
    transform: scale(1.1);
}

.room-card:hover h5,
.room-card:hover div {
    color: #FAEBD7 !important;
}
</style><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/components/room-card.blade.php ENDPATH**/ ?>