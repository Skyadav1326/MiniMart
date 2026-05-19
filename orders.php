<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){

header("location:login.php");
exit();
}

$user_id = $_SESSION['user_id'];



/* CANCEL ORDER */

if(isset($_GET['cancel'])){

$order_id = $_GET['cancel'];



mysqli_query($conn,

"UPDATE orders

SET status='Cancelled'

WHERE id='$order_id'

AND user_id='$user_id'

AND status='Pending'");
}



/* QUERY */

$query = mysqli_query($conn,

"SELECT * FROM orders

WHERE user_id='$user_id'

ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>

<head>

<title>My Orders - MiniMart</title>

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

.orders-section{

padding:70px 0;
}



/* CARD */

.order-card{

padding:30px;

border-radius:28px;

margin-bottom:35px;
}



/* IMAGE */

.product-img{

width:100%;

height:250px;

object-fit:cover;

border-radius:24px;
}



/* TITLE */

.product-title{

font-size:32px;

font-weight:800;

margin-bottom:15px;
}



/* PRICE */

.product-price{

font-size:34px;

font-weight:800;

color:#00bfff;
}



/* STATUS */

.status-badge{

display:inline-block;

padding:10px 20px;

border-radius:50px;

font-weight:700;

margin-top:20px;
}



/* STATUS COLORS */

.pending{

background:#f59e0b;
color:white;
}

.packed{

background:#2563eb;
color:white;
}

.delivery{

background:#06b6d4;
color:white;
}

.delivered{

background:#16a34a;
color:white;
}

.cancelled{

background:#dc2626;
color:white;
}



/* BUTTONS */

.action-buttons{

display:flex;

gap:15px;

flex-wrap:wrap;

margin-top:30px;
}



/* BTN */

.action-btn{

padding:14px 24px;

border:none;

border-radius:14px;

font-weight:700;

color:white;
}



/* CANCEL */

.cancel-btn{

background:#dc2626;
}



/* RETURN */

.return-btn{

background:#f59e0b;
}



/* REVIEW */

.review-btn{

background:#06b6d4;
}



/* ADDRESS */

.address-box{

background:#111827;

padding:20px;

border-radius:20px;

margin-top:25px;
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

<section class="orders-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

My Orders

</h1>

<p class="theme-subtitle text-center mb-5">

Track and manage your orders

</p>



<?php

if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_assoc($query)){

?>



<div class="order-card glass-card">

<div class="row align-items-center">



<!-- IMAGE -->

<div class="col-lg-4 mb-4">

<?php

$productQuery = mysqli_query($conn,

"SELECT * FROM products
WHERE id='{$row['product_id']}'");

$product = mysqli_fetch_assoc($productQuery);

?>



<img src="uploads/<?php echo $product['image']; ?>"
class="product-img">

</div>



<!-- DETAILS -->

<div class="col-lg-8">

<div class="product-title">

<?php echo $row['product_name']; ?>

</div>



<div class="product-price">

₹ <?php echo $row['total_price']; ?>

</div>



<p class="mt-3">

Quantity:
<b>

<?php echo $row['quantity']; ?>

</b>

</p>



<p>

Payment:
<b>

<?php echo $row['payment_method']; ?>

</b>

</p>



<p>

Delivery:
<b>

<?php echo $row['delivery_type']; ?>

</b>

</p>



<!-- STATUS -->

<?php

$statusClass = "";



if($row['status']=="Pending"){

$statusClass = "pending";
}

elseif($row['status']=="Packed"){

$statusClass = "packed";
}

elseif($row['status']=="Out For Delivery"){

$statusClass = "delivery";
}

elseif($row['status']=="Delivered"){

$statusClass = "delivered";
}

elseif($row['status']=="Cancelled"){

$statusClass = "cancelled";
}

?>



<div class="status-badge <?php echo $statusClass; ?>">

<?php echo $row['status']; ?>

</div>



<!-- ADDRESS -->

<div class="address-box">

<h5 class="mb-3">

Delivery Address

</h5>

<p>

<?php echo $row['address']; ?>

</p>

<p>

<?php echo $row['city']; ?>,
<?php echo $row['state']; ?>

-

<?php echo $row['pincode']; ?>

</p>

</div>



<!-- BUTTONS -->

<div class="action-buttons">



<!-- CANCEL -->

<?php
if($row['status']=="Pending"){
?>

<a href="orders.php?cancel=<?php echo $row['id']; ?>">

<button class="action-btn cancel-btn">

Cancel Order

</button>

</a>

<?php } ?>



<!-- RETURN -->

<?php
if($row['status']=="Delivered"){
?>

<a href="return-order.php?id=<?php echo $row['id']; ?>">

<button class="action-btn return-btn">

Return Order

</button>

</a>

<?php } ?>



<!-- REVIEW -->

<?php
if($row['status']=="Delivered"){
?>

<a href="review-order.php?id=<?php echo $row['id']; ?>">

<button class="action-btn review-btn">

Write Review

</button>

</a>

<?php } ?>

</div>

</div>

</div>

</div>

<?php } } else { ?>



<div class="empty-box">

<i class="fa-solid fa-box-open"></i>

<h2>

No Orders Found

</h2>

<p>

Start shopping now

</p>



<a href="shop-products.php"
class="theme-btn">

Shop Now

</a>

</div>

<?php } ?>

</div>

</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>