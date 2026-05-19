<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){

header("location:login.php");
exit();
}

$user_id = $_SESSION['user_id'];



/* REMOVE */

if(isset($_GET['remove'])){

$id = $_GET['remove'];

mysqli_query($conn,

"DELETE FROM wishlist

WHERE id='$id'

AND user_id='$user_id'");

header("location:wishlist.php");
exit();
}



/* QUERY */

$query = mysqli_query($conn,

"SELECT wishlist.*,
products.product_name,
products.price,
products.image,
products.category,
products.description

FROM wishlist

JOIN products
ON wishlist.product_id = products.id

WHERE wishlist.user_id='$user_id'

ORDER BY wishlist.id DESC");

?>

<!DOCTYPE html>
<html>

<head>

<title>Wishlist - MiniMart</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>



/* SECTION */

.wishlist-section{

padding:70px 0;
}



/* CARD */

.wishlist-card{

border-radius:24px;

overflow:hidden;

transition:0.3s;

height:100%;
}

.wishlist-card:hover{

transform:translateY(-8px);

box-shadow:0 0 24px rgba(0,191,255,0.35);
}



/* IMAGE */

.product-img{

width:100%;

height:270px;

object-fit:cover;
}



/* BODY */

.product-body{

padding:24px;
}



/* TITLE */

.product-title{

font-size:26px;

font-weight:700;

margin-bottom:12px;
}



/* PRICE */

.product-price{

font-size:30px;

font-weight:700;

color:#00bfff;
}



/* DESCRIPTION */

.description{

margin-top:15px;

color:#d1d5db;

line-height:1.7;
}



/* BUTTONS */

.action-buttons{

display:flex;

gap:15px;

margin-top:25px;
}



/* CART BTN */

.cart-btn{

flex:1;

height:52px;

border:none;

border-radius:14px;

background:linear-gradient(to right,#00bfff,#0066ff);

color:white;

font-weight:700;
}



/* REMOVE BTN */

.remove-btn{

flex:1;

height:52px;

border:none;

border-radius:14px;

background:#dc2626;

color:white;

font-weight:700;
}



/* EMPTY */

.empty-box{

text-align:center;

padding:100px 20px;
}

.empty-box i{

font-size:100px;

color:#00bfff;

margin-bottom:25px;
}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="wishlist-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

My Wishlist

</h1>

<p class="theme-subtitle text-center mb-5">

Your favourite saved products

</p>



<div class="row">

<?php

if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_assoc($query)){

?>



<div class="col-lg-4 col-md-6 mb-5">

<div class="wishlist-card glass-card">



<!-- IMAGE -->

<img src="uploads/<?php echo $row['image']; ?>"
class="product-img">



<!-- BODY -->

<div class="product-body">

<div class="product-title">

<?php echo $row['product_name']; ?>

</div>



<div class="product-price">

₹ <?php echo $row['price']; ?>

</div>



<div class="category-badge">

<?php echo $row['category']; ?>

</div>



<div class="description">

<?php echo substr($row['description'],0,120); ?>

...

</div>



<!-- BUTTONS -->

<div class="action-buttons">



<a href="checkout.php?id=<?php echo $row['product_id']; ?>"
class="flex-fill">

<button class="cart-btn w-100">

Buy Now

</button>

</a>



<a href="wishlist.php?remove=<?php echo $row['id']; ?>"
class="flex-fill">

<button class="remove-btn w-100">

Remove

</button>

</a>

</div>

</div>

</div>

</div>

<?php } } else { ?>



<div class="empty-box">

<i class="fa-solid fa-heart-circle-xmark"></i>

<h2>

Wishlist Is Empty

</h2>

<p>

Save products to wishlist

</p>



<a href="shop-products.php"
class="theme-btn">

Explore Products

</a>

</div>

<?php } ?>

</div>

</div>

</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>