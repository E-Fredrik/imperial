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
        $imgUrl = file_exists($publicCandidate) ? asset($imgPath) : asset('storage/' . ltrim($imgPath, '/'));
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

    <div style="padding:1.2rem; position: relative; z-index: 1;">
        <h5 style="margin:0 0 .5rem 0; font-weight:700; font-size:1.3rem;">Room <?php echo e($room->room_number); ?></h5>
        <div style="font-size:.95rem; margin-bottom:.4rem; color:#666;"><?php echo e($room->type); ?> • <?php echo e($room->length); ?>x<?php echo e($room->width); ?>m • Floor <?php echo e($room->floor); ?></div>
        <div style="font-size:1.1rem; margin-bottom:.8rem; font-weight:600;">Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?>/month</div>

        <div style="display:flex; gap:.5rem; align-items:center;">
            <?php if($room->status === 'available'): ?>
                <span style="font-size:.9rem; color:#0a7a00; font-weight:600; background:#d4edda; padding:4px 12px; border-radius:12px;">Available</span>
            <?php elseif($room->status === 'booked'): ?>
                <span style="font-size:.9rem; color:#7a0000; font-weight:600; background:#f8d7da; padding:4px 12px; border-radius:12px;">Occupied</span>
            <?php else: ?>
                <span style="font-size:.9rem; color:#475569; font-weight:600; background:#e2e8f0; padding:4px 12px; border-radius:12px;"><?php echo e(ucfirst($room->status)); ?></span>
            <?php endif; ?>
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
</style><?php /**PATH D:\Github\imperial\resources\views/components/room-card.blade.php ENDPATH**/ ?>