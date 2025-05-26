<?php
require_once __DIR__ . '/../../config/config.php';

// Process contact form submission
$formSubmitted = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    
    // Validate input
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // If no errors, process form
    if (empty($errors)) {
        // In a real application, you would send an email or save to database here
        
        // Set success flag
        $formSubmitted = true;
    }
}

$pageTitle = 'Contact Us';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Contact Page -->
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
                    <span class="text-primary">Contact Us</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Contact Us</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Get in Touch</h2>
            
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-light flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-800">Our Location</h3>
                        <p class="text-gray-600">123 Beauty Street, Cosmetic City, BC 12345</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-light flex items-center justify-center">
                        <i class="fas fa-phone-alt text-primary"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-800">Phone Number</h3>
                        <p class="text-gray-600">+1 (123) 456-7890</p>
                        <p class="text-gray-600">+1 (987) 654-3210</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-light flex items-center justify-center">
                        <i class="fas fa-envelope text-primary"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-800">Email Address</h3>
                        <p class="text-gray-600">info@beautyshop.com</p>
                        <p class="text-gray-600">support@beautyshop.com</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-light flex items-center justify-center">
                        <i class="fas fa-clock text-primary"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-800">Business Hours</h3>
                        <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                        <p class="text-gray-600">Saturday: 10:00 AM - 4:00 PM</p>
                        <p class="text-gray-600">Sunday: Closed</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Connect With Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white hover:bg-blue-700 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="h-10 w-10 rounded-full bg-blue-400 flex items-center justify-center text-white hover:bg-blue-500 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="h-10 w-10 rounded-full bg-pink-600 flex items-center justify-center text-white hover:bg-pink-700 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="h-10 w-10 rounded-full bg-red-600 flex items-center justify-center text-white hover:bg-red-700 transition">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <a href="#" class="h-10 w-10 rounded-full bg-blue-800 flex items-center justify-center text-white hover:bg-blue-900 transition">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Send Us a Message</h2>
            
            <?php if ($formSubmitted): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Thank you for your message! We'll get back to you soon.</span>
                </div>
            </div>
            <?php else: ?>
            
            <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <h3 class="font-bold">Please fix the following errors:</h3>
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form action="<?php echo SITE_URL; ?>/pages/user/contact.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Your Name *</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Your Email *</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="subject" class="block text-gray-700 text-sm font-medium mb-2">Subject *</label>
                    <input type="text" id="subject" name="subject" 
                           value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                           required>
                </div>
                
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 text-sm font-medium mb-2">Message *</label>
                    <textarea id="message" name="message" rows="6" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                              required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                </div>
                
                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-4 rounded-md transition duration-300">
                    Send Message
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Find Us</h2>
        <div class="aspect-w-16 aspect-h-9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387193.30591910525!2d-74.25986432970718!3d40.697149422113014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1622050259429!5m2!1sen!2s" 
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-lg"></iframe>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Frequently Asked Questions</h2>
        
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-1">
                    <span class="text-lg font-medium text-gray-800">What are your shipping rates?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                </button>
                <div id="faq-1" class="faq-content px-6 pb-4 hidden">
                    <p class="text-gray-600">We offer free shipping on all orders over $50. For orders under $50, a flat shipping rate of $5.00 is applied.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-2">
                    <span class="text-lg font-medium text-gray-800">What is your return policy?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                </button>
                <div id="faq-2" class="faq-content px-6 pb-4 hidden">
                    <p class="text-gray-600">We offer a 30-day money-back guarantee on all our products. If you're not satisfied with your purchase, you can return it within 30 days for a full refund or exchange.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-3">
                    <span class="text-lg font-medium text-gray-800">Are your products cruelty-free?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                </button>
                <div id="faq-3" class="faq-content px-6 pb-4 hidden">
                    <p class="text-gray-600">Yes, all products sold at BeautyShop are cruelty-free. We do not carry brands that test on animals or sell in markets where animal testing is required by law.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-4">
                    <span class="text-lg font-medium text-gray-800">Do you ship internationally?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                </button>
                <div id="faq-4" class="faq-content px-6 pb-4 hidden">
                    <p class="text-gray-600">Yes, we ship to most countries worldwide. International shipping rates and delivery times vary depending on the destination. Please check our shipping page for more details.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-5">
                    <span class="text-lg font-medium text-gray-800">How can I track my order?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                </button>
                <div id="faq-5" class="faq-content px-6 pb-4 hidden">
                    <p class="text-gray-600">Once your order ships, you'll receive a confirmation email with a tracking number. You can use this number to track your package on our website or directly through the carrier's website.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Newsletter Section -->
    <div class="bg-primary rounded-lg p-8 md:p-12 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Subscribe to Our Newsletter</h2>
        <p class="text-white opacity-90 max-w-2xl mx-auto mb-8">
            Stay updated with our latest products, promotions, and beauty tips. Subscribe to our newsletter for exclusive offers!
        </p>
        <form class="max-w-md mx-auto flex flex-col sm:flex-row">
            <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-l-md focus:outline-none mb-2 sm:mb-0">
            <button type="submit" class="bg-accent hover:bg-accent-dark text-white font-bold px-6 py-3 rounded-r-md transition duration-300 sm:ml-0 ml-0">
                Subscribe
            </button>
        </form>
    </div>
</div>

<script>
    // FAQ Toggle Functionality
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const icon = button.querySelector('i');
            
            // Toggle content visibility
            content.classList.toggle('hidden');
            
            // Toggle icon rotation
            if (content.classList.contains('hidden')) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
