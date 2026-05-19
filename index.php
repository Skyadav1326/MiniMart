<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>

<head>

<title>MiniMart - Premium Ecommerce</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

.hero{

min-height:100vh;

display:flex;

align-items:center;

background:
linear-gradient(rgba(0,0,0,0.7),
rgba(0,0,0,0.7)),

url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=1400');

background-size:cover;

background-position:center;
}

.hero-content h1{

font-size:70px;

font-weight:800;

color:white;
}

.hero-content h1 span{

color:#00bfff;
}

.hero-content p{

font-size:20px;

color:#d1d5db;

margin-top:20px;

max-width:650px;
}

.hero-btn{

display:inline-block;

margin-top:35px;

padding:18px 35px;

background:linear-gradient(to right,#00bfff,#0066ff);

border-radius:14px;

color:white;

font-weight:700;

font-size:18px;
}

</style>

</head>

<body>



<?php include 'includes/navbar.php'; ?>



<section class="hero">

<div class="container">

<div class="hero-content">

<h1>

Welcome To  
<span>MiniMart</span>

</h1>

<p>

Premium Multi Vendor Ecommerce Website with Cart, Wishlist, Checkout, Seller Dashboard, Delivery System, Reviews and Returns.

</p>



<a href="shop-products.php"
class="hero-btn">

Shop Now

</a>

</div>

</div>

</section>



<?php include 'includes/footer.php'; ?>

</body>
</html>