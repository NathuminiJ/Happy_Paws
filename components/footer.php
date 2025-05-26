    </main>
    
    <!-- Footer -->
    <footer class="bg-oldschool-bg text-oldschool-text pt-8 pb-6 mt-8 border-t-4 border-oldschool-border">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div class="old-border bg-white p-4">
                    <h3 class="text-xl font-semibold mb-4 text-primary border-b-2 border-oldschool-border pb-2">About Happy Paws</h3>
                    <p class="text-oldschool-text mb-4">
                        Your one-stop destination for premium pet supplies. We offer a wide range of food, toys, accessories, and care products to keep your furry friends happy and healthy.
                    </p>
                    <div class="flex space-x-4 justify-center">
                        <a href="#" class="text-oldschool-link hover:text-primary transition old-button px-2 py-1">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-oldschool-link hover:text-primary transition old-button px-2 py-1">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-oldschool-link hover:text-primary transition old-button px-2 py-1">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-oldschool-link hover:text-primary transition old-button px-2 py-1">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Categories -->
                <div class="old-border bg-white p-4">
                    <h3 class="text-xl font-semibold mb-4 text-primary border-b-2 border-oldschool-border pb-2">Categories</h3>
                    <ul class="space-y-2">
                        <?php
                        foreach ($categories as $category) {
                            echo '<li><a href="' . SITE_URL . '/pages/user/products.php?category=' . $category['slug'] . '" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">' . $category['name'] . ' &raquo;</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                
                <!-- Quick Links -->
                <div class="old-border bg-white p-4">
                    <h3 class="text-xl font-semibold mb-4 text-primary border-b-2 border-oldschool-border pb-2">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="<?php echo SITE_URL; ?>" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">Home &raquo;</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/user/who-am-i.php" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">Who Am I &raquo;</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">Shop &raquo;</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/user/faq.php" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">FAQ &raquo;</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/user/shipping-policy.php" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">Shipping Policy &raquo;</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/user/privacy-policy.php" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">Privacy Policy &raquo;</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/user/terms.php" class="text-oldschool-link hover:text-primary transition block p-1 hover:bg-oldschool-highlight">Terms & Conditions &raquo;</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="old-border bg-white p-4">
                    <h3 class="text-xl font-semibold mb-4 text-primary border-b-2 border-oldschool-border pb-2">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span class="text-oldschool-text">123 Pet Avenue, Pawsville, PC 12345</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-primary"></i>
                            <span class="text-oldschool-text">+1 (123) 456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary"></i>
                            <span class="text-oldschool-text">info@happypaws.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-primary"></i>
                            <span class="text-oldschool-text">Mon-Fri: 9AM - 6PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="my-8 text-center">
                <div class="inline-block old-border bg-white p-2 px-4 mx-auto">
                    <img src="https://via.placeholder.com/240x30?text=Payment+Methods" alt="Payment Methods" class="h-6 mb-2">
                    <p class="text-oldschool-text text-sm border-t border-oldschool-border pt-2">
                        &copy; <?php echo date('Y'); ?> Happy Paws. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileSearch = document.getElementById('mobile-search');
            
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                mobileSearch.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                mobileSearch.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
