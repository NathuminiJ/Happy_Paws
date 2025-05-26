<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Get featured products 
$featuredProducts = getAllProducts(8);

// Get categories
$categories = getAllCategories();

$pageTitle = 'Home';
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Custom CSS for Home Page -->
<style>
    .old-school-hero {
        background-color: #F5F5DC;
        border: 3px solid #A0522D;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.3);
        padding: 20px;
        font-family: 'Courier New', Courier, monospace;
    }
    
    .old-school-title {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        color: #8B4513;
        text-shadow: 2px 2px 3px rgba(0,0,0,0.2);
        letter-spacing: 1px;
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
        text-align: center;
    }
    
    .old-school-button:hover {
        background-color: #C6A47F;
        transform: translateY(-2px);
        box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    }
    
    .old-school-secondary-button {
        background-color: #F5F5DC;
        color: #8B4513;
        border: 2px solid #A0522D;
        padding: 0.5rem 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Courier New', Courier, monospace;
        text-align: center;
    }
    
    .old-school-secondary-button:hover {
        background-color: #DEB887;
        transform: translateY(-2px);
        box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    }
    
    .old-school-image {
        border: 3px solid #A0522D;
        padding: 5px;
        background-color: white;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        transform: rotate(-2deg);
    }
    
    .old-school-section-title {
        text-align: center;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        color: #8B4513;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        letter-spacing: 2px;
        border-bottom: 2px solid #A0522D;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
</style>

<!-- Hero Section -->
<section class="relative py-12 md:py-16">
    <div class="container mx-auto px-4">
        <div class="old-school-hero flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 md:pr-12 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl old-school-title mb-4">Quality Pet Supplies for Your Furry Friends</h1>
                <div class="border-t-2 border-b-2 border-oldschool-border py-4 my-4">
                    <p class="text-lg text-oldschool-text mb-6">Discover premium pet food, toys, and accessories that will keep your pets happy, healthy, and thriving.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="old-school-button py-3 px-6">
                        >> Shop Now <<
                    </a>
                    <a href="<?php echo SITE_URL; ?>/pages/user/who-am-i.php" class="old-school-secondary-button py-3 px-6">
                        >> Learn More <<
                    </a>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="C:\XAMPP\htdocs\e\assets\images\products\6831f7fdf1c09_1748105213.jpg" alt="Pet Supplies" class="old-school-image w-full">
                <div class="text-center mt-2 text-sm text-oldschool-text italic">"Quality products for your beloved pets"</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="old-school-section-title text-3xl mb-8">Shop by Category</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <?php foreach ($categories as $category): ?>
            <a href="<?php echo SITE_URL; ?>/pages/user/products.php?category=<?php echo $category['slug']; ?>" class="group">
                <div class="bg-white old-border p-6 text-center transition-transform transform group-hover:scale-105 hover:bg-oldschool-bg">
                    <?php
                    $iconClass = '';
                    switch ($category['slug']) {
                        case 'dog-supplies':
                            $iconClass = 'fa-dog';
                            break;
                        case 'cat-supplies':
                            $iconClass = 'fa-cat';
                            break;
                        case 'small-pet-supplies':
                            $iconClass = 'fa-rabbit';
                            break;
                        case 'fish-supplies':
                            $iconClass = 'fa-fish';
                            break;
                        case 'pet-food':
                            $iconClass = 'fa-bowl-food';
                            break;
                        default:
                            $iconClass = 'fa-paw';
                    }
                    ?>
                    <div class="bg-oldschool-bg w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 border-2 border-oldschool-border">
                        <i class="fas <?php echo $iconClass; ?> text-4xl text-primary"></i>
                    </div>
                    <h3 class="text-lg font-bold text-oldschool-text border-t border-oldschool-border pt-2"><?php echo $category['name']; ?></h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="old-school-section-title text-3xl">Featured Products</h2>
            <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="old-school-secondary-button px-4 py-2">
                >> View All <<
            </a>
        </div>
        
        <?php if (empty($featuredProducts)): ?>
        <div class="text-center py-8 old-border bg-white p-6">
            <p class="text-lg text-oldschool-text">No products available yet. Check back soon!</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="bg-white old-border overflow-hidden transition-transform transform hover:scale-105">
                <div class="text-center bg-oldschool-bg border-b-2 border-oldschool-border py-2">
                    <span class="text-sm font-bold text-oldschool-text uppercase"><?php echo $product['category_name']; ?></span>
                </div>
                <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $product['slug']; ?>">
                    <img src="<?php echo !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/300x300?text=Product+Image'; ?>" 
                         alt="<?php echo $product['name']; ?>" 
                         class="w-full h-64 object-cover p-2">
                </a>
                <div class="p-4">
                    <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $product['slug']; ?>" class="block">
                        <h3 class="text-lg font-bold text-oldschool-text mt-1 hover:text-primary transition border-b border-oldschool-border pb-2"><?php echo $product['name']; ?></h3>
                    </a>
                    <div class="mt-3 flex justify-between items-center border-b border-oldschool-border pb-3">
                        <div>
                            <?php if (!empty($product['sale_price'])): ?>
                            <span class="text-oldschool-text line-through">$<?php echo number_format($product['price'], 2); ?></span>
                            <span class="text-lg font-bold text-primary ml-1">$<?php echo number_format($product['sale_price'], 2); ?></span>
                            <?php else: ?>
                            <span class="text-lg font-bold text-oldschool-text">$<?php echo number_format($product['price'], 2); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center">
                            <div class="text-primary flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-xs text-oldschool-text ml-1">(4.5)</span>
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST" class="flex-grow">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full old-school-button py-2 px-4">
                                <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                            </button>
                        </form>
                        <button class="bg-oldschool-bg border-2 border-oldschool-border text-oldschool-text p-2 hover:bg-oldschool-highlight transition duration-300">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="old-border bg-white p-6">
            <h2 class="old-school-section-title text-3xl mb-8">Why Choose Happy Paws</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center old-border bg-oldschool-bg p-4">
                    <div class="bg-white w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 border-2 border-oldschool-border">
                        <i class="fas fa-truck text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-oldschool-text mb-2 border-b border-oldschool-border pb-2">Free Shipping</h3>
                    <p class="text-oldschool-text">Free shipping on all orders over $50</p>
                </div>
                
                <div class="text-center old-border bg-oldschool-bg p-4">
                    <div class="bg-white w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 border-2 border-oldschool-border">
                        <i class="fas fa-medal text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-oldschool-text mb-2 border-b border-oldschool-border pb-2">Premium Quality</h3>
                    <p class="text-oldschool-text">Only the best products for your pets</p>
                </div>
                
                <div class="text-center old-border bg-oldschool-bg p-4">
                    <div class="bg-white w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 border-2 border-oldschool-border">
                        <i class="fas fa-shield-alt text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-oldschool-text mb-2 border-b border-oldschool-border pb-2">Secure Payment</h3>
                    <p class="text-oldschool-text">100% secure payment processing</p>
                </div>
                
                <div class="text-center old-border bg-oldschool-bg p-4">
                    <div class="bg-white w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4 border-2 border-oldschool-border">
                        <i class="fas fa-heart text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-oldschool-text mb-2 border-b border-oldschool-border pb-2">Pet Experts</h3>
                    <p class="text-oldschool-text">Dedicated team of pet lovers</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="old-school-section-title text-3xl mb-8">What Our Customers Say</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white old-border p-6 transform rotate-1">
                <div class="flex items-center mb-4 border-b-2 border-oldschool-border pb-3">
                    <img src="https://via.placeholder.com/60x60?text=User" alt="Customer" class="w-12 h-12 border-2 border-oldschool-border p-1 mr-4">
                    <div>
                        <h4 class="font-bold text-oldschool-text">Sarah Johnson</h4>
                        <div class="text-primary flex">
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                        </div>
                    </div>
                </div>
                <p class="text-oldschool-text italic font-courier">&quot;I've been shopping at Happy Paws for over a year now, and my dog absolutely loves their treats and toys. The quality is exceptional, and the customer service is always friendly and helpful.&quot;</p>
                <div class="text-right text-xs text-oldschool-text mt-3 font-bold">- Dog Owner since 2020</div>
            </div>
            
            <div class="bg-white old-border p-6 transform -rotate-1">
                <div class="flex items-center mb-4 border-b-2 border-oldschool-border pb-3">
                    <img src="https://via.placeholder.com/60x60?text=User" alt="Customer" class="w-12 h-12 border-2 border-oldschool-border p-1 mr-4">
                    <div>
                        <h4 class="font-bold text-oldschool-text">Michael Chen</h4>
                        <div class="text-primary flex">
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p class="text-oldschool-text italic font-courier">&quot;The variety of products available at Happy Paws is impressive. I've found everything I need for my cat, from premium food to fun toys. Fast shipping and great prices too!&quot;</p>
                <div class="text-right text-xs text-oldschool-text mt-3 font-bold">- Cat Owner since 2018</div>
            </div>
            
            <div class="bg-white old-border p-6 transform rotate-1">
                <div class="flex items-center mb-4 border-b-2 border-oldschool-border pb-3">
                    <img src="https://via.placeholder.com/60x60?text=User" alt="Customer" class="w-12 h-12 border-2 border-oldschool-border p-1 mr-4">
                    <div>
                        <h4 class="font-bold text-oldschool-text">Emily Rodriguez</h4>
                        <div class="text-primary flex">
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                            <i class="fas fa-paw"></i>
                        </div>
                    </div>
                </div>
                <p class="text-oldschool-text italic font-courier">&quot;I recently adopted a puppy and was overwhelmed with all the supplies I needed. The team at Happy Paws guided me through everything and helped me choose the best products. My puppy and I couldn't be happier!&quot;</p>
                <div class="text-right text-xs text-oldschool-text mt-3 font-bold">- New Puppy Owner</div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="#" class="inline-block old-school-button py-3 px-6">
                >> Read More Reviews <<
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-12 bg-primary">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-6 md:mb-0">
                <h2 class="text-3xl font-bold text-white mb-2">Subscribe to Our Newsletter</h2>
                <p class="text-white opacity-90">Get the latest updates, offers and beauty tips delivered to your inbox.</p>
            </div>
            <div class="md:w-1/2">
                <form class="flex flex-col sm:flex-row">
                    <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-l-md focus:outline-none">
                    <button type="submit" class="bg-accent hover:bg-accent-dark text-white font-bold px-6 py-3 rounded-r-md transition duration-300 mt-2 sm:mt-0">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
