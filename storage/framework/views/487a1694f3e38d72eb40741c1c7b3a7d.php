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
                <svg viewBox="0 0 900 700" class="floor-svg" style="background: #000;">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="880" height="680" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    
                    
                    <!-- Public Bathroom (top-left, above Room G) -->
                    <rect x="10" y="10" width="130" height="100" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="75" cy="50" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="75" y="85" fill="#fff" font-size="11" text-anchor="middle" font-weight="bold">PUBLIC WC</text>
                    
                    <!-- Stairs (next to public bathroom) -->
                    <g>
                        <rect x="150" y="10" width="130" height="100" fill="#000" stroke="#fff" stroke-width="3"/>
                        <!-- Diagonal lines for stairs -->
                        <line x1="160" y1="20" x2="270" y2="100" stroke="#fff" stroke-width="2"/>
                        <line x1="165" y1="20" x2="275" y2="100" stroke="#fff" stroke-width="1"/>
                        <line x1="170" y1="20" x2="280" y2="100" stroke="#fff" stroke-width="1"/>
                        <line x1="155" y1="25" x2="265" y2="105" stroke="#fff" stroke-width="1"/>
                        <line x1="160" y1="30" x2="270" y2="110" stroke="#fff" stroke-width="1"/>
                        <line x1="165" y1="35" x2="275" y2="115" stroke="#fff" stroke-width="1"/>
                        <!-- X pattern -->
                        <line x1="270" y1="20" x2="160" y2="100" stroke="#fff" stroke-width="2"/>
                        <line x1="275" y1="20" x2="165" y2="100" stroke="#fff" stroke-width="1"/>
                        <text x="215" y="65" fill="#fff" font-size="12" font-weight="bold" text-anchor="middle">STAIRS</text>
                    </g>
                    
                    <!-- Room G (with bathroom inside, top-right corner) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'G'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="10" y="120" width="270" height="170" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="145" y="215" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">G</text>
                        
                        <!-- Bathroom inside Room G (top-right corner) -->
                        <rect x="200" y="130" width="70" height="70" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="235" cy="165" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                        
                        <!-- Bed in Room G -->
                        <rect x="25" y="145" width="90" height="60" fill="none" stroke="#000" stroke-width="2"/>
                        <line x1="25" y1="175" x2="115" y2="175" stroke="#000" stroke-width="1"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room F (bathroom half inside/half outside) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'F'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="10" y="300" width="270" height="180" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="145" y="405" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">F</text>
                        
                        <!-- Bathroom (half inside, half appears as wall from outside) -->
                        <rect x="10" y="310" width="60" height="80" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="40" cy="350" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room E (bathroom below F's bathroom) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'E'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="10" y="490" width="270" height="200" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="145" y="605" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">E</text>
                        
                        <!-- Bathroom below F's bathroom -->
                        <rect x="10" y="500" width="60" height="90" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="40" cy="545" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                    
                    <!-- Main Hallway (bigger, in the middle) -->
                    <rect x="290" y="120" width="150" height="570" fill="#000" stroke="#fff" stroke-width="3"/>
                    <text x="365" y="420" fill="#fff" font-size="16" font-weight="bold" text-anchor="middle" transform="rotate(-90 365 420)">HALLWAY</text>
                    
                    <!-- Exit/Entrance Door (in hallway, right of Room C) -->
                    <g>
                        <rect x="290" y="580" width="150" height="110" fill="#000" stroke="#fff" stroke-width="3"/>
                        <rect x="320" y="605" width="90" height="60" fill="none" stroke="#fff" stroke-width="4"/>
                        <line x1="365" y1="605" x2="365" y2="665" stroke="#fff" stroke-width="3"/>
                        <circle cx="355" cy="635" r="5" fill="#fff"/>
                        <text x="365" y="650" fill="#fff" font-size="14" font-weight="bold" text-anchor="middle">EXIT</text>
                    </g>
                    
                    
                    
                    <!-- Public Kitchen (top-right, above Room D) -->
                    <rect x="450" y="10" width="440" height="100" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="480" y="30" width="100" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="600" y="30" width="100" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="530" cy="55" r="10" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="650" cy="55" r="10" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="730" y="35" width="60" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="670" y="65" fill="#fff" font-size="14" text-anchor="middle" font-weight="bold">PUBLIC KITCHEN</text>
                    
                    <!-- Room D (with bathroom inside) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'D'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="450" y="120" width="440" height="150" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="670" y="205" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">D</text>
                        
                        <!-- Bathroom inside Room D (top-right corner) -->
                        <rect x="810" y="130" width="70" height="70" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="845" cy="165" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room C (on the left side) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'C'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="450" y="280" width="330" height="110" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="615" y="345" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">C</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bathroom for Room C (RIGHT side of Room C, top bathroom) -->
                    <rect x="790" y="280" width="100" height="50" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="840" cy="305" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="840" y="325" fill="#fff" font-size="9" text-anchor="middle" font-weight="bold">WC</text>
                    
                    <!-- Bathroom for Room B (RIGHT side of Room C, bottom bathroom, aligned with Room C) -->
                    <rect x="790" y="340" width="100" height="50" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="840" cy="365" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="840" y="385" fill="#fff" font-size="9" text-anchor="middle" font-weight="bold">WC</text>
                    
                    <!-- Room B (bigger length/height, smaller width) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'B'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="560" y="400" width="330" height="140" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="725" y="480" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">B</text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room A (follows F's width, with bathroom inside) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'A'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="560" y="550" width="330" height="140" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="725" y="630" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">A</text>
                        
                        <!-- Bathroom inside Room A (bottom-right corner) -->
                        <rect x="810" y="600" width="70" height="80" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="845" cy="640" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                    <rect x="450" y="400" width="100" height="290" fill="#000" stroke="#fff" stroke-width="3"/>
                </svg>
            </div>
        </div>

        
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> Second Floor (2F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 1100 450" class="floor-svg" style="background: #000;">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="1080" height="430" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    
                    
                    <!-- Washing Machine Area (open corner top-left) -->
                    <rect x="10" y="10" width="220" height="180" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="30" y="30" width="70" height="70" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="65" cy="65" r="22" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="140" y="30" width="70" height="70" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="175" cy="65" r="22" fill="none" stroke="#fff" stroke-width="2"/>
                    <text x="120" y="140" fill="#fff" font-size="13" text-anchor="middle" font-weight="bold">WASHING</text>
                    <text x="120" y="160" fill="#fff" font-size="13" text-anchor="middle" font-weight="bold">MACHINES</text>
                    
                    
                    
                    <!-- Stairs (next to washing machines) -->
                    <g>
                        <rect x="240" y="10" width="130" height="180" fill="#000" stroke="#fff" stroke-width="3"/>
                        <!-- Diagonal lines for stairs -->
                        <line x1="250" y1="20" x2="360" y2="180" stroke="#fff" stroke-width="2"/>
                        <line x1="255" y1="20" x2="365" y2="180" stroke="#fff" stroke-width="1"/>
                        <line x1="260" y1="20" x2="370" y2="180" stroke="#fff" stroke-width="1"/>
                        <line x1="245" y1="25" x2="355" y2="185" stroke="#fff" stroke-width="1"/>
                        <line x1="250" y1="30" x2="360" y2="190" stroke="#fff" stroke-width="1"/>
                        <line x1="255" y1="35" x2="365" y2="195" stroke="#fff" stroke-width="1"/>
                        <!-- X pattern -->
                        <line x1="360" y1="20" x2="250" y2="180" stroke="#fff" stroke-width="2"/>
                        <line x1="365" y1="20" x2="255" y2="180" stroke="#fff" stroke-width="1"/>
                        <text x="305" y="105" fill="#fff" font-size="13" font-weight="bold" text-anchor="middle" transform="rotate(-60 305 105)">STAIRS</text>
                    </g>
                    
                    
                    
                    <!-- Corridor/Hallway (gap between stairs and rooms) -->
                    <rect x="380" y="10" width="140" height="430" fill="#000" stroke="#fff" stroke-width="3"/>
                    <text x="450" y="230" fill="#fff" font-size="15" font-weight="bold" text-anchor="middle" transform="rotate(-90 450 230)">CORRIDOR</text>
                    
                    
                    
                    <!-- Clothes Drying Area - Combined with corridor space (bottom left corner) -->
                    <rect x="10" y="200" width="360" height="240" fill="#000" stroke="#fff" stroke-width="3"/>
                    <text x="190" y="260" fill="#fff" font-size="16" text-anchor="middle" font-weight="bold">CLOTHES DRYING AREA</text>
                    <text x="190" y="280" fill="#fff" font-size="13" text-anchor="middle" font-weight="normal">(Open Corridor Space)</text>
                    
                    <!-- Drying racks illustration -->
                    <rect x="30" y="310" width="100" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    <line x1="40" y1="320" x2="120" y2="320" stroke="#fff" stroke-width="1"/>
                    <line x1="40" y1="330" x2="120" y2="330" stroke="#fff" stroke-width="1"/>
                    <line x1="40" y1="340" x2="120" y2="340" stroke="#fff" stroke-width="1"/>
                    <line x1="40" y1="350" x2="120" y2="350" stroke="#fff" stroke-width="1"/>
                    
                    <rect x="150" y="310" width="100" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    <line x1="160" y1="320" x2="240" y2="320" stroke="#fff" stroke-width="1"/>
                    <line x1="160" y1="330" x2="240" y2="330" stroke="#fff" stroke-width="1"/>
                    <line x1="160" y1="340" x2="240" y2="340" stroke="#fff" stroke-width="1"/>
                    <line x1="160" y1="350" x2="240" y2="350" stroke="#fff" stroke-width="1"/>
                    
                    <rect x="270" y="310" width="80" height="60" fill="none" stroke="#fff" stroke-width="2"/>
                    <line x1="280" y1="320" x2="340" y2="320" stroke="#fff" stroke-width="1"/>
                    <line x1="280" y1="330" x2="340" y2="330" stroke="#fff" stroke-width="1"/>
                    <line x1="280" y1="340" x2="340" y2="340" stroke="#fff" stroke-width="1"/>
                    
                    <rect x="90" y="385" width="190" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <line x1="100" y1="395" x2="270" y2="395" stroke="#fff" stroke-width="1"/>
                    <line x1="100" y1="405" x2="270" y2="405" stroke="#fff" stroke-width="1"/>
                    <line x1="100" y1="415" x2="270" y2="415" stroke="#fff" stroke-width="1"/>
                    
                    
                    
                    <!-- Room H (top right, with bathroom) -->
                    <?php $__currentLoopData = $floor2Rooms->where('room_number', 'H'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="530" y="10" width="270" height="200" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="665" y="120" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">H</text>
                        
                        <!-- Bathroom inside Room H (top-left corner) -->
                        <rect x="540" y="20" width="70" height="80" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="575" cy="60" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                        
                        <!-- Bed in Room H -->
                        <rect x="630" y="130" width="130" height="70" fill="none" stroke="#000" stroke-width="2"/>
                        <line x1="630" y1="165" x2="760" y2="165" stroke="#000" stroke-width="1"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room I (next to Room H, same size, with bathroom) -->
                    <?php $__currentLoopData = $floor2Rooms->where('room_number', 'I'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)" style="cursor: pointer;">
                        <rect x="810" y="10" width="280" height="200" class="room-fill <?php echo e($room->status); ?>" stroke="#fff" stroke-width="3"/>
                        <text x="950" y="120" fill="#000" font-size="56" font-weight="900" text-anchor="middle" class="room-label">I</text>
                        
                        <!-- Bathroom inside Room I (top-left corner) -->
                        <rect x="820" y="20" width="70" height="80" fill="#000" stroke="#fff" stroke-width="2"/>
                        <circle cx="855" cy="60" r="14" fill="none" stroke="#fff" stroke-width="2"/>
                        
                        <!-- Bed in Room I -->
                        <rect x="910" y="130" width="160" height="70" fill="none" stroke="#000" stroke-width="2"/>
                        <line x1="910" y1="165" x2="1070" y2="165" stroke="#000" stroke-width="1"/>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
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