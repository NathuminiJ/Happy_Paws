<?php
require_once __DIR__ . '/../../config/config.php';

$pageTitle = 'About Us';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- About Page -->
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo SITE_URL; ?>" class="text-gray-700 hover:text-primary transition">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-primary">About Us</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <!-- Hero Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-12">
        <div class="relative">
            <img src="https://via.placeholder.com/1200x400?text=About+BeautyShop" alt="About BeautyShop" class="w-full h-64 md:h-80 object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/70 to-transparent flex items-center">
                <div class="px-8 md:px-16">
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">About BeautyShop</h1>
                    <p class="text-white text-lg max-w-lg">Your trusted destination for premium beauty products since 2010.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Story -->
    <div class="mb-16">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4">
                    BeautyShop was founded in 2010 with a simple mission: to provide high-quality beauty products that enhance your natural beauty while being kind to your skin and the environment.
                </p>
                <p class="text-gray-600 mb-4">
                    What started as a small boutique with a handful of carefully selected products has grown into a comprehensive beauty destination offering hundreds of premium items across skincare, haircare, makeup, and more.
                </p>
                <p class="text-gray-600">
                    Despite our growth, our core values remain unchanged. We believe in beauty that's inclusive, sustainable, and empowering. Every product in our collection is thoughtfully chosen to align with these principles.
                </p>
            </div>
            <div class="md:w-1/2">
                <img src="https://via.placeholder.com/600x400?text=Our+Story" alt="Our Story" class="rounded-lg shadow-md w-full">
            </div>
        </div>
    </div>
    
    <!-- Our Mission -->
    <div class="bg-gray-50 rounded-lg p-8 md:p-12 mb-16">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Mission</h2>
            <p class="text-xl text-gray-600 italic mb-8">
                "To empower individuals to look and feel their best by providing exceptional beauty products that are effective, safe, and responsibly sourced."
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Quality & Purity</h3>
                    <p class="text-gray-600">We carefully select products with clean, effective ingredients that deliver real results.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-globe-americas text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Sustainability</h3>
                    <p class="text-gray-600">We prioritize eco-friendly practices and partners who share our commitment to the planet.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Inclusivity</h3>
                    <p class="text-gray-600">We believe beauty is for everyone, and our product range reflects diverse needs and preferences.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Team -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Meet Our Team</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                <img src="https://via.placeholder.com/300x300?text=CEO" alt="Sarah Johnson - CEO" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">Sarah Johnson</h3>
                    <p class="text-primary font-medium mb-3">CEO & Founder</p>
                    <p class="text-gray-600 mb-4">With over 15 years in the beauty industry, Sarah's passion for quality skincare drives our vision.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-primary transition"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                <img src="https://via.placeholder.com/300x300?text=COO" alt="Michael Chen - COO" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">Michael Chen</h3>
                    <p class="text-primary font-medium mb-3">Chief Operations Officer</p>
                    <p class="text-gray-600 mb-4">Michael ensures our operations run smoothly while maintaining our commitment to sustainability.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-primary transition"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                <img src="https://via.placeholder.com/300x300?text=Beauty+Director" alt="Emily Rodriguez - Beauty Director" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">Emily Rodriguez</h3>
                    <p class="text-primary font-medium mb-3">Beauty Director</p>
                    <p class="text-gray-600 mb-4">A certified dermatologist, Emily leads our product selection with expert knowledge and care.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-primary transition"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform transform hover:scale-105">
                <img src="https://via.placeholder.com/300x300?text=Marketing+Director" alt="David Patel - Marketing Director" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-1">David Patel</h3>
                    <p class="text-primary font-medium mb-3">Marketing Director</p>
                    <p class="text-gray-600 mb-4">David's creative approach helps us connect with beauty enthusiasts and share our story.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-primary transition"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Values -->
    <div class="mb-16">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
            <div class="md:w-1/2 order-2 md:order-1">
                <img src="https://via.placeholder.com/600x400?text=Our+Values" alt="Our Values" class="rounded-lg shadow-md w-full">
            </div>
            <div class="md:w-1/2 order-1 md:order-2">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Values</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary-light flex items-center justify-center mt-1">
                            <i class="fas fa-check text-primary text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-800">Quality First</h3>
                            <p class="text-gray-600">We never compromise on the quality of our products. Each item in our collection undergoes rigorous testing and evaluation.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary-light flex items-center justify-center mt-1">
                            <i class="fas fa-check text-primary text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-800">Ethical Sourcing</h3>
                            <p class="text-gray-600">We partner with brands that share our commitment to ethical sourcing, fair trade practices, and cruelty-free testing.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary-light flex items-center justify-center mt-1">
                            <i class="fas fa-check text-primary text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-800">Customer Satisfaction</h3>
                            <p class="text-gray-600">Your happiness is our priority. We're committed to exceptional service and stand behind every product we sell.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-primary-light flex items-center justify-center mt-1">
                            <i class="fas fa-check text-primary text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-800">Continuous Improvement</h3>
                            <p class="text-gray-600">We're always learning, growing, and seeking better ways to serve our customers and the planet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Testimonials -->
    <div class="bg-gray-50 rounded-lg p-8 md:p-12 mb-16">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">What Our Customers Say</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 italic mb-6">"I've been using BeautyShop products for years, and I'm consistently impressed by the quality. Their customer service is also exceptional!"</p>
                <div class="flex items-center">
                    <img src="https://via.placeholder.com/60x60?text=User" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Jessica T.</h4>
                        <p class="text-gray-500 text-sm">Loyal Customer since 2015</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 italic mb-6">"The skincare products I purchased have transformed my complexion. I appreciate that BeautyShop offers clean, effective options for all skin types."</p>
                <div class="flex items-center">
                    <img src="https://via.placeholder.com/60x60?text=User" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Marcus W.</h4>
                        <p class="text-gray-500 text-sm">Skincare Enthusiast</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="text-gray-600 italic mb-6">"As someone with sensitive skin, I'm always cautious about trying new products. BeautyShop's detailed descriptions and helpful staff made finding the right products easy."</p>
                <div class="flex items-center">
                    <img src="https://via.placeholder.com/60x60?text=User" alt="Customer" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-800">Aisha K.</h4>
                        <p class="text-gray-500 text-sm">First-time Customer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="bg-primary rounded-lg p-8 md:p-12 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Join Our Beauty Journey</h2>
        <p class="text-white opacity-90 max-w-2xl mx-auto mb-8">
            Discover premium beauty products that align with your values and enhance your natural beauty.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="bg-white hover:bg-gray-100 text-primary font-bold py-3 px-6 rounded-md transition duration-300">
                Shop Now
            </a>
            <a href="<?php echo SITE_URL; ?>/pages/user/contact.php" class="bg-transparent hover:bg-primary-dark text-white border border-white font-bold py-3 px-6 rounded-md transition duration-300">
                Contact Us
            </a>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
