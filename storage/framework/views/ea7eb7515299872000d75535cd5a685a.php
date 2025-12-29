<footer style="background-color: #1a1a1a; color: #fff; padding: 3rem 0 1.5rem 0;">
    <div class="container">
        <div class="row">
            <!-- Logo and Description -->
            <div class="col-md-5 mb-4 mb-md-0">
                <img src="<?php echo e(asset('images/imperial-kost-logo.png')); ?>" alt="Imperial F7 Logo" style="height: 50px; margin-bottom: 1rem;">
                <p style="color: #999; font-size: 0.9rem; max-width: 350px; line-height: 1.6;">
                    Premium boarding house with modern amenities and seamless booking experience.
                </p>
            </div>

             <!-- Quick Links -->
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="mb-3" style="font-size: 1.1rem; font-weight: 600;">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?php echo e(route('home')); ?>" style="color: #999; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#999'">Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="<?php echo e(route('rooms')); ?>" style="color: #999; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#999'">Rooms</a>
                    </li>
                    <li class="mb-2">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('profile.edit')); ?>" style="color: #999; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#999'">Profile</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" style="color: #999; text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#999'">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>

            <!-- Contacts -->
            <div class="col-md-4 mb-4 mb-md-0">
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <hr style="border-color: #333; margin: 2.5rem 0 1.5rem 0;">
        <div class="text-center">
            <p style="color: #666; font-size: 0.85rem; margin: 0;">&copy; 2024 ImperialKost. All rights reserved.</p>
        </div>
    </div>
</footer><?php /**PATH D:\Github\imperial\resources\views/components/footer.blade.php ENDPATH**/ ?>