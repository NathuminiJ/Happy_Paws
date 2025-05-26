<?php
require_once __DIR__ . '/../../config/config.php';

$pageTitle = 'Frequently Asked Questions';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- FAQ Page -->
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
                    <span class="text-primary">FAQ</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h1>
        
        <!-- Search Bar -->
        <div class="mb-10">
            <div class="relative">
                <input type="text" id="faq-search" placeholder="Search for a question..." 
                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <div class="absolute left-4 top-3.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        
        <!-- FAQ Categories -->
        <div class="mb-10">
            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <button class="faq-category-btn active px-5 py-2 rounded-full bg-primary text-white font-medium" data-category="all">
                    All Questions
                </button>
                <button class="faq-category-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-primary hover:text-white transition" data-category="orders">
                    Orders & Shipping
                </button>
                <button class="faq-category-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-primary hover:text-white transition" data-category="products">
                    Products
                </button>
                <button class="faq-category-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-primary hover:text-white transition" data-category="returns">
                    Returns & Refunds
                </button>
                <button class="faq-category-btn px-5 py-2 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-primary hover:text-white transition" data-category="account">
                    Account & Privacy
                </button>
            </div>
        </div>
        
        <!-- FAQ Accordion -->
        <div class="space-y-4">
            <!-- Orders & Shipping -->
            <div class="faq-item" data-category="orders">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-1">
                        <span class="text-lg font-medium text-gray-800">How long does shipping take?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-1" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Standard shipping typically takes 3-5 business days within the continental US. Expedited shipping (2-day) and overnight options are also available at checkout for an additional fee.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="orders">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-2">
                        <span class="text-lg font-medium text-gray-800">What are your shipping rates?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-2" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">We offer free standard shipping on all orders over $50. For orders under $50, a flat shipping rate of $5.99 applies. Expedited shipping options are available at varying rates based on location and package weight.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="orders">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-3">
                        <span class="text-lg font-medium text-gray-800">Do you ship internationally?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-3" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Yes, we ship to most countries worldwide. International shipping rates and delivery times vary depending on the destination. Please note that customers are responsible for any customs fees, import taxes, or duties that may apply.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="orders">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-4">
                        <span class="text-lg font-medium text-gray-800">How can I track my order?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-4" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Once your order ships, you'll receive a confirmation email with a tracking number. You can track your package by clicking the tracking link in the email or by logging into your account and viewing your order history.</p>
                    </div>
                </div>
            </div>
            
            <!-- Products -->
            <div class="faq-item" data-category="products">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-5">
                        <span class="text-lg font-medium text-gray-800">Are your products cruelty-free?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-5" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Yes, all products sold at BeautyShop are cruelty-free. We do not carry brands that test on animals or sell in markets where animal testing is required by law. We're committed to ethical beauty practices.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="products">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-6">
                        <span class="text-lg font-medium text-gray-800">Do you offer samples with purchases?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-6" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Yes! Orders over $25 receive one free sample, orders over $50 receive two free samples, and orders over $100 receive three free samples. You can select your preferred samples during checkout, subject to availability.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="products">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-7">
                        <span class="text-lg font-medium text-gray-800">How do I know which products are right for my skin type?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-7" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Each product page includes detailed information about which skin types the product is suitable for. You can also use our "Find Your Match" tool on the website, which recommends products based on your skin concerns and preferences. For personalized recommendations, feel free to contact our beauty advisors.</p>
                    </div>
                </div>
            </div>
            
            <!-- Returns & Refunds -->
            <div class="faq-item" data-category="returns">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-8">
                        <span class="text-lg font-medium text-gray-800">What is your return policy?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-8" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">We offer a 30-day satisfaction guarantee on most products. If you're not completely satisfied with your purchase, you can return it within 30 days of delivery for a full refund or exchange. The product must be in its original condition and packaging. Please note that certain items, such as opened cosmetics, cannot be returned for hygiene reasons.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="returns">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-9">
                        <span class="text-lg font-medium text-gray-800">How do I initiate a return?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-9" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">To initiate a return, log into your account, go to your order history, and select the order containing the item(s) you wish to return. Click on "Return Items" and follow the instructions. You'll receive a return shipping label via email. Once we receive and inspect your return, we'll process your refund or exchange.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="returns">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-10">
                        <span class="text-lg font-medium text-gray-800">How long does it take to process a refund?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-10" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Once we receive your return, it typically takes 3-5 business days to inspect and process. After processing, refunds are issued to your original payment method. Credit card refunds may take an additional 3-7 business days to appear on your statement, depending on your bank.</p>
                    </div>
                </div>
            </div>
            
            <!-- Account & Privacy -->
            <div class="faq-item" data-category="account">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-11">
                        <span class="text-lg font-medium text-gray-800">How do I create an account?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-11" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">To create an account, click on the "Account" icon in the top right corner of our website and select "Register." Fill in your information, create a password, and submit the form. You'll receive a confirmation email to verify your account. Having an account allows you to track orders, save favorites, and check out faster.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="account">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-12">
                        <span class="text-lg font-medium text-gray-800">How is my personal information protected?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-12" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">We take your privacy seriously. Our website uses SSL encryption to protect your personal information during transmission. We never sell your data to third parties and only collect information necessary to process your orders and improve your shopping experience. For more details, please review our Privacy Policy.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item" data-category="account">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button class="faq-toggle flex justify-between items-center w-full px-6 py-4 text-left" data-target="faq-13">
                        <span class="text-lg font-medium text-gray-800">Can I change my account information?</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform"></i>
                    </button>
                    <div id="faq-13" class="faq-content px-6 pb-4 hidden">
                        <p class="text-gray-600">Yes, you can update your account information at any time. Log into your account, go to "Account Settings," and you can modify your name, email, password, shipping addresses, and payment methods. Make sure to click "Save Changes" after making any updates.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Still Have Questions -->
        <div class="mt-16 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Still Have Questions?</h2>
            <p class="text-gray-600 mb-6">We're here to help! Contact our customer support team for assistance.</p>
            <a href="<?php echo SITE_URL; ?>/pages/user/contact.php" class="inline-block bg-primary hover:bg-primary-dark text-white font-bold py-3 px-8 rounded-md transition duration-300">
                Contact Us
            </a>
        </div>
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
    
    // Category Filter
    document.querySelectorAll('.faq-category-btn').forEach(button => {
        button.addEventListener('click', () => {
            // Update active button styling
            document.querySelectorAll('.faq-category-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-primary', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            
            button.classList.add('active', 'bg-primary', 'text-white');
            button.classList.remove('bg-gray-200', 'text-gray-700');
            
            const category = button.getAttribute('data-category');
            
            // Show/hide FAQ items based on category
            document.querySelectorAll('.faq-item').forEach(item => {
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Search Functionality
    const searchInput = document.getElementById('faq-search');
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        
        document.querySelectorAll('.faq-toggle').forEach(question => {
            const questionText = question.querySelector('span').textContent.toLowerCase();
            const faqItem = question.closest('.faq-item');
            
            if (questionText.includes(searchTerm)) {
                faqItem.style.display = 'block';
            } else {
                faqItem.style.display = 'none';
            }
        });
        
        // If search is empty, respect category filters
        if (searchTerm === '') {
            const activeCategory = document.querySelector('.faq-category-btn.active').getAttribute('data-category');
            
            document.querySelectorAll('.faq-item').forEach(item => {
                if (activeCategory === 'all' || item.getAttribute('data-category') === activeCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
