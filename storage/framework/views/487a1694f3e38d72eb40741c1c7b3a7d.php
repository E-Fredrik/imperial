<?php $__env->startSection('title', 'Rooms'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/room.css')); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="rooms-section">
    <div class="container-fluid" style="max-width: 1600px;">
        <h1 class="page-title text-center">Building Floor Plan</h1>
        <p class="page-subtitle text-center">Interactive building layout - Click any room for details and booking</p>
        
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color available"></div>
                <span>Available</span>
            </div>
            <div class="legend-item">
                <div class="legend-color booked"></div>
                <span>Booked</span>
            </div>
            <div class="legend-item">
                <div class="legend-color unavailable"></div>
                <span>Unavailable</span>
            </div>
        </div>

        <?php
            $floor1Rooms = $rooms->where('floor', 1);
            $floor2Rooms = $rooms->where('floor', 2);
        ?>

        
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> First Floor (1F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 800 900" class="floor-svg" style="background: #000;">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="780" height="880" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    
                    
                    <!-- Top Left - Bathroom with toilet icon -->
                    <rect x="10" y="10" width="100" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="60" cy="50" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="60" y="95" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">WC</text>
                    
                    <!-- Room A (Large) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'A'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="10" y="140" width="100" height="160" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="60" y="225" fill="#000" font-size="48" font-weight="900" text-anchor="middle" class="room-label">A</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Kitchen with sink -->
                    <rect x="10" y="310" width="100" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="30" y="345" width="60" height="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="85" cy="362" r="12" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="60" y="410" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">KITCHEN</text>
                    
                    <!-- Small Bathroom -->
                    <rect x="10" y="450" width="50" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="35" cy="495" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room C (Large Bottom) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'C'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="10" y="550" width="100" height="250" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="60" y="685" fill="#000" font-size="48" font-weight="900" text-anchor="middle" class="room-label">C</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bottom Left Bathroom -->
                    <rect x="10" y="810" width="100" height="80" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="60" cy="850" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    
                    <!-- Stairs at top with diagonal lines -->
                    <g>
                        <rect x="120" y="10" width="130" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                        <line x1="130" y1="20" x2="240" y2="130" stroke="#fff" stroke-width="2"/>
                        <line x1="135" y1="20" x2="245" y2="130" stroke="#fff" stroke-width="1"/>
                        <line x1="125" y1="25" x2="305" y2="155" stroke="#fff" stroke-width="1"/>
                        <line x1="120" y1="30" x2="300" y2="160" stroke="#fff" stroke-width="1"/>
                        <line x1="115" y1="35" x2="225" y2="145" stroke="#fff" stroke-width="1"/>
                        <line x1="110" y1="40" x2="220" y2="150" stroke="#fff" stroke-width="1"/>
                        <line x1="105" y1="45" x2="215" y2="155" stroke="#fff" stroke-width="1"/>
                        <text x="185" y="80" fill="#fff" font-size="14" font-weight="bold" text-anchor="middle" transform="rotate(-45 185 80)">STAIRS</text>
                    </g>
                    
                    <!-- Central Corridor -->
                    <rect x="120" y="150" width="130" height="650" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    <!-- Seating/Furniture in corridor -->
                    <rect x="145" y="300" width="35" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="195" y="300" width="35" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Table/Furniture -->
                    <ellipse cx="185" cy="400" rx="30" ry="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="185" cy="500" rx="30" ry="40" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room B (extends next to corridor) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'B'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="120" y="300" width="50" height="240" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="145" y="430" fill="#000" font-size="36" font-weight="900" text-anchor="middle" class="room-label" transform="rotate(-90 145 430)">B</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bathroom (mid-corridor) -->
                    <rect x="120" y="550" width="130" height="80" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="185" cy="590" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="185" y="615" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">WC</text>
                    
                    <!-- Kitchen (mid-corridor) -->
                    <rect x="120" y="640" width="130" height="80" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="145" y="660" width="70" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="185" y="710" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">KITCHEN</text>
                    
                    <!-- Bathroom (bottom corridor) -->
                    <rect x="120" y="730" width="130" height="70" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="185" cy="765" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Exit door at bottom of corridor -->
                    <rect x="120" y="810" width="130" height="80" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="155" y="830" width="60" height="40" fill="none" stroke="#fff" stroke-width="3"/>
                    <text x="185" y="855" fill="#fff" font-size="12" font-weight="bold" text-anchor="middle">EXIT</text>
                    
                    
                    
                    <!-- Top right bathroom -->
                    <rect x="260" y="10" width="190" height="60" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="355" cy="40" r="12" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="405" y="45" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">WC</text>
                    
                    <!-- Room D -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'D'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="260" y="80" width="190" height="120" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="355" y="150" fill="#000" font-size="48" font-weight="900" text-anchor="middle" class="room-label">D</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room E (next to D) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'E'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="260" y="210" width="190" height="90" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="355" y="265" fill="#000" font-size="48" font-weight="900" text-anchor="middle" class="room-label">E</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Small bathroom between rooms -->
                    <rect x="460" y="10" width="80" height="190" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="500" cy="105" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room F -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'F'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="260" y="310" width="190" height="130" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="355" y="385" fill="#000" font-size="48" font-weight="900" text-anchor="middle" class="room-label">F</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Small bathroom -->
                    <rect x="460" y="210" width="80" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="500" cy="255" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room G (Large) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'G'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="260" y="450" width="280" height="340" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="400" y="635" fill="#000" font-size="48" font-weight="900" text-anchor="middle" class="room-label">G</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bathroom (right of G) -->
                    <rect x="460" y="310" width="80" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="500" cy="375" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    
                    <!-- Top bathroom -->
                    <rect x="550" y="10" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="595" cy="57" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Small bedroom (top right) -->
                    <rect x="550" y="115" width="90" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="560" y="130" width="70" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="595" y="165" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">BED</text>
                    
                    <!-- Another room -->
                    <rect x="550" y="215" width="90" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="560" y="235" width="70" height="90" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Small room/storage -->
                    <rect x="550" y="355" width="90" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    <!-- Tall room section -->
                    <rect x="650" y="10" width="90" height="180" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="660" y="30" width="70" height="140" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Medium bathroom -->
                    <rect x="650" y="200" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="695" cy="247" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Another room -->
                    <rect x="650" y="305" width="90" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="660" y="320" width="70" height="100" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bottom sections -->
                    <rect x="550" y="455" width="190" height="170" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="570" y="480" width="70" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="660" y="480" width="60" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bottom bathroom -->
                    <rect x="550" y="635" width="190" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="645" cy="680" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bottom large room -->
                    <rect x="550" y="735" width="190" height="155" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="570" y="755" width="150" height="110" fill="none" stroke="#fff" stroke-width="2"/>
                </svg>
            </div>
        </div>

        
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> Second Floor (2F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 1000 300" class="floor-svg" style="background: #000;">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="980" height="280" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    
                    
                    <!-- Large open space (left) -->
                    <rect x="10" y="10" width="220" height="150" fill="#000" stroke="#fff" stroke-width="3"/>
                    <text x="120" y="90" fill="#fff" font-size="14" text-anchor="middle" font-weight="bold">OPEN AREA</text>
                    
                    <!-- Stairs (2F) -->
                    <g>
                        <rect x="240" y="10" width="80" height="150" fill="#000" stroke="#fff" stroke-width="3"/>
                        <line x1="250" y1="20" x2="310" y2="150" stroke="#fff" stroke-width="2"/>
                        <line x1="255" y1="20" x2="315" y2="150" stroke="#fff" stroke-width="1"/>
                        <line x1="245" y1="25" x2="305" y2="155" stroke="#fff" stroke-width="1"/>
                        <line x1="240" y1="30" x2="300" y2="160" stroke="#fff" stroke-width="1"/>
                        <text x="280" y="90" fill="#fff" font-size="12" font-weight="bold" text-anchor="middle" transform="rotate(-60 280 90)">STAIRS</text>
                    </g>
                    
                    <!-- Bottom left corridor -->
                    <rect x="10" y="170" width="310" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    
                    
                    <!-- Row of rooms (top) -->
                    <!-- Small bathroom 1 -->
                    <rect x="330" y="10" width="90" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="375" cy="75" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="375" y="110" fill="#fff" font-size="9" text-anchor="middle" font-weight="bold">WC</text>
                    
                    <!-- Room (small bedroom 1) -->
                    <rect x="430" y="10" width="110" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="445" y="30" width="80" height="85" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="485" y="80" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">BED</text>
                    
                    <!-- Small bathroom 2 -->
                    <rect x="550" y="10" width="90" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="595" cy="75" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room (small bedroom 2) -->
                    <rect x="650" y="10" width="110" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="665" y="30" width="80" height="85" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Small bathroom 3 -->
                    <rect x="770" y="10" width="90" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="815" cy="75" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room (small bedroom 3) -->
                    <rect x="870" y="10" width="120" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="885" y="30" width="90" height="85" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    
                    <!-- Corridor section -->
                    <rect x="330" y="150" width="140" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="400" cy="220" r="25" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="400" y="228" fill="#fff" font-size="10" text-anchor="middle" font-weight="bold">TABLE</text>
                    
                    <!-- Room with dining -->
                    <rect x="480" y="150" width="140" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="500" y="170" width="100" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="510" y="235" width="35" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="565" y="235" width="35" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room with dining 2 -->
                    <rect x="630" y="150" width="140" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="650" y="170" width="100" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="660" y="235" width="35" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room with furniture -->
                    <rect x="780" y="150" width="130" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="800" y="170" width="90" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="845" cy="255" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room with furniture 2 -->
                    <rect x="920" y="150" width="70" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="930" y="170" width="50" height="100" fill="none" stroke="#fff" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <div class="floor-info-text">
            <p><i class="bi bi-info-circle"></i> Click on any available room to view details and book</p>
        </div>
    </div>
</section>


<?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('components.room-modal', ['room' => $room], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/roomModal.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\imperial\resources\views/room.blade.php ENDPATH**/ ?>