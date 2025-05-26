<?php
require_once __DIR__ . '/../../config/config.php';

$pageTitle = 'Shipping Policy';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Shipping Policy Page -->
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
                    <span class="text-primary">Shipping Policy</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Shipping Policy</h1>
        <p class="text-gray-600 mb-6">Last Updated: <?php echo date('F d, Y'); ?></p>
        
        <div class="prose max-w-none text-gray-600">
            <p class="mb-4">
                At BeautyShop, we strive to provide you with the best possible shipping experience. This policy outlines our shipping procedures, delivery timeframes, and related information to ensure transparency and set appropriate expectations.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Shipping Methods & Timeframes</h2>
            
            <h3 class="text-lg font-medium text-gray-800 mt-6 mb-2">Domestic Shipping (United States)</h3>
            
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 border-b text-left font-semibold text-gray-700">Shipping Method</th>
                            <th class="py-3 px-4 border-b text-left font-semibold text-gray-700">Estimated Delivery Time</th>
                            <th class="py-3 px-4 border-b text-left font-semibold text-gray-700">Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-3 px-4 border-b">Standard Shipping</td>
                            <td class="py-3 px-4 border-b">3-5 business days</td>
                            <td class="py-3 px-4 border-b">$5.99 (Free for orders over $50)</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-3 px-4 border-b">Expedited Shipping</td>
                            <td class="py-3 px-4 border-b">2 business days</td>
                            <td class="py-3 px-4 border-b">$12.99</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 border-b">Overnight Shipping</td>
                            <td class="py-3 px-4 border-b">1 business day</td>
                            <td class="py-3 px-4 border-b">$19.99</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <p class="mb-4">
                <strong>Business days</strong> are Monday through Friday, excluding federal holidays. Orders placed after 1:00 PM EST may not be processed until the following business day.
            </p>
            
            <h3 class="text-lg font-medium text-gray-800 mt-6 mb-2">International Shipping</h3>
            
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 border-b text-left font-semibold text-gray-700">Region</th>
                            <th class="py-3 px-4 border-b text-left font-semibold text-gray-700">Estimated Delivery Time</th>
                            <th class="py-3 px-4 border-b text-left font-semibold text-gray-700">Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-3 px-4 border-b">Canada & Mexico</td>
                            <td class="py-3 px-4 border-b">5-10 business days</td>
                            <td class="py-3 px-4 border-b">$15.99 (Free for orders over $100)</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-3 px-4 border-b">Europe</td>
                            <td class="py-3 px-4 border-b">7-14 business days</td>
                            <td class="py-3 px-4 border-b">$24.99 (Free for orders over $150)</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 border-b">Asia & Australia</td>
                            <td class="py-3 px-4 border-b">10-21 business days</td>
                            <td class="py-3 px-4 border-b">$29.99 (Free for orders over $200)</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-3 px-4 border-b">Rest of World</td>
                            <td class="py-3 px-4 border-b">14-30 business days</td>
                            <td class="py-3 px-4 border-b">$34.99 (Free for orders over $250)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <p class="mb-4">
                <strong>Important:</strong> International delivery times are estimates and may vary due to customs processing, local postal service conditions, and other factors beyond our control.
            </p>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            International customers are responsible for all duties, import taxes, and customs fees. These charges are not included in your order total and will be collected by the delivery carrier or local customs office.
                        </p>
                    </div>
                </div>
            </div>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Order Processing</h2>
            
            <p class="mb-4">
                Orders are typically processed within 1-2 business days after payment confirmation. During high-volume periods (such as holidays or special promotions), processing may take up to 3 business days.
            </p>
            
            <p class="mb-4">
                You will receive an email confirmation when your order has been processed and another notification with tracking information once your package has shipped.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Tracking Your Order</h2>
            
            <p class="mb-4">
                All shipments include tracking information that will be emailed to you once your order ships. You can also track your order by:
            </p>
            
            <ul class="list-disc pl-8 mb-4">
                <li>Logging into your BeautyShop account and viewing your order history</li>
                <li>Clicking the tracking link in your shipping confirmation email</li>
                <li>Contacting our customer service team with your order number</li>
            </ul>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Shipping Restrictions</h2>
            
            <p class="mb-4">
                Due to regulations regarding certain beauty products, we cannot ship the following items to all locations:
            </p>
            
            <ul class="list-disc pl-8 mb-4">
                <li>Aerosol products</li>
                <li>Products containing high concentrations of alcohol</li>
                <li>Certain chemical peels and treatments</li>
            </ul>
            
            <p class="mb-4">
                If you attempt to order a restricted item for delivery to a location where we cannot ship it, we will notify you and provide options for modifying your order.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Shipping Address Requirements</h2>
            
            <p class="mb-4">
                To ensure successful delivery, please provide:
            </p>
            
            <ul class="list-disc pl-8 mb-4">
                <li>Complete street address (including apartment/suite numbers)</li>
                <li>City, state/province, and postal code</li>
                <li>Valid phone number for delivery questions</li>
                <li>Special delivery instructions if needed</li>
            </ul>
            
            <p class="mb-4">
                We cannot ship to P.O. boxes for expedited or overnight shipping methods.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Delivery Issues</h2>
            
            <h3 class="text-lg font-medium text-gray-800 mt-6 mb-2">Lost or Missing Packages</h3>
            
            <p class="mb-4">
                If your tracking information shows that your package was delivered but you haven't received it:
            </p>
            
            <ol class="list-decimal pl-8 mb-4">
                <li>Check with neighbors or others at your address who may have accepted the package</li>
                <li>Look around the delivery location for packages placed in a secure spot</li>
                <li>Contact the carrier with your tracking number to confirm the delivery location</li>
                <li>If you still cannot locate your package, contact our customer service within 7 days of the indicated delivery date</li>
            </ol>
            
            <h3 class="text-lg font-medium text-gray-800 mt-6 mb-2">Damaged Packages</h3>
            
            <p class="mb-4">
                If your package arrives damaged:
            </p>
            
            <ol class="list-decimal pl-8 mb-4">
                <li>Take photos of the damaged packaging and products</li>
                <li>Contact our customer service team within 48 hours of delivery</li>
                <li>Do not discard the damaged items or packaging until the claim is resolved</li>
            </ol>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Changes to Your Order</h2>
            
            <p class="mb-4">
                If you need to make changes to your shipping address or order details:
            </p>
            
            <ul class="list-disc pl-8 mb-4">
                <li>Contact us as soon as possible via email or phone</li>
                <li>We can only make changes if your order has not yet been processed</li>
                <li>Once an order has shipped, we cannot modify the shipping address</li>
            </ul>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Contact Us</h2>
            
            <p class="mb-4">
                If you have any questions about our shipping policy or need assistance with a specific order, please contact our customer service team:
            </p>
            
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p><strong>Customer Service</strong></p>
                <p>Email: shipping@beautyshop.com</p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Hours: Monday-Friday, 9:00 AM - 6:00 PM EST</p>
            </div>
            
            <p class="mt-8 text-sm text-gray-500">
                This shipping policy was last updated on <?php echo date('F d, Y'); ?> and is subject to change. Any modifications will be posted on this page.
            </p>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
