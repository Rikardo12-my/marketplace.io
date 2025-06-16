<?php 
include 'koneksi.php'; 
session_start();

// Set bahasa (default: en)
$lang = $_GET['lang'] ?? 'en';
if (!in_array($lang, ['en', 'id'])) $lang = 'en';
$text = include "lang/$lang.php";
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $text['brand'] ?> | Digital Product Marketplace</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    section { padding: 100px 0; }
    html { scroll-behavior: smooth; }
    .card img { height: 200px; object-fit: cover; }
    
    /* Checkout and Payment Container Styles */
    .checkout-container, .payment-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      background: white;
    }
    
    /* Payment Steps Indicator */
    .payment-steps {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }
    .step {
      text-align: center;
      flex: 1;
      position: relative;
    }
    .step-number {
      width: 40px;
      height: 40px;
      background-color: #e9ecef;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
      font-weight: bold;
    }
    .step.active .step-number {
      background-color: #0d6efd;
      color: white;
    }
    .step.completed .step-number {
      background-color: #198754;
      color: white;
    }
    .step:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 20px;
      left: 70%;
      width: 60%;
      height: 2px;
      background-color: #e9ecef;
    }
    .step.completed:not(:last-child)::after {
      background-color: #198754;
    }
    
    /* Payment Method Details */
    .payment-method-details {
      display: none;
    }
    
    /* Modal Overlay */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0,0,0,0.5);
      z-index: 1040;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    
    /* Hide elements */
    .d-none {
      display: none !important;
    }
  </style>
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#"><?= $text['brand'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#about"><?= $text['about'] ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#konten"><?= $text['content'] ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#blog"><?= $text['blog'] ?></a></li>
        <li class="nav-item"><a class="nav-link" href="#contact"><?= $text['contact'] ?></a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">🌐</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="?lang=id">🇮🇩 Indonesia</a></li>
            <li><a class="dropdown-item" href="?lang=en">🇬🇧 English</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- About Section -->
<section id="about" class="bg-light">
  <div class="container">
    <h2 class="text-center mb-4"><?= $text['about'] ?></h2>
    <p class="text-center"><?= $text['about_text'] ?></p>
  </div>
</section>

<!-- Konten Section: Digital Products -->
<section id="konten">
  <div class="container">
    <h2 class="text-center mb-4"><?= $text['content'] ?></h2>
    <div class="row g-4">

      <!-- Product 1 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://m.media-amazon.com/images/I/61oHnQP0sgL._UF1000,1000_QL80_.jpg" class="card-img-top" alt="eBook">
          <div class="card-body">
            <h5 class="card-title">Mastering PHP eBook</h5>
            <p class="card-text">Learn PHP from scratch to advanced level with this complete eBook guide.</p>
            <p><strong>$15</strong></p>
            <button type="button" class="btn btn-primary w-100" onclick="showBuyModal(1, 'Mastering PHP eBook', '15')">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://themes.getbootstrap.com/wp-content/uploads/2019/08/quick-website-ui-kit-1.1.0-cover.jpg" class="card-img-top" alt="Template">
          <div class="card-body">
            <h5 class="card-title">UI Web Template Pack</h5>
            <p class="card-text">Download premium quality UI templates for your next web project.</p>
            <p><strong>$25</strong></p>
            <button type="button" class="btn btn-primary w-100" onclick="showBuyModal(2, 'UI Web Template Pack', '25')">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://static1.squarespace.com/static/594d20319f745615af77c49b/594f8254e3df282d44afdec4/594fcfa69de4bbe55e21f01b/1505063665554/1.jpg?format=1500w" class="card-img-top" alt="Music">
          <div class="card-body">
            <h5 class="card-title">Background Music Pack</h5>
            <p class="card-text">A royalty-free music pack for your YouTube, podcast, and game projects.</p>
            <p><strong>$10</strong></p>
            <button type="button" class="btn btn-primary w-100" onclick="showBuyModal(3, 'Background Music Pack', '10')">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 4 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQveH2X0ZDzbbvEHsf8ddqV_RrvLgifRQa4pA&s" class="card-img-top" alt="Icon Pack">
          <div class="card-body">
            <h5 class="card-title">Modern Icon Pack</h5>
            <p class="card-text">A collection of vector icons for apps, websites, and graphic projects.</p>
            <p><strong>$12</strong></p>
            <button type="button" class="btn btn-primary w-100" onclick="showBuyModal(4, 'Modern Icon Pack', '12')">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 5 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://images.unsplash.com/photo-1605379399642-870262d3d051" class="card-img-top" alt="Video Backgrounds">
          <div class="card-body">
            <h5 class="card-title">HD Video Backgrounds</h5>
            <p class="card-text">High-quality looping video backgrounds for websites or presentations.</p>
            <p><strong>$18</strong></p>
            <button type="button" class="btn btn-primary w-100" onclick="showBuyModal(5, 'HD Video Backgrounds', '18')">Buy Now</button>
          </div>
        </div>
      </div>

      <!-- Product 6 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://img.youtube.com/vi/otJiSK_-9aI/sddefault.jpg" class="card-img-top" alt="Photo Pack">
          <div class="card-body">
            <h5 class="card-title">Nature Photo Pack</h5>
            <p class="card-text">A curated pack of stunning royalty-free nature and landscape photos.</p>
            <p><strong>$9</strong></p>
            <button type="button" class="btn btn-primary w-100" onclick="showBuyModal(6, 'Nature Photo Pack', '9')">Buy Now</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Blog Section --> 
<section id="blog" class="bg-light">
  <div class="container">
    <h2 class="text-center mb-4"><?= $text['blog'] ?></h2>

    <div class="row g-4">
      <!-- Blog Post 1 -->
      <div class="row">
        <!-- Blog Post 1 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="https://static1.makeuseofimages.com/wordpress/wp-content/uploads/2019/08/simple-php-website.jpg" 
                 class="card-img-top img-fluid" 
                 style="height: 200px; object-fit: cover;" 
                 alt="Blog 1">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title" style="min-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <?= $text['blog1_title'] ?>
              </h5>
              <p class="card-text flex-grow-1" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                <?= $text['blog1_excerpt'] ?>
              </p>
              <button class="btn btn-outline-primary btn-sm mt-auto align-self-center" 
                      style="width: 150px;"
                      data-bs-toggle="modal" 
                      data-bs-target="#blogModal1">
                <?= $text['read_more'] ?>
              </button>
            </div>
          </div>
        </div>

        <!-- Blog Post 2 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="https://getbootstrap.com/docs/4.0/examples/screenshots/album.png" 
                 class="card-img-top img-fluid" 
                 style="height: 200px; object-fit: cover;" 
                 alt="Blog 2">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title" style="min-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <?= $text['blog2_title'] ?>
              </h5>
              <p class="card-text flex-grow-1" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                <?= $text['blog2_excerpt'] ?>
              </p>
              <button class="btn btn-outline-primary btn-sm mt-auto align-self-center" 
                      style="width: 150px;"
                      data-bs-toggle="modal" 
                      data-bs-target="#blogModal2">
                <?= $text['read_more'] ?>
              </button>
            </div>
          </div>
        </div>

        <!-- Blog Post 3 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="https://www.wowmakers.com/static/6160493db90fe09f8bce1f223a1af586/Componenets-of-a-Modular-Website.jpg" 
                 class="card-img-top img-fluid" 
                 style="height: 200px; object-fit: cover;" 
                 alt="Blog 3">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title" style="min-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                <?= $text['blog3_title'] ?>
              </h5>
              <p class="card-text flex-grow-1" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                <?= $text['blog3_excerpt'] ?>
              </p>
              <button class="btn btn-outline-primary btn-sm mt-auto align-self-center" 
                      style="width: 150px;"
                      data-bs-toggle="modal" 
                      data-bs-target="#blogModal3">
                <?= $text['read_more'] ?>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Blog 1 -->
      <div class="modal fade" id="blogModal1" tabindex="-1" aria-labelledby="blogModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="blogModalLabel1"><?= $text['blog1_title'] ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <?= $text['blog1_full'] ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Blog 2 -->
      <div class="modal fade" id="blogModal2" tabindex="-1" aria-labelledby="blogModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="blogModalLabel2"><?= $text['blog2_title'] ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <?= $text['blog2_full'] ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Blog 3 -->
      <div class="modal fade" id="blogModal3" tabindex="-1" aria-labelledby="blogModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="blogModalLabel3"><?= $text['blog3_title'] ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <?= $text['blog3_full'] ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact">
  <div class="container">
    <h2 class="text-center mb-4"><?= $text['contact'] ?></h2>
    <form action="proses_contact.php" method="POST" class="w-50 mx-auto">
      <div class="mb-3">
        <label for="nama" class="form-label"><?= $text['name'] ?></label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label"><?= $text['email'] ?></label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="pesan" class="form-label"><?= $text['message'] ?></label>
        <textarea name="pesan" rows="4" class="form-control" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><?= $text['send'] ?></button>
    </form>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4 mt-5">
  <div class="container">
    <p class="mb-1">© 2025 <?= $text['brand'] ?>. All rights reserved.</p>
    <small><?= $text['footer'] ?></small>
  </div>
</footer>

<!-- Modal Overlay (for both checkout and payment) -->
<div id="purchaseOverlay" class="modal-overlay d-none">
  <!-- Checkout Container -->
  <div id="checkoutContainer" class="checkout-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Checkout</h2>
      <button type="button" class="btn-close" onclick="closePurchaseFlow()"></button>
    </div>
    
    <input type="hidden" name="product_id" id="product_id">
    <input type="hidden" name="product_name" id="product_name">
    <input type="hidden" name="product_price" id="product_price">

    <p><strong>Product:</strong> <span id="modal_product_name"></span></p>
    <p><strong>Price:</strong> $<span id="modal_product_price"></span></p>

    <div class="mb-3">
      <label class="form-label"><?= $text['name'] ?></label>
      <input type="text" id="buyer_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label"><?= $text['email'] ?></label>
      <input type="email" id="buyer_email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Payment Method</label>
      <select id="payment_method" class="form-control" required>
        <option value="Bank Transfer">Bank Transfer</option>
        <option value="Credit Card">Credit Card</option>
        <option value="PayPal">PayPal</option>
        <option value="Other">Other</option>
      </select>
    </div>
    
    <div class="d-flex justify-content-between mt-4">
      <button type="button" class="btn btn-secondary" onclick="closePurchaseFlow()">Cancel</button>
      <button type="button" class="btn btn-success" onclick="showPaymentPage()">Pay Now</button>
    </div>
  </div>
  
  <!-- Payment Container (hidden initially) -->
  <div id="paymentContainer" class="payment-container d-none">
    <div class="payment-header">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">Payment Process</h2>
        <button type="button" class="btn-close" onclick="closePurchaseFlow()"></button>
      </div>
      
      <div class="payment-steps">
        <div class="step completed">
          <div class="step-number">1</div>
          <div class="step-title">Checkout</div>
        </div>
        <div class="step active">
          <div class="step-number">2</div>
          <div class="step-title">Payment</div>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <div class="step-title">Confirmation</div>
        </div>
      </div>
    </div>
    
    <div class="row mb-4">
      <div class="col-md-6">
        <h4>Order Summary</h4>
        <div class="card mb-3">
          <div class="card-body">
            <h5 id="payment-product-name"></h5>
            <p>Price: $<span id="payment-product-price"></span></p>
            <p>Payment Method: <span id="payment-method"></span></p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h4>Payment Details</h4>
        <div id="bank-transfer-details" class="payment-method-details">
          <div class="card mb-3">
            <div class="card-body">
              <h5>Bank Transfer</h5>
              <p>Bank Name: ABC Bank</p>
              <p>Account Number: 1234567890</p>
              <p>Account Name: Digital Marketplace</p>
              <p>Please include your order ID in the transfer note</p>
            </div>
          </div>
        </div>
        
        <div id="credit-card-details" class="payment-method-details" style="display:none">
          <div class="card mb-3">
            <div class="card-body">
              <h5>Credit Card</h5>
              <div class="mb-3">
                <label class="form-label">Card Number</label>
                <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Expiry Date</label>
                  <input type="text" class="form-control" placeholder="MM/YY">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">CVV</label>
                  <input type="text" class="form-control" placeholder="123">
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="paypal-details" class="payment-method-details" style="display:none">
          <div class="card mb-3">
            <div class="card-body">
              <h5>PayPal</h5>
              <p>You will be redirected to PayPal to complete your payment</p>
              <button class="btn btn-primary">Proceed to PayPal</button>
            </div>
          </div>
        </div>
        
        <div id="other-details" class="payment-method-details" style="display:none">
          <div class="card mb-3">
            <div class="card-body">
              <h5>Other Payment Method</h5>
              <p>Please contact our support for alternative payment methods</p>
              <p>Email: support@digitalmarket.com</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="d-flex justify-content-between">
      <button class="btn btn-secondary" onclick="goBackToCheckout()">Back to Checkout</button>
      <button class="btn btn-success" onclick="completePayment()">Complete Payment</button>
    </div>
  </div>
</div>

<!-- Payment Confirmation Modal -->
<div class="modal fade" id="paymentConfirmationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#198754" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
          </svg>
        </div>
        <h4 class="mb-3">Thank you for your purchase!</h4>
        <p>Your payment has been processed successfully.</p>
        <p>We've sent the download link to <strong id="confirmation-email"></strong></p>
        <p>Order ID: <strong>ORD-<?= rand(1000, 9999) ?></strong></p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" onclick="closeAllModals()">Back to Home</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showBuyModal(id, name, price) {
    // Set values
    document.getElementById('product_id').value = id;
    document.getElementById('product_name').value = name;
    document.getElementById('product_price').value = price;
    document.getElementById('modal_product_name').innerText = name;
    document.getElementById('modal_product_price').innerText = price;
    
    // Show checkout in overlay
    document.getElementById('purchaseOverlay').classList.remove('d-none');
    document.getElementById('checkoutContainer').classList.remove('d-none');
    document.getElementById('paymentContainer').classList.add('d-none');
  }
  
  function showPaymentPage() {
    // Get values from checkout form
    const productName = document.getElementById('modal_product_name').innerText;
    const productPrice = document.getElementById('modal_product_price').innerText;
    const buyerName = document.getElementById('buyer_name').value;
    const buyerEmail = document.getElementById('buyer_email').value;
    const paymentMethod = document.getElementById('payment_method').value;
    
    // Validate form
    if (!buyerName || !buyerEmail) {
      alert('Please fill in all required fields');
      return;
    }
    
    // Set values in payment page
    document.getElementById('payment-product-name').innerText = productName;
    document.getElementById('payment-product-price').innerText = productPrice;
    document.getElementById('payment-method').innerText = paymentMethod;
    document.getElementById('confirmation-email').innerText = buyerEmail;
    
    // Show relevant payment method details
    document.querySelectorAll('.payment-method-details').forEach(el => {
      el.style.display = 'none';
    });
    
    if (paymentMethod === 'Bank Transfer') {
      document.getElementById('bank-transfer-details').style.display = 'block';
    } else if (paymentMethod === 'Credit Card') {
      document.getElementById('credit-card-details').style.display = 'block';
    } else if (paymentMethod === 'PayPal') {
      document.getElementById('paypal-details').style.display = 'block';
    } else {
      document.getElementById('other-details').style.display = 'block';
    }
    
    // Switch to payment view
    document.getElementById('checkoutContainer').classList.add('d-none');
    document.getElementById('paymentContainer').classList.remove('d-none');
  }
  
  function goBackToCheckout() {
    document.getElementById('checkoutContainer').classList.remove('d-none');
    document.getElementById('paymentContainer').classList.add('d-none');
  }
  
  function closePurchaseFlow() {
    document.getElementById('purchaseOverlay').classList.add('d-none');
  }
  
  function completePayment() {
    // Hide payment overlay
    document.getElementById('purchaseOverlay').classList.add('d-none');
    
    // Show confirmation modal
    var confirmationModal = new bootstrap.Modal(document.getElementById('paymentConfirmationModal'));
    confirmationModal.show();
  }
  
  function closeAllModals() {
    bootstrap.Modal.getInstance(document.getElementById('paymentConfirmationModal')).hide();
    // You could redirect to home page here if needed
    // window.location.href = 'index.php';
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>