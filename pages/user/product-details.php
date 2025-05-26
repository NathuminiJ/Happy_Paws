<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/db_functions.php';

// Get product slug from URL
$productSlug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (empty($productSlug)) {
    setFlashMessage('error', 'Product not found');
    redirect(SITE_URL . '/pages/user/products.php');
}

// Get product details
$product = getProductBySlug($productSlug);

if (!$product) {
    setFlashMessage('error', 'Product not found');
    redirect(SITE_URL . '/pages/user/products.php');
}

// Get related products from the same category
$relatedProducts = getAllProducts(4, null);

$pageTitle = $product['name'];
include_once __DIR__ . '/../../components/header.php';
?>

<!-- Custom CSS for Product Details Page -->
<style>
    .old-product-image {
        border: 3px solid #A0522D;
        padding: 5px;
        background-color: white;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
    }
    
    .old-thumbnail {
        border: 2px solid #A0522D;
        padding: 3px;
        background-color: white;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .old-thumbnail:hover {
        transform: scale(1.05);
    }
    
    .old-thumbnail.active {
        border-color: #CD853F;
        transform: scale(1.05);
    }
    
    .old-tab {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        color: #654321;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
    }
    
    .old-tab:hover {
        color: #8B4513;
        border-bottom-color: #DEB887;
    }
    
    .old-tab.active {
        color: #8B4513;
        border-bottom-color: #8B4513;
    }
    
    .old-quantity-input {
        border: 1px solid #A0522D;
        background-color: #F8F4E3;
        font-family: 'Courier New', Courier, monospace;
        padding: 8px 12px;
        width: 60px;
        text-align: center;
    }
    
    .old-quantity-btn {
        background-color: #D2B48C;
        color: #654321;
        border: 2px solid #A0522D;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .old-quantity-btn:hover {
        background-color: #C6A47F;
    }
    
    .old-review {
        border-bottom: 1px dashed #A0522D;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    
    .old-badge {
        font-family: 'Courier New', Courier, monospace;
        background-color: #CD853F;
        color: white;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: bold;
        transform: rotate(5deg);
    }
</style>

<!-- Product Details Page -->
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 bg-white old-border p-3" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo SITE_URL; ?>" class="text-oldschool-text hover:text-primary transition">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-oldschool-text mx-2"></i>
                    <a href="<?php echo SITE_URL; ?>/pages/user/products.php" class="text-oldschool-text hover:text-primary transition">
                        Products
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-oldschool-text mx-2"></i>
                    <a href="<?php echo SITE_URL; ?>/pages/user/products.php?category=<?php echo $product['category_slug'] ?? ''; ?>" class="text-oldschool-text hover:text-primary transition">
                        <?php echo $product['category_name'] ?? 'Category'; ?>
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-oldschool-text mx-2"></i>
                    <span class="text-primary font-bold"><?php echo $product['name']; ?></span>
                </div>
            </li>
        </ol>
    </nav>
    
    <!-- Product Details -->
    <div class="bg-white old-border overflow-hidden mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
            <!-- Product Image -->
            <div class="flex flex-col">
                <div class="mb-4 bg-oldschool-bg p-2">
                    <img id="main-image" src="<?php echo !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/600x600?text=Product+Image'; ?>" 
                         alt="<?php echo $product['name']; ?>" 
                         class="w-full h-96 object-contain old-product-image">
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-oldschool-bg overflow-hidden old-thumbnail active">
                        <img src="<?php echo !empty($product['image']) ? $product['image'] : 'https://via.placeholder.com/150x150?text=Image+1'; ?>" 
                             alt="Thumbnail 1" 
                             class="w-full h-20 object-cover thumbnail-image">
                    </div>
                    <div class="bg-oldschool-bg overflow-hidden old-thumbnail">
                        <img src="https://via.placeholder.com/150x150?text=Image+2" 
                             alt="Thumbnail 2" 
                             class="w-full h-20 object-cover thumbnail-image">
                    </div>
                    <div class="bg-oldschool-bg overflow-hidden old-thumbnail">
                        <img src="https://via.placeholder.com/150x150?text=Image+3" 
                             alt="Thumbnail 3" 
                             class="w-full h-20 object-cover thumbnail-image">
                    </div>
                    <div class="bg-oldschool-bg overflow-hidden old-thumbnail">
                        <img src="https://via.placeholder.com/150x150?text=Image+4" 
                             alt="Thumbnail 4" 
                             class="w-full h-20 object-cover thumbnail-image">
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div>
                <span class="inline-block px-3 py-1 text-xs font-bold text-white bg-primary old-border mb-2 old-badge">
                    <?php echo $product['category_name'] ?? 'Category'; ?>
                </span>
                
                <h1 class="text-3xl font-bold text-oldschool-text mb-2 old-title font-courier"><?php echo $product['name']; ?></h1>
                
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-700">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-oldschool-text ml-2 font-courier">4.5 (24 reviews)</span>
                </div>
                
                <div class="mb-6">
                    <?php if (!empty($product['sale_price'])): ?>
                    <div class="flex items-center">
                        <span class="text-oldschool-text line-through text-xl font-courier">$<?php echo number_format($product['price'], 2); ?></span>
                        <span class="text-3xl font-bold text-primary ml-2 font-courier">$<?php echo number_format($product['sale_price'], 2); ?></span>
                        <?php 
                        $discount = round(($product['price'] - $product['sale_price']) / $product['price'] * 100);
                        ?>
                        <span class="ml-2 px-2 py-1 text-xs font-bold text-white bg-primary old-border old-badge">
                            <?php echo $discount; ?>% OFF
                        </span>
                    </div>
                    <?php else: ?>
                    <span class="text-3xl font-bold text-primary font-courier">$<?php echo number_format($product['price'], 2); ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="mb-6 bg-oldschool-bg p-4 old-border">
                    <p class="text-oldschool-text font-courier">
                        <?php echo nl2br($product['description']); ?>
                    </p>
                </div>
                
                <div class="mb-6 old-border p-3">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-check-circle text-primary mr-2"></i>
                        <span class="text-oldschool-text font-courier">In Stock: <?php echo $product['stock']; ?> available</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-truck text-primary mr-2"></i>
                        <span class="text-oldschool-text font-courier">Free shipping on orders over $50</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-undo text-primary mr-2"></i>
                        <span class="text-oldschool-text font-courier">30-day money-back guarantee</span>
                    </div>
                </div>
                
                <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="mb-6">
                        <label for="quantity" class="block text-oldschool-text font-medium mb-2 font-courier">Quantity</label>
                        <div class="flex items-center">
                            <button type="button" id="decrease-qty" class="old-quantity-btn rounded-l-md">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="old-quantity-input">
                            <button type="button" id="increase-qty" class="old-quantity-btn rounded-r-md">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-grow old-button py-3 px-6">
                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                        </button>
                        <button type="button" class="old-button py-3 px-4 bg-oldschool-bg text-oldschool-text">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 border-t border-dashed border-primary pt-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-oldschool-text font-courier mr-2">Share:</span>
                        <a href="#" class="text-oldschool-text hover:text-primary transition old-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-oldschool-text hover:text-primary transition old-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-oldschool-text hover:text-primary transition old-link">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                        <a href="#" class="text-oldschool-text hover:text-primary transition old-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="bg-white old-border overflow-hidden mb-12">
        <div class="border-b border-dashed border-primary">
            <nav class="flex -mb-px">
                <button id="tab-description" class="tab-button active py-4 px-6 text-center old-tab active">
                    Description
                </button>
                <button id="tab-additional" class="tab-button py-4 px-6 text-center old-tab">
                    Additional Information
                </button>
                <button id="tab-reviews" class="tab-button py-4 px-6 text-center old-tab">
                    Reviews (24)
                </button>
            </nav>
        </div>
        
        <div id="tab-content-description" class="tab-content p-6 block">
            <h3 class="text-xl font-bold text-oldschool-text mb-4 old-title font-courier">Product Description</h3>
            <div class="prose max-w-none bg-oldschool-bg p-4 old-border">
                <p class="font-courier text-oldschool-text"><?php echo nl2br($product['description']); ?></p>
                
                <p class="mt-4 font-courier text-oldschool-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, urna eu tincidunt consectetur, nisi nunc pretium nisi, eget ultrices nisl nunc eu nisi. Sed euismod, urna eu tincidunt consectetur, nisi nunc pretium nisi, eget ultrices nisl nunc eu nisi.</p>
                
                <ul class="mt-4 list-disc list-inside font-courier text-oldschool-text">
                    <li>100% authentic products</li>
                    <li>Dermatologically tested</li>
                    <li>Cruelty-free and vegan</li>
                    <li>Free from harmful chemicals</li>
                    <li>Suitable for all skin types</li>
                </ul>
            </div>
        </div>
        
        <div id="tab-content-additional" class="tab-content p-6 hidden">
            <h3 class="text-xl font-bold text-oldschool-text mb-4 old-title font-courier">Additional Information</h3>
            <table class="min-w-full old-border">
                <tbody class="divide-y divide-dashed divide-primary">
                    <tr>
                        <td class="py-3 px-4 text-oldschool-text font-medium font-courier bg-oldschool-bg">Weight</td>
                        <td class="py-3 px-4 text-oldschool-text font-courier">0.5 kg</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-oldschool-text font-medium font-courier bg-oldschool-bg">Dimensions</td>
                        <td class="py-3 px-4 text-oldschool-text font-courier">10 × 5 × 5 cm</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-oldschool-text font-medium font-courier bg-oldschool-bg">Ingredients</td>
                        <td class="py-3 px-4 text-oldschool-text font-courier">Aqua, Glycerin, Cetearyl Alcohol, Cetyl Alcohol, Butyrospermum Parkii Butter, Simmondsia Chinensis Seed Oil, Tocopherol</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-oldschool-text font-medium font-courier bg-oldschool-bg">Directions</td>
                        <td class="py-3 px-4 text-oldschool-text font-courier">Apply to clean skin morning and evening. Massage gently until absorbed.</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 text-oldschool-text font-medium font-courier bg-oldschool-bg">Warnings</td>
                        <td class="py-3 px-4 text-oldschool-text font-courier">For external use only. Avoid contact with eyes. Discontinue use if irritation occurs.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div id="tab-content-reviews" class="tab-content p-6 hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-oldschool-text old-title font-courier">Customer Reviews (24)</h3>
                <button class="old-button py-2 px-4">
                    Write a Review
                </button>
            </div>
            
            <div class="mb-8 old-border p-4 bg-oldschool-bg">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-700 mr-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-oldschool-text font-courier">Based on 24 reviews</span>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="text-oldschool-text w-16 font-courier">5 stars</span>
                        <div class="flex-grow h-4 mx-2 bg-oldschool-light old-border overflow-hidden">
                            <div class="bg-primary h-4" style="width: 75%"></div>
                        </div>
                        <span class="text-oldschool-text w-16 text-right font-courier">18</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-oldschool-text w-16 font-courier">4 stars</span>
                        <div class="flex-grow h-4 mx-2 bg-oldschool-light old-border overflow-hidden">
                            <div class="bg-primary h-4" style="width: 20%"></div>
                        </div>
                        <span class="text-oldschool-text w-16 text-right font-courier">5</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-oldschool-text w-16 font-courier">3 stars</span>
                        <div class="flex-grow h-4 mx-2 bg-oldschool-light old-border overflow-hidden">
                            <div class="bg-primary h-4" style="width: 5%"></div>
                        </div>
                        <span class="text-oldschool-text w-16 text-right font-courier">1</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-oldschool-text w-16 font-courier">2 stars</span>
                        <div class="flex-grow h-4 mx-2 bg-oldschool-light old-border overflow-hidden">
                            <div class="bg-primary h-4" style="width: 0%"></div>
                        </div>
                        <span class="text-oldschool-text w-16 text-right font-courier">0</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-oldschool-text w-16 font-courier">1 star</span>
                        <div class="flex-grow h-4 mx-2 bg-oldschool-light old-border overflow-hidden">
                            <div class="bg-primary h-4" style="width: 0%"></div>
                        </div>
                        <span class="text-oldschool-text w-16 text-right font-courier">0</span>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-dashed border-primary pt-6 space-y-6">
                <!-- Review 1 -->
                <div class="border-b border-dashed border-primary pb-6 old-review">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/40x40?text=User" alt="User" class="w-10 h-10 mr-3 old-border transform rotate-2">
                            <div>
                                <h4 class="font-bold text-oldschool-text font-courier">Sarah Johnson</h4>
                                <div class="flex text-yellow-700 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <span class="text-oldschool-text text-sm font-courier">2 weeks ago</span>
                    </div>
                    <h5 class="font-bold text-oldschool-text mb-2 font-courier">Amazing product, exceeded my expectations!</h5>
                    <p class="text-oldschool-text font-courier">I've been using this product for two weeks now and I can already see a significant difference in my skin. It's much more hydrated and the fine lines around my eyes have diminished. Highly recommend!</p>
                </div>
                
                <!-- Review 2 -->
                <div class="border-b border-dashed border-primary pb-6 old-review">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/40x40?text=User" alt="User" class="w-10 h-10 mr-3 old-border transform -rotate-1">
                            <div>
                                <h4 class="font-bold text-oldschool-text font-courier">Michael Chen</h4>
                                <div class="flex text-yellow-700 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <span class="text-oldschool-text text-sm font-courier">1 month ago</span>
                    </div>
                    <h5 class="font-bold text-oldschool-text mb-2 font-courier">Great product, but a bit pricey</h5>
                    <p class="text-oldschool-text font-courier">The product works really well and I love the scent. My only complaint is that it's a bit expensive for the size. Would still recommend though!</p>
                </div>
                
                <!-- Review 3 -->
                <div class="old-review">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/40x40?text=User" alt="User" class="w-10 h-10 mr-3 old-border transform rotate-1">
                            <div>
                                <h4 class="font-bold text-oldschool-text font-courier">Emily Rodriguez</h4>
                                <div class="flex text-yellow-700 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <span class="text-oldschool-text text-sm font-courier">2 months ago</span>
                    </div>
                    <h5 class="font-bold text-oldschool-text mb-2 font-courier">Perfect for my sensitive skin</h5>
                    <p class="text-oldschool-text font-courier">I have very sensitive skin and have had reactions to many products in the past. This one is gentle and effective. No irritation at all and my skin looks so much better!</p>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <button class="old-button py-2 px-4">
                    Load More Reviews
                </button>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-oldschool-text mb-6 old-title font-courier">You May Also Like</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
            <?php if ($relatedProduct['id'] !== $product['id']): ?>
            <div class="bg-white old-border overflow-hidden transition-transform transform hover:scale-105">
                <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $relatedProduct['slug']; ?>">
                    <div class="p-2 bg-oldschool-bg">
                        <img src="<?php echo !empty($relatedProduct['image']) ? $relatedProduct['image'] : 'https://via.placeholder.com/300x300?text=Product+Image'; ?>" 
                             alt="<?php echo $relatedProduct['name']; ?>" 
                             class="w-full h-64 object-cover old-product-image">
                    </div>
                </a>
                <div class="p-4">
                    <span class="inline-block px-2 py-1 text-xs font-bold text-white bg-primary old-border mb-2 old-badge"><?php echo $relatedProduct['category_name']; ?></span>
                    <a href="<?php echo SITE_URL; ?>/pages/user/product-details.php?slug=<?php echo $relatedProduct['slug']; ?>" class="block">
                        <h3 class="text-lg font-bold text-oldschool-text mt-1 hover:text-primary transition font-courier"><?php echo $relatedProduct['name']; ?></h3>
                    </a>
                    <div class="mt-2 flex justify-between items-center">
                        <div>
                            <?php if (!empty($relatedProduct['sale_price'])): ?>
                            <span class="text-oldschool-text line-through font-courier">$<?php echo number_format($relatedProduct['price'], 2); ?></span>
                            <span class="text-lg font-bold text-primary ml-1 font-courier">$<?php echo number_format($relatedProduct['sale_price'], 2); ?></span>
                            <?php else: ?>
                            <span class="text-lg font-bold text-primary font-courier">$<?php echo number_format($relatedProduct['price'], 2); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center">
                            <div class="text-yellow-700 flex">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-xs text-oldschool-text ml-1 font-courier">(4.5)</span>
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-2">
                        <form action="<?php echo SITE_URL; ?>/pages/user/cart-actions.php" method="POST" class="flex-grow">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?php echo $relatedProduct['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full old-button py-2 px-4">
                                <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                            </button>
                        </form>
                        <button class="old-button py-2 px-2 bg-oldschool-bg text-oldschool-text">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    // Add typewriter effect to product description
    function typeWriterEffect(element, text, speed) {
        let i = 0;
        element.innerHTML = '';
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }
    
    // Apply old-school hover effects
    document.querySelectorAll('.old-thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            document.querySelectorAll('.old-thumbnail').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('main-image').src = this.querySelector('img').src;
        });
    });
    
    // Quantity input functionality
    document.getElementById('decrease-qty').addEventListener('click', function() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    });
    
    document.getElementById('increase-qty').addEventListener('click', function() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        const maxValue = parseInt(input.getAttribute('max'));
        if (currentValue < maxValue) {
            input.value = currentValue + 1;
        }
    });
    
    // Tabs functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('border-primary');
                btn.classList.remove('text-primary');
                btn.classList.add('border-transparent');
                btn.classList.add('text-gray-500');
            });
            
            // Add active class to clicked button
            button.classList.add('active');
            button.classList.add('border-primary');
            button.classList.add('text-primary');
            button.classList.remove('border-transparent');
            button.classList.remove('text-gray-500');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('block');
            });
            
            // Show corresponding tab content
            const tabId = button.id.replace('tab-', 'tab-content-');
            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById(tabId).classList.add('block');
        });
    });
    
    // Thumbnail image click
    const thumbnailImages = document.querySelectorAll('.thumbnail-image');
    const mainImage = document.getElementById('main-image');
    
    thumbnailImages.forEach(image => {
        image.addEventListener('click', () => {
            // Update main image src
            mainImage.src = image.src;
            
            // Update active thumbnail
            thumbnailImages.forEach(img => {
                img.parentElement.classList.remove('border-primary');
            });
            image.parentElement.classList.add('border-primary');
        });
    });
</script>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>
