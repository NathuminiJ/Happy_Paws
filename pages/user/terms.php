<?php
require_once __DIR__ . '/../../config/config.php';

$pageTitle = 'Terms and Conditions';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Terms and Conditions Page -->
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
                    <span class="text-primary">Terms and Conditions</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Terms and Conditions</h1>
        <p class="text-gray-600 mb-6">Last Updated: <?php echo date('F d, Y'); ?></p>
        
        <div class="prose max-w-none text-gray-600">
            <p class="mb-4">
                Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the BeautyShop website (the "Service") operated by BeautyShop ("us", "we", or "our").
            </p>
            
            <p class="mb-4">
                Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users, and others who access or use the Service.
            </p>
            
            <p class="mb-6">
                By accessing or using the Service, you agree to be bound by these Terms. If you disagree with any part of the terms, then you may not access the Service.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">1. Purchases</h2>
            
            <p class="mb-4">
                If you wish to purchase any product or service made available through the Service ("Purchase"), you may be asked to supply certain information relevant to your Purchase including, without limitation, your name, shipping address, billing address, credit card information, and other personal information.
            </p>
            
            <p class="mb-4">
                You represent and warrant that: (i) you have the legal right to use any credit card(s) or other payment method(s) in connection with any Purchase; and that (ii) the information you supply to us is true, correct, and complete.
            </p>
            
            <p class="mb-4">
                By submitting such information, you grant us the right to provide the information to third parties for purposes of facilitating the completion of Purchases.
            </p>
            
            <p class="mb-4">
                We reserve the right to refuse or cancel your order at any time for certain reasons including but not limited to: product or service availability, errors in the description or price of the product or service, error in your order or other reasons.
            </p>
            
            <p class="mb-4">
                We reserve the right to refuse or cancel your order if fraud or an unauthorized or illegal transaction is suspected.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">2. Product Information</h2>
            
            <p class="mb-4">
                We strive to provide accurate product descriptions, pricing, and availability information. However, we do not warrant that product descriptions, pricing, or other content on the Service is accurate, complete, reliable, current, or error-free.
            </p>
            
            <p class="mb-4">
                The inclusion of any products or services on the Service at a particular time does not imply or warrant that these products or services will be available at any time.
            </p>
            
            <p class="mb-4">
                We reserve the right to discontinue any product at any time. Any offer for any product or service made on this Service is void where prohibited.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">3. Shipping and Delivery</h2>
            
            <p class="mb-4">
                We will arrange for shipment of the products to you. Please check the individual product page for specific delivery options. You will pay all shipping and handling charges specified during the ordering process.
            </p>
            
            <p class="mb-4">
                Title and risk of loss pass to you upon our transfer of the products to the carrier. Shipping and delivery dates are estimates only and cannot be guaranteed. We are not liable for any delays in shipments.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">4. Returns and Refunds</h2>
            
            <p class="mb-4">
                We offer a 30-day satisfaction guarantee on most products. If you are not completely satisfied with your purchase, you can return it within 30 days of delivery for a full refund or exchange.
            </p>
            
            <p class="mb-4">
                To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging.
            </p>
            
            <p class="mb-4">
                Several types of goods are exempt from being returned. Perishable goods such as opened cosmetics, personal care items, and goods that are intimate or sanitary cannot be returned for hygiene reasons.
            </p>
            
            <p class="mb-4">
                To complete your return, we require a receipt or proof of purchase. Please do not send your purchase back to the manufacturer.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">5. User Accounts</h2>
            
            <p class="mb-4">
                When you create an account with us, you must provide information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.
            </p>
            
            <p class="mb-4">
                You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.
            </p>
            
            <p class="mb-4">
                You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">6. Intellectual Property</h2>
            
            <p class="mb-4">
                The Service and its original content, features, and functionality are and will remain the exclusive property of BeautyShop and its licensors. The Service is protected by copyright, trademark, and other laws of both the United States and foreign countries.
            </p>
            
            <p class="mb-4">
                Our trademarks and trade dress may not be used in connection with any product or service without the prior written consent of BeautyShop.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">7. User Content</h2>
            
            <p class="mb-4">
                Our Service allows you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material ("Content"). You are responsible for the Content that you post to the Service, including its legality, reliability, and appropriateness.
            </p>
            
            <p class="mb-4">
                By posting Content to the Service, you grant us the right and license to use, modify, perform, display, reproduce, and distribute such Content on and through the Service. You retain any and all of your rights to any Content you submit, post or display on or through the Service and you are responsible for protecting those rights.
            </p>
            
            <p class="mb-4">
                You represent and warrant that: (i) the Content is yours (you own it) or you have the right to use it and grant us the rights and license as provided in these Terms, and (ii) the posting of your Content on or through the Service does not violate the privacy rights, publicity rights, copyrights, contract rights or any other rights of any person.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">8. Links To Other Web Sites</h2>
            
            <p class="mb-4">
                Our Service may contain links to third-party web sites or services that are not owned or controlled by BeautyShop.
            </p>
            
            <p class="mb-4">
                BeautyShop has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that BeautyShop shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.
            </p>
            
            <p class="mb-4">
                We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">9. Termination</h2>
            
            <p class="mb-4">
                We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.
            </p>
            
            <p class="mb-4">
                Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">10. Limitation Of Liability</h2>
            
            <p class="mb-4">
                In no event shall BeautyShop, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from (i) your access to or use of or inability to access or use the Service; (ii) any conduct or content of any third party on the Service; (iii) any content obtained from the Service; and (iv) unauthorized access, use or alteration of your transmissions or content, whether based on warranty, contract, tort (including negligence) or any other legal theory, whether or not we have been informed of the possibility of such damage.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">11. Disclaimer</h2>
            
            <p class="mb-4">
                Your use of the Service is at your sole risk. The Service is provided on an "AS IS" and "AS AVAILABLE" basis. The Service is provided without warranties of any kind, whether express or implied, including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, non-infringement or course of performance.
            </p>
            
            <p class="mb-4">
                BeautyShop, its subsidiaries, affiliates, and its licensors do not warrant that a) the Service will function uninterrupted, secure or available at any particular time or location; b) any errors or defects will be corrected; c) the Service is free of viruses or other harmful components; or d) the results of using the Service will meet your requirements.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">12. Governing Law</h2>
            
            <p class="mb-4">
                These Terms shall be governed and construed in accordance with the laws of the United States, without regard to its conflict of law provisions.
            </p>
            
            <p class="mb-4">
                Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">13. Changes</h2>
            
            <p class="mb-4">
                We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.
            </p>
            
            <p class="mb-4">
                By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.
            </p>
            
            <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">14. Contact Us</h2>
            
            <p class="mb-4">
                If you have any questions about these Terms, please contact us at:
            </p>
            
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p><strong>BeautyShop</strong></p>
                <p>123 Beauty Street</p>
                <p>Cosmetic City, BC 12345</p>
                <p>Email: legal@beautyshop.com</p>
                <p>Phone: +1 (123) 456-7890</p>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
