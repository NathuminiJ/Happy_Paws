<?php
require_once __DIR__ . '/../../config/config.php';

$pageTitle = 'Privacy Policy';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Privacy Policy Page -->
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
                    <span class="text-primary">Privacy Policy</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Privacy Policy</h1>
        <p class="text-gray-600 mb-6">Last Updated: <?php echo date('F d, Y'); ?></p>
        
        <div class="prose max-w-none text-gray-600">
            <p class="mb-4">
                At BeautyShop, we respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Information We Collect</h2>
            
            <h3 class="text-lg font-medium text-gray-800 mt-6 mb-2">Personal Information</h3>
            <p class="mb-4">
                We may collect personal information that you voluntarily provide to us when you:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>Create an account</li>
                <li>Make a purchase</li>
                <li>Sign up for our newsletter</li>
                <li>Contact our customer service</li>
                <li>Participate in promotions or surveys</li>
                <li>Leave product reviews</li>
            </ul>
            <p class="mb-4">
                This information may include:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>Name</li>
                <li>Email address</li>
                <li>Mailing address</li>
                <li>Phone number</li>
                <li>Payment information</li>
                <li>Purchase history</li>
            </ul>
            
            <h3 class="text-lg font-medium text-gray-800 mt-6 mb-2">Automatically Collected Information</h3>
            <p class="mb-4">
                When you visit our website, we may automatically collect certain information about your device, including:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>IP address</li>
                <li>Browser type</li>
                <li>Operating system</li>
                <li>Pages visited</li>
                <li>Time and date of your visit</li>
                <li>Referring website</li>
                <li>Other browsing statistics</li>
            </ul>
            <p class="mb-4">
                This information is collected using cookies, web beacons, and similar technologies. For more information about our use of cookies, please see our Cookie Policy.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">How We Use Your Information</h2>
            <p class="mb-4">
                We may use the information we collect for various purposes, including:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>Processing and fulfilling your orders</li>
                <li>Creating and managing your account</li>
                <li>Providing customer support</li>
                <li>Sending transactional emails (order confirmations, shipping updates)</li>
                <li>Sending marketing communications (if you've opted in)</li>
                <li>Improving our website and products</li>
                <li>Analyzing usage patterns and trends</li>
                <li>Preventing fraudulent transactions</li>
                <li>Complying with legal obligations</li>
            </ul>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">How We Share Your Information</h2>
            <p class="mb-4">
                We may share your information with:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li><strong>Service Providers:</strong> Third-party vendors who help us operate our business (payment processors, shipping companies, marketing partners)</li>
                <li><strong>Business Partners:</strong> Trusted partners who help us offer products or services</li>
                <li><strong>Legal Requirements:</strong> When required by law, court order, or governmental authority</li>
                <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
            </ul>
            <p class="mb-4">
                We do not sell your personal information to third parties.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Data Security</h2>
            <p class="mb-4">
                We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. These measures include:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>SSL encryption for all data transmissions</li>
                <li>Secure storage of personal information</li>
                <li>Regular security assessments</li>
                <li>Limited access to personal information by employees</li>
            </ul>
            <p class="mb-4">
                However, no method of transmission over the Internet or electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your personal information, we cannot guarantee its absolute security.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Your Rights</h2>
            <p class="mb-4">
                Depending on your location, you may have certain rights regarding your personal information, including:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li><strong>Access:</strong> The right to request copies of your personal information</li>
                <li><strong>Rectification:</strong> The right to request that we correct inaccurate information</li>
                <li><strong>Erasure:</strong> The right to request that we delete your personal information</li>
                <li><strong>Restriction:</strong> The right to request that we restrict the processing of your information</li>
                <li><strong>Data Portability:</strong> The right to request that we transfer your information to another organization</li>
                <li><strong>Objection:</strong> The right to object to our processing of your information</li>
            </ul>
            <p class="mb-4">
                To exercise any of these rights, please contact us using the information provided at the end of this policy.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Children's Privacy</h2>
            <p class="mb-4">
                Our website is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us immediately.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Changes to This Privacy Policy</h2>
            <p class="mb-4">
                We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date. You are advised to review this Privacy Policy periodically for any changes.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Contact Us</h2>
            <p class="mb-4">
                If you have any questions about this Privacy Policy, please contact us at:
            </p>
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p><strong>BeautyShop</strong></p>
                <p>123 Beauty Street</p>
                <p>Cosmetic City, BC 12345</p>
                <p>Email: privacy@beautyshop.com</p>
                <p>Phone: +1 (123) 456-7890</p>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
