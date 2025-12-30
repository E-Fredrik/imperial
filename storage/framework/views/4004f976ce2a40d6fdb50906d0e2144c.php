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
                <svg viewBox="0 0 1000 850" class="floor-svg">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="780" height="830" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    
                    <!-- Top left bathroom -->
                    <rect x="10" y="10" width="110" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="95" cy="55" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room A (left top) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'A'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="10" y="150" width="110" height="140" class="room-fill"/>
                        <rect x="10" y="150" width="110" height="140" class="room-outline"/>
                        <text x="65" y="225" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Kitchen below A -->
                    <rect x="10" y="300" width="110" height="135" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="35" y="340" width="60" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <circle cx="95" cy="360" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom below kitchen -->
                    <rect x="10" y="445" width="50" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="35" cy="492" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room C (left bottom large) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'C'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="10" y="550" width="110" height="240" class="room-fill"/>
                        <rect x="10" y="550" width="110" height="240" class="room-outline"/>
                        <text x="65" y="675" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bottom left bathroom -->
                    <rect x="10" y="800" width="110" height="40" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="95" cy="820" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    <!-- Stairs at top -->
                    <g class="stair-block">
                        <rect x="130" y="10" width="130" height="130" fill="#000" stroke="#fff" stroke-width="3"/>
                        <line x1="130" y1="30" x2="260" y2="30" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="45" x2="260" y2="45" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="60" x2="260" y2="60" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="75" x2="260" y2="75" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="90" x2="260" y2="90" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="105" x2="260" y2="105" stroke="#fff" stroke-width="2"/>
                        <line x1="130" y1="120" x2="260" y2="120" stroke="#fff" stroke-width="2"/>
                        <!-- Diagonal arrows -->
                        <line x1="220" y1="120" x2="250" y2="130" stroke="#fff" stroke-width="4"/>
                        <line x1="180" y1="120" x2="210" y2="130" stroke="#fff" stroke-width="4"/>
                    </g>
                    
                    <!-- Central corridor/hall -->
                    <rect x="130" y="150" width="130" height="690" fill="#000"/>
                    
                    <!-- Seating area furniture in corridor -->
                    <rect x="155" y="300" width="35" height="55" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="172.5" cy="380" rx="25" ry="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="172.5" cy="480" rx="25" ry="35" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room B (extends next to corridor) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'B'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="130" y="150" width="130" height="140" class="room-fill"/>
                        <rect x="130" y="150" width="130" height="140" class="room-outline"/>
                        <text x="195" y="225" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bathroom mid-corridor -->
                    <rect x="130" y="550" width="130" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="155" y="570" width="80" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Kitchen mid-corridor -->
                    <rect x="130" y="650" width="130" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="155" y="670" width="80" height="50" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom bottom corridor -->
                    <rect x="130" y="750" width="130" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="225" cy="795" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    <!-- Small bathroom top right -->
                    <rect x="270" y="10" width="180" height="65" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="440" cy="42" r="15" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room D (top right) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'D'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="270" y="85" width="85" height="110" class="room-fill"/>
                        <rect x="270" y="85" width="85" height="110" class="room-outline"/>
                        <text x="312" y="145" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Room E (right of D) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'E'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="365" y="85" width="85" height="110" class="room-fill"/>
                        <rect x="365" y="85" width="85" height="110" class="room-outline"/>
                        <text x="407" y="145" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Small bathroom between rooms -->
                    <rect x="460" y="10" width="85" height="185" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="502" cy="102" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room F (right middle) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'F'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="270" y="205" width="180" height="95" class="room-fill"/>
                        <rect x="270" y="205" width="180" height="95" class="room-outline"/>
                        <text x="360" y="257" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Small bathroom -->
                    <rect x="460" y="205" width="85" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="532" cy="252" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room G (right large section) -->
                    <?php $__currentLoopData = $floor1Rooms->where('room_number', 'G'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="270" y="310" width="275" height="190" class="room-fill"/>
                        <rect x="270" y="310" width="275" height="190" class="room-outline"/>
                        <text x="407" y="410" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                    <!-- Top bathroom -->
                    <rect x="555" y="10" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="57" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Small bedroom -->
                    <rect x="555" y="115" width="90" height="85" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    <!-- Bathroom -->
                    <rect x="555" y="210" width="90" height="90" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="255" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Another bedroom -->
                    <rect x="555" y="310" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    <!-- Bathroom -->
                    <rect x="555" y="415" width="90" height="85" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="457" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    <!-- Large empty area / dining -->
                    <rect x="270" y="510" width="275" height="180" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="295" y="570" width="60" height="80" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="400" cy="610" rx="50" ry="30" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathrooms bottom right -->
                    <rect x="555" y="510" width="90" height="95" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="557" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <rect x="555" y="615" width="90" height="75" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="652" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Kitchen/dining bottom -->
                    <rect x="270" y="700" width="185" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="295" y="730" width="60" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="365" y="730" width="70" height="40" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom bottom right corner -->
                    <rect x="465" y="700" width="180" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="630" cy="770" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    
                    <rect x="655" y="10" width="135" height="830" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                </svg>
            </div>
        </div>

        
        <div class="floor-plan-container">
            <div class="floor-title">
                <h2><i class="bi bi-building"></i> Second Floor (2F)</h2>
            </div>
            
            <div class="floor-map-wrapper">
                <svg viewBox="0 0 1000 290" class="floor-svg">
                    <!-- Building outer border -->
                    <rect x="10" y="10" width="980" height="270" fill="none" stroke="#fff" stroke-width="4"/>
                    
                    
                    <rect x="10" y="10" width="230" height="270" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                    
                    <g class="stair-block-2f">
                        <rect x="250" y="10" width="90" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                        <line x1="250" y1="25" x2="340" y2="25" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="38" x2="340" y2="38" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="51" x2="340" y2="51" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="64" x2="340" y2="64" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="77" x2="340" y2="77" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="90" x2="340" y2="90" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="103" x2="340" y2="103" stroke="#fff" stroke-width="2"/>
                        <line x1="250" y1="116" x2="340" y2="116" stroke="#fff" stroke-width="2"/>
                        <!-- Diagonal arrows -->
                        <line x1="310" y1="115" x2="330" y2="125" stroke="#fff" stroke-width="4"/>
                        <line x1="280" y1="115" x2="300" y2="125" stroke="#fff" stroke-width="4"/>
                    </g>
                    
                    
                    <rect x="250" y="140" width="290" height="140" fill="#000"/>
                    
                    
                    <!-- Bathroom top right -->
                    <rect x="550" y="10" width="90" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="618" cy="70" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room H (top right 1) -->
                    <?php $__currentLoopData = $floor2Rooms->where('room_number', 'H'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="650" y="10" width="90" height="120" class="room-fill"/>
                        <rect x="650" y="10" width="90" height="120" class="room-outline"/>
                        <text x="695" y="75" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Bathroom -->
                    <rect x="750" y="10" width="85" height="120" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="818" cy="70" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room I (top right 2) -->
                    <?php $__currentLoopData = $floor2Rooms->where('room_number', 'I'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <g class="room-group clickable-room <?php echo e($room->status); ?>" onclick="openRoomModal(<?php echo e($room->id); ?>)">
                        <rect x="845" y="10" width="145" height="120" class="room-fill"/>
                        <rect x="845" y="10" width="145" height="120" class="room-outline"/>
                        <text x="917" y="75" class="room-label"><?php echo e($room->room_number); ?></text>
                    </g>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                    <!-- Dining/seating area -->
                    <rect x="550" y="140" width="90" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <ellipse cx="595" cy="195" rx="25" ry="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <rect x="565" cy="245" width="50" height="25" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Large room bottom right -->
                    <rect x="650" y="140" width="185" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <rect x="675" y="170" width="60" height="35" fill="none" stroke="#fff" stroke-width="2"/>
                    <ellipse cx="765" cy="230" rx="35" ry="25" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Bathroom bottom -->
                    <rect x="845" y="140" width="70" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    <circle cx="903" cy="210" r="18" fill="none" stroke="#fff" stroke-width="2"/>
                    
                    <!-- Room/storage bottom right -->
                    <rect x="925" y="140" width="65" height="140" fill="#000" stroke="#fff" stroke-width="3"/>
                    
                </svg>
            </div>
        </div>

        <div class="floor-info-text">
            <p><i class="bi bi-info-circle"></i> Click on any room to view details and book</p>
        </div>
    </div>
</section>


<?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div id="room-modal-<?php echo e($room->id); ?>" class="room-modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="closeRoomModal(<?php echo e($room->id); ?>)">
            <i class="bi bi-x-lg"></i> Close
        </button>
        
        <div class="modal-layout">
            
            <div class="modal-visual">
                
                <div class="room-gallery">
                    <?php if($room->images->count() > 0): ?>
                        <div class="gallery-main">
                            <img src="<?php echo e(asset($room->images->first()->image_path)); ?>" alt="Room <?php echo e($room->room_number); ?>" class="main-image">
                        </div>
                        <?php if($room->images->count() > 1): ?>
                            <div class="gallery-thumbnails">
                                <?php $__currentLoopData = $room->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset($image->image_path)); ?>" alt="Room <?php echo e($room->room_number); ?>" class="thumbnail">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="no-images">
                            <i class="bi bi-image"></i>
                            <p>No images available</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                
                <div class="room-3d-view">
                    <div class="view-placeholder">
                        <i class="bi bi-box"></i>
                        <p>3D View Coming Soon</p>
                    </div>
                </div>
            </div>
            
            
            <div class="modal-info">
                <div class="info-header">
                    <h2>Room <?php echo e($room->room_number); ?></h2>
                    <p><?php echo e($room->type); ?> • Floor <?php echo e($room->floor); ?></p>
                </div>
                
                <div class="info-details">
                    <div class="detail-row">
                        <i class="bi bi-rulers"></i>
                        <span><?php echo e($room->length); ?>m × <?php echo e($room->width); ?>m</span>
                    </div>
                    
                    <div class="detail-row">
                        <i class="bi bi-cash-coin"></i>
                        <span class="price">Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?>/month</span>
                    </div>
                    
                    <div class="detail-row">
                        <i class="bi bi-info-circle"></i>
                        <span class="status-badge status-<?php echo e($room->status); ?>"><?php echo e(ucfirst($room->status)); ?></span>
                    </div>
                </div>
                
                <div class="description-section">
                    <h3>Description</h3>
                    <p><?php echo e($room->description ?: 'This is a comfortable ' . $room->type . ' room located on floor ' . $room->floor . '.'); ?></p>
                </div>
                
                <div class="facilities-section">
                    <h3>Facilities</h3>
                    <div class="facilities-list">
                        <?php $__empty_1 = true; $__currentLoopData = $room->rooms_facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="facility-item">
                                <?php if($rf->room_facility && $rf->room_facility->images->count() > 0): ?>
                                    <img src="<?php echo e(asset($rf->room_facility->images->first()->image_path)); ?>" alt="<?php echo e($rf->room_facility->name); ?>">
                                <?php else: ?>
                                    <i class="bi bi-check-circle-fill"></i>
                                <?php endif; ?>
                                <span><?php echo e(optional($rf->room_facility)->name ?? 'N/A'); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>No facilities listed</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="booking-section">
                    <h3>Book This Room</h3>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($room->status === 'available'): ?>
                            <form action="<?php echo e(route('bookings.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="room_id" value="<?php echo e($room->id); ?>">
                                
                                <div class="date-input-group">
                                    <label for="move_in_date_<?php echo e($room->id); ?>">Move-in Date</label>
                                    <input type="date" id="move_in_date_<?php echo e($room->id); ?>" name="move_in_date" min="<?php echo e(date('Y-m-d')); ?>" required>
                                </div>
                                
                                <div class="action-buttons">
                                    <button type="submit" class="btn-book">
                                        <i class="bi bi-calendar-check"></i> Book Now
                                    </button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="unavailable-notice">
                                <i class="bi bi-exclamation-circle"></i>
                                <p>This room is currently <?php echo e($room->status); ?></p>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="login-notice">
                            <i class="bi bi-info-circle"></i>
                            <p>Please <a href="<?php echo e(route('login')); ?>">login</a> to book this room</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/roomModal.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/room.blade.php ENDPATH**/ ?>