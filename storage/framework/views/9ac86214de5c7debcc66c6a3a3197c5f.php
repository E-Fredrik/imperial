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
    
    // Use gray/white border for all rooms
    $borderColor = '#d1d5db';
?>

<div class="room-card" data-room-id="<?php echo e($room->id); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="background: linear-gradient(135deg, #FAEBD7 0%, #f5f5f5 100%); color:#000; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.3); cursor:pointer; border: 2px solid <?php echo e($borderColor); ?>; position: relative; will-change: transform;">
    <div style="height:200px; overflow:hidden; position: relative;">
        <img 
            src="<?php echo e($imgUrl); ?>" 
            alt="<?php echo e($room->room_number); ?>"
            style="width:100%; height:100%; object-fit:cover; transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);"
        >
    </div>
    
    <div style="padding:1.5rem;">
        <h5 style="font-size:1.5rem; font-weight:700; margin-bottom:0.75rem; transition: color 0.3s ease;">
            <?php echo e($room->room_number); ?>

        </h5>
        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
            <span style="font-size:0.95rem; color:#666; transition: color 0.3s ease;">
                <i class="bi bi-rulers" style="margin-right:0.25rem;"></i>
                <?php echo e($room->length); ?>m × <?php echo e($room->width); ?>m
            </span>
            <span class="room-status-badge" style="background:#333; color:#fff; padding:0.25rem 0.75rem; border-radius:12px; font-size:0.85rem; font-weight:600; transition: all 0.3s ease;">
                <?php echo e(ucfirst($room->status)); ?>

            </span>
        </div>
        
        <p style="font-size:1.25rem; font-weight:700; color:#2c3e50; margin:0; transition: color 0.3s ease;">
            Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?><span style="font-size:0.9rem; font-weight:400;">/month</span>
        </p>
    </div>
</div>

<style>
.room-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    transform: translateY(0) scale(1);
}

.room-card:hover {
    transform: translateY(-15px) scale(1.05) !important;
    box-shadow: 0 30px 80px rgba(250, 235, 215, 0.3), 0 0 0 2px rgba(250, 235, 215, 0.6) !important;
    background: linear-gradient(135deg, #fff 0%, #FAEBD7 100%) !important;
    border-color: rgba(250, 235, 215, 0.8) !important;
    z-index: 10 !important;
}

.room-card:hover img {
    transform: scale(1.1) !important;
}

.room-card:hover h5 {
    color: #1a1a1a !important;
}

.room-card:hover p {
    color: #333 !important;
}

.room-card:hover .room-status-badge {
    background: #1a1a1a !important;
    color: #FAEBD7 !important;
    border: 1px solid rgba(250, 235, 215, 0.4);
    transform: scale(1.05);
}

.room-card:hover span:not(.room-status-badge) {
    color: #333 !important;
}

/* Ensure smooth transitions */
.room-card * {
    transition: all 0.3s ease;
}
</style><?php /**PATH D:\Github\imperial\resources\views/components/room-card.blade.php ENDPATH**/ ?>