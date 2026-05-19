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

"DELETE FROM cart

WHERE id='$id'

AND user_id='$user_id'");

header("location:cart.php");
exit();
}



/* UPDATE QUANTITY */

if(isset($_POST['update_qty'])){

$cart_id = $_POST['cart_id'];

$quantity = $_POST['quantity'];



mysqli_query($conn,

"UPDATE cart

SET quantity='$quantity'

WHERE id='$cart_id'

AND user_id='$user_id'");
}



/* CART QUERY */

$query = mysqli_query($conn,

"SELECT cart.*,
products.product_name,
products.price,
products.image,
products.stock,
products.category

FROM cart

JOIN products
ON cart.product_id = products.id

WHERE cart.user_id='$user_id'

ORDER BY cart.id DESC");



$total = 0;

?>

<!DOCTYPE html>
<html>

<head>

<title>Cart - MiniMart</title>

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

.cart-section{

padding:70px 0;
}



/* CARD */

.cart-card{

padding:25px;

border-radius:24px;

margin-bottom:30px;
}



/* IMAGE */

.product-img{

width:100%;

height:220px;

object-fit:cover;

border-radius:20px;
}



/* TITLE */

.product-title{

font-size:28px;

font-weight:700;

margin-bottom:12px;
}



/* PRICE */

.product-price{

font-size:30px;

font-weight:700;

color:#00bfff;
}



/* CATEGORY */

.category-badge{

margin-top:15px;
}



/* QTY */

.qty-input{

width:90px;

height:48px;

border:none;

border-radius:12px;

background:#111827;

color:white;

text-align:center;
}



/* REMOVE */

.remove-btn{

background:#dc2626;

border:none;

height:48px;

padding:0 22px;

border-radius:12px;

color:white;

font-weight:600;
}



/* SUMMARY */

.summary-card{

padding:30px;

border-radius:24px;

position:sticky;

top:110px;
}



/* TOTAL */

.total-price{

font-size:36px;

font-weight:800;

color:#00bfff;
}



/* EMPTY */

.empty-box{

text-align:center;

padding:90px 20px;
}

.empty-box i{

font-size:100px;

color:#00bfff;

margin-bottom:25px;
}



/* BUTTON */

.checkout-btn{

width:100%;

height:56px;

border:none;

border-radius:14px;

background:linear-gradient(to right,#00bfff,#0066ff);

color:white;

font-size:18px;

font-weight:700;

margin-top:20px;
}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="cart-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

Shopping Cart

</h1>

<p class="theme-subtitle text-center mb-5">

Manage your cart products

</p>



<div class="row">

<div class="col-lg-8">



<?php

if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_assoc($query)){

$item_total =
$row['price'] * $row['quantity'];

$total += $item_total;

?>



<div class="cart-card glass-card">

<div class="row align-items-center">



<!-- IMAGE -->

<div class="col-md-4 mb-3">

<img src="uploads/<?php echo $row['image']; ?>"
class="product-img">

</div>



<!-- DETAILS -->

<div class="col-md-8">

<div class="product-title">

<?php echo $row['product_name']; ?>

</div>



<div class="product-price">

₹ <?php echo $row['price']; ?>

</div>



<div class="category-badge">

<?php echo $row['category']; ?>

</div>



<p class="mt-3">

Stock:
<b>

<?php echo $row['stock']; ?>

</b>

</p>



<!-- QUANTITY -->

<form method="POST"
class="d-flex align-items-center gap-3 mt-4">

<input type="hidden"
name="cart_id"
value="<?php echo $row['id']; ?>">



<input type="number"
name="quantity"
value="<?php echo $row['quantity']; ?>"
min="1"
class="qty-input">



<button type="submit"
name="update_qty"
class="theme-btn">

Update

</button>



<a href="cart.php?remove=<?php echo $row['id']; ?>">

<button type="button"
class="remove-btn">

Remove

</button>

</a>

</form>



<h4 class="mt-4">

Subtotal:
<span class="text-info">

₹ <?php echo $item_total; ?>

</span>

</h4>

</div>

</div>

</div>

<?php } } else { ?>



<div class="empty-box">

<i class="fa-solid fa-cart-shopping"></i>

<h2>

Cart Is Empty

</h2>

<p>

Add products to continue shopping

</p>

<a href="shop-products.php"
class="theme-btn">

Shop Now

</a>

</div>

<?php } ?>

</div>



<!-- SUMMARY -->

<div class="col-lg-4">

<div class="summary-card glass-card">

<h2 class="mb-4">

Order Summary

</h2>



<div class="d-flex justify-content-between mb-3">

<h5>Total Items</h5>

<h5>

<?php echo mysqli_num_rows($query); ?>

</h5>

</div>



<div class="d-flex justify-content-between mb-4">

<h4>Total Price</h4>

<div class="total-price">

₹ <?php echo $total; ?>

</div>

</div>



<?php
if($total > 0){
?>

<a href="checkout-all.php">

<button class="checkout-btn">

Checkout

</button>

</a>

<?php } ?>

</div>

</div>

</div>

</div>

</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>