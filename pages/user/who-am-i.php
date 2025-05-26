<?php
require_once __DIR__ . '/../../config/config.php';

// Process contact form submission
$formSubmitted = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
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

$pageTitle = 'Who Am I';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Custom CSS for old-school style -->
<style>
    .old-school-container {
        font-family: 'Courier New', Courier, monospace;
        background-image: url('https://www.transparenttextures.com/patterns/paper.png');
        background-color: #F5F5DC;
        padding: 20px;
    }
    
    .old-school-border {
        border: 2px solid #A0522D;
        box-shadow: 3px 3px 5px rgba(0,0,0,0.3);
        padding: 20px;
        background-color: #FFF;
    }
    
    .old-school-title {
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        letter-spacing: 2px;
        font-weight: bold;
        color: #8B4513;
        text-align: center;
        border-bottom: 2px solid #A0522D;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .old-school-input {
        border: 1px solid #A0522D;
        background-color: #F8F4E3;
        font-family: 'Courier New', Courier, monospace;
        padding: 8px 12px;
        width: 100%;
    }
    
    .old-school-input:focus {
        outline: 2px solid #CD853F;
        background-color: #FFF;
    }
    
    .old-school-button {
        background-color: #D2B48C;
        color: #654321;
        border: 2px solid #A0522D;
        padding: 0.5rem 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Courier New', Courier, monospace;
    }
    
    .old-school-button:hover {
        background-color: #C6A47F;
        transform: translateY(-2px);
        box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    }
    
    .old-school-error {
        background-color: #F8D7DA;
        border: 2px dashed #A0522D;
        padding: 10px;
        font-family: 'Courier New', Courier, monospace;
        margin-bottom: 20px;
    }
    
    .old-school-success {
        background-color: #D4EDDA;
        border: 2px dashed #A0522D;
        padding: 10px;
        font-family: 'Courier New', Courier, monospace;
        margin-bottom: 20px;
    }
    
    .old-school-section {
        margin-bottom: 30px;
    }
    
    .old-school-image {
        border: 3px solid #A0522D;
        padding: 5px;
        background-color: white;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        transform: rotate(-2deg);
        max-width: 100%;
    }
    
    .old-school-image-right {
        transform: rotate(2deg);
    }
    
    .old-school-polaroid {
        background: white;
        padding: 10px 10px 30px 10px;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        transform: rotate(-2deg);
        max-width: 100%;
        margin-bottom: 20px;
    }
    
    .old-school-polaroid p {
        text-align: center;
        font-family: 'Comic Sans MS', cursive;
        margin-top: 10px;
        color: #654321;
    }
    
    .old-school-list {
        list-style-type: none;
        padding-left: 0;
    }
    
    .old-school-list li {
        margin-bottom: 15px;
        padding-left: 30px;
        position: relative;
    }
    
    .old-school-list li:before {
        content: "→";
        position: absolute;
        left: 0;
        color: #8B4513;
        font-weight: bold;
    }
    
    .typewriter-text {
        overflow: hidden;
        border-right: .15em solid #8B4513;
        white-space: nowrap;
        margin: 0 auto;
        letter-spacing: .15em;
        animation: 
            typing 3.5s steps(40, end),
            blink-caret .75s step-end infinite;
    }
    
    @keyframes typing {
        from { width: 0 }
        to { width: 100% }
    }
    
    @keyframes blink-caret {
        from, to { border-color: transparent }
        50% { border-color: #8B4513; }
    }
</style>

<!-- Who Am I Page -->
<div class="container mx-auto px-4 py-8 old-school-container">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo SITE_URL; ?>" class="text-primary hover:text-accent transition">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-primary">Who Are We</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="old-school-border mb-8">
        <h1 class="old-school-title text-3xl">Who Are We</h1>
        <div class="typewriter-text text-center text-lg mb-6">Welcome to Happy Paws!</div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <div class="old-school-polaroid">
                    <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Pet Shop Owner" class="w-full">
                    <p>Max & Bella - My Inspiration</p>
                </div>
                <p class="text-oldschool-text mb-4">
                    Greetings, fellow pet lovers! I'm Charlie Thompson, the proud owner of Happy Paws. 
                    My journey into the world of pet supplies began with my two furry companions, 
                    Max (a Golden Retriever) and Bella (a Maine Coon cat).
                </p>
            </div>
            <div>
                <h2 class="text-xl font-bold text-primary mb-4 border-b border-primary pb-2">My Story</h2>
                <p class="text-oldschool-text mb-4">
                    After spending 15 years working in corporate retail, I decided to follow my passion 
                    for animals and create a store that truly caters to pet owners who consider their 
                    pets as family members.
                </p>
                <p class="text-oldschool-text mb-4">
                    Happy Paws was established in 2010 with a simple mission: to provide high-quality 
                    pet supplies that are safe, effective, and bring joy to both pets and their owners.
                </p>
                <p class="text-oldschool-text">
                    What started as a small corner shop has grown into a beloved local business, 
                    but we've maintained our commitment to personalized service and carefully 
                    selected products.
                </p>
            </div>
        </div>
        
        <div class="old-school-section">
            <h2 class="text-xl font-bold text-primary mb-4 border-b border-primary pb-2">Our Philosophy</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="old-school-border">
                    <h3 class="text-lg font-bold text-accent mb-2 text-center">Quality First</h3>
                    <p class="text-oldschool-text">
                        We personally test and evaluate every product we sell. If it's not good enough 
                        for our pets, it's not good enough for yours.
                    </p>
                </div>
                <div class="old-school-border">
                    <h3 class="text-lg font-bold text-accent mb-2 text-center">Community Focus</h3>
                    <p class="text-oldschool-text">
                        We believe in supporting local animal shelters and rescue organizations. 
                        A portion of every purchase goes to helping animals in need.
                    </p>
                </div>
                <div class="old-school-border">
                    <h3 class="text-lg font-bold text-accent mb-2 text-center">Education</h3>
                    <p class="text-oldschool-text">
                        We're committed to helping pet owners make informed decisions through 
                        workshops, newsletters, and one-on-one consultations.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="old-school-section">
            <h2 class="text-xl font-bold text-primary mb-4 border-b border-primary pb-2">What Sets Us Apart</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <ul class="old-school-list">
                        <li>Curated selection of premium pet supplies</li>
                        <li>Knowledgeable staff who are pet owners themselves</li>
                        <li>Regular community events and pet adoption days</li>
                        <li>Loyalty program with real benefits for your pets</li>
                        <li>Custom orders for special dietary needs</li>
                    </ul>
                </div>
                <div>
                    <div class="old-school-image-right old-school-polaroid">
                        <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Happy Pets" class="w-full">
                        <p>Our Happy Customers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contact Section -->
    <div class="old-school-border">
        <h2 class="old-school-title text-2xl">Get In Touch</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Contact Information -->
            <div>
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-primary mb-2 border-b border-primary pb-2">Store Information</h3>
                    <ul class="old-school-list">
                        <li><strong>Address:</strong> 123 Pet Avenue, Pawsville, PP 12345</li>
                        <li><strong>Phone:</strong> (555) 123-4567</li>
                        <li><strong>Email:</strong> woof@happypaws.com</li>
                        <li><strong>Hours:</strong><br>
                            Monday-Friday: 9am-6pm<br>
                            Saturday: 10am-5pm<br>
                            Sunday: 12pm-4pm
                        </li>
                    </ul>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-primary mb-2 border-b border-primary pb-2">Follow Us</h3>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-primary hover:text-accent transition">
                            <i class="fab fa-facebook-f text-2xl"></i>
                        </a>
                        <a href="#" class="text-primary hover:text-accent transition">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="text-primary hover:text-accent transition">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                        <a href="#" class="text-primary hover:text-accent transition">
                            <i class="fab fa-pinterest text-2xl"></i>
                        </a>
                    </div>
                </div>
                
                <div class="old-school-polaroid">
                    <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Store Front" class="w-full">
                    <p>Our Cozy Shop</p>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div>
                <h3 class="text-lg font-bold text-primary mb-4 border-b border-primary pb-2">Send Me a Message</h3>
                
                <?php if ($formSubmitted): ?>
                <div class="old-school-success">
                    <div class="flex items-center">
                        <i class="fas fa-paw mr-2 text-primary"></i>
                        <span class="text-oldschool-text font-bold">Thank you for your message! I'll get back to you soon.</span>
                    </div>
                </div>
                <?php else: ?>
                
                <?php if (!empty($errors)): ?>
                <div class="old-school-error">
                    <div class="text-center mb-2 font-bold text-oldschool-text">== ERROR ==</div>
                    <ul class="list-disc list-inside text-oldschool-text">
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <form action="<?php echo SITE_URL; ?>/pages/user/who-am-i.php" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-oldschool-text text-sm font-bold mb-2">Your Name:</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                               class="old-school-input">
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-oldschool-text text-sm font-bold mb-2">Your Email:</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                               class="old-school-input">
                    </div>
                    
                    <div class="mb-6">
                        <label for="message" class="block text-oldschool-text text-sm font-bold mb-2">Your Message:</label>
                        <textarea id="message" name="message" rows="6" 
                                  class="old-school-input"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="w-full old-school-button">
                        >> Send Message <<
                    </button>
                </form>
                <?php endif; ?>
                
                <div class="mt-8 p-4 border-t border-primary">
                    <p class="text-oldschool-text text-center italic">
                        "The greatness of a nation and its moral progress can be judged by the way its animals are treated." - Mahatma Gandhi
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple animation for the old-school elements
    document.addEventListener('DOMContentLoaded', function() {
        const polaroids = document.querySelectorAll('.old-school-polaroid');
        
        polaroids.forEach(polaroid => {
            polaroid.addEventListener('mouseover', function() {
                this.style.transform = 'rotate(0deg) scale(1.05)';
                this.style.transition = 'all 0.3s ease';
            });
            
            polaroid.addEventListener('mouseout', function() {
                if (this.classList.contains('old-school-image-right')) {
                    this.style.transform = 'rotate(2deg)';
                } else {
                    this.style.transform = 'rotate(-2deg)';
                }
                this.style.transition = 'all 0.3s ease';
            });
        });
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
