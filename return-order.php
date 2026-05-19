<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){

header("location:login.php");
exit();
}

$user_id = $_SESSION['user_id'];



if(!isset($_GET['id'])){

header("location:orders.php");
exit();
}

$order_id = $_GET['id'];



/* ORDER */

$query = mysqli_query($conn,

"SELECT * FROM orders

WHERE id='$order_id'

AND user_id='$user_id'");



$order = mysqli_fetch_assoc($query);



$msg = "";



/* RETURN */

if(isset($_POST['return_order'])){


$return_reason =
mysqli_real_escape_string($conn,
$_POST['return_reason']);



mysqli_query($conn,

"UPDATE orders

SET return_status='Requested',
return_reason='$return_reason'

WHERE id='$order_id'");



$msg = "Return Request Submitted Successfully";

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Return Order - MiniMart</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>



/* SECTION */

.return-section{

padding:70px 0;
}



/* CARD */

.return-card{

padding:35px;

border-radius:28px;
}



/* IMAGE */

.product-img{

width:100%;

height:320px;

object-fit:cover;

border-radius:24px;
}



/* TITLE */

.product-title{

font-size:34px;

font-weight:800;

margin-top:25px;
}



/* PRICE */

.product-price{

font-size:38px;

font-weight:800;

color:#00bfff;

margin-top:12px;
}



/* TEXTAREA */

textarea.theme-input{

height:180px;

padding-top:18px;

width:100%;
}



/* BUTTON */

.return-btn{

width:100%;

height:58px;

border:none;

border-radius:14px;

background:#f59e0b;

color:white;

font-size:20px;

font-weight:700;

margin-top:25px;
}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="return-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

Return Order

</h1>

<p class="theme-subtitle text-center mb-5">

Submit your return request

</p>



<?php
if($msg != ""){
?>

<div class="alert alert-success">

<?php echo $msg; ?>

</div>

<?php } ?>



<div class="row g-5">



<!-- PRODUCT -->

<div class="col-lg-5">

<div class="return-card glass-card">

<?php

$productQuery = mysqli_query($conn,

"SELECT * FROM products
WHERE id='{$order['product_id']}'");

$product = mysqli_fetch_assoc($productQuery);

?>



<img src="uploads/<?php echo $product['image']; ?>"
class="product-img">



<div class="product-title">

<?php echo $order['product_name']; ?>

</div>



<div class="product-price">

₹ <?php echo $order['total_price']; ?>

</div>



<div class="category-badge mt-3">

<?php echo $product['category']; ?>

</div>

</div>

</div>



<!-- FORM -->

<div class="col-lg-7">

<div class="return-card glass-card">

<form method="POST">



<label class="mb-3">

Reason For Return

</label>

<textarea
name="return_reason"
class="theme-input"
placeholder="Write return reason..."
required></textarea>



<button type="submit"
name="return_order"
class="return-btn">

Submit Return Request

</button>

</form>

</div>

</div>

</div>

</div>

</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>