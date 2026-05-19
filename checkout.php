<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){

header("location:login.php");
exit();
}

$user_id = $_SESSION['user_id'];



/* PRODUCT */

if(!isset($_GET['id'])){

header("location:shop-products.php");
exit();
}

$product_id = $_GET['id'];



$productQuery = mysqli_query($conn,

"SELECT products.*,
users.upi_qr,
users.upi_id

FROM products

JOIN users
ON products.seller_id = users.id

WHERE products.id='$product_id'");

$product = mysqli_fetch_assoc($productQuery);



$msg = "";



/* PLACE ORDER */

if(isset($_POST['place_order'])){


$quantity = $_POST['quantity'];

$mobile =
mysqli_real_escape_string($conn,
$_POST['mobile']);



$delivery_type =
mysqli_real_escape_string($conn,
$_POST['delivery_type']);



$payment_method =
mysqli_real_escape_string($conn,
$_POST['payment_method']);



$address =
mysqli_real_escape_string($conn,
$_POST['address']);



$city =
mysqli_real_escape_string($conn,
$_POST['city']);



$state =
mysqli_real_escape_string($conn,
$_POST['state']);



$pincode =
mysqli_real_escape_string($conn,
$_POST['pincode']);



$total_price =
$product['price'] * $quantity;



/* PAYMENT SCREENSHOT */

$payment_screenshot = "";

if(
isset($_FILES['payment_screenshot']['name'])
&& !empty($_FILES['payment_screenshot']['name'])
){

$payment_screenshot =
time() . "_" .
$_FILES['payment_screenshot']['name'];

$tmp =
$_FILES['payment_screenshot']['tmp_name'];

move_uploaded_file($tmp,

"payment/" . $payment_screenshot);
}



/* INSERT ORDER */

mysqli_query($conn,

"INSERT INTO orders

(user_id,
seller_id,
product_id,
product_name,
price,
quantity,
total_price,
mobile,
delivery_type,
payment_method,
payment_screenshot,
payment_status,
address,
city,
state,
pincode,
status)

VALUES

('$user_id',
'{$product['seller_id']}',
'$product_id',
'{$product['product_name']}',
'{$product['price']}',
'$quantity',
'$total_price',
'$mobile',
'$delivery_type',
'$payment_method',
'$payment_screenshot',
'Pending',
'$address',
'$city',
'$state',
'$pincode',
'Pending')");



$msg = "Order Placed Successfully";

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Checkout - MiniMart</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>



/* SECTION */

.checkout-section{

padding:70px 0;
}



/* CARD */

.checkout-card{

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

font-size:36px;

font-weight:800;

margin-bottom:18px;
}



/* PRICE */

.product-price{

font-size:38px;

font-weight:800;

color:#00bfff;
}



/* QR */

.qr-box{

background:#111827;

padding:25px;

border-radius:24px;

margin-top:30px;

text-align:center;
}



/* QR IMAGE */

.qr-img{

width:240px;

border-radius:18px;

margin-top:18px;
}



/* LABEL */

.form-label{

margin-bottom:10px;

font-weight:600;
}



/* INPUT */

.theme-input{

width:100%;
}



/* BUTTON */

.checkout-btn{

width:100%;

height:58px;

border:none;

border-radius:14px;

background:linear-gradient(to right,#00bfff,#0066ff);

color:white;

font-size:20px;

font-weight:700;

margin-top:20px;
}



/* SELECT */

select.theme-input{

color:white;
}

select.theme-input option{

color:black;
}



/* TEXTAREA */

textarea.theme-input{

height:130px;

padding-top:15px;
}



/* RESPONSIVE */

@media(max-width:768px){

.product-title{

font-size:28px;
}

.product-price{

font-size:30px;
}

}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="checkout-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

Checkout

</h1>

<p class="theme-subtitle text-center mb-5">

Complete your order securely

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

<div class="checkout-card glass-card">

<img src="uploads/<?php echo $product['image']; ?>"
class="product-img">



<div class="product-title mt-4">

<?php echo $product['product_name']; ?>

</div>



<div class="product-price">

₹ <?php echo $product['price']; ?>

</div>



<div class="category-badge mt-3">

<?php echo $product['category']; ?>

</div>



<p class="mt-4 text-light">

<?php echo $product['description']; ?>

</p>



<!-- QR -->

<?php
if(
$product['upi_qr'] != ""
&& $product['upi_qr'] != null
){
?>

<div class="qr-box">

<h4>

Scan & Pay

</h4>



<?php
if($product['upi_id'] != ""){
?>

<p class="mt-3">

UPI ID:
<b>

<?php echo $product['upi_id']; ?>

</b>

</p>

<?php } ?>



<img src="uploads/<?php echo $product['upi_qr']; ?>"
class="qr-img">

</div>

<?php } ?>

</div>

</div>



<!-- FORM -->

<div class="col-lg-7">

<div class="checkout-card glass-card">

<form method="POST"
enctype="multipart/form-data">



<div class="row">



<!-- QUANTITY -->

<div class="col-md-6 mb-4">

<label class="form-label">

Quantity

</label>

<input type="number"
name="quantity"
value="1"
min="1"
class="theme-input"
required>

</div>



<!-- MOBILE -->

<div class="col-md-6 mb-4">

<label class="form-label">

Mobile Number

</label>

<input type="text"
name="mobile"
class="theme-input"
required>

</div>



<!-- DELIVERY -->

<div class="col-md-6 mb-4">

<label class="form-label">

Delivery Type

</label>

<select name="delivery_type"
class="theme-input"
required>

<option value="Standard">

Standard Delivery

</option>

<option value="Fast">

Fast Delivery

</option>

</select>

</div>



<!-- PAYMENT -->

<div class="col-md-6 mb-4">

<label class="form-label">

Payment Method

</label>

<select name="payment_method"
class="theme-input"
required>

<option value="Cash On Delivery">

Cash On Delivery

</option>

<option value="UPI Payment">

UPI Payment

</option>

</select>

</div>



<!-- ADDRESS -->

<div class="col-12 mb-4">

<label class="form-label">

Address

</label>

<textarea
name="address"
class="theme-input"
required></textarea>

</div>



<!-- CITY -->

<div class="col-md-4 mb-4">

<label class="form-label">

City

</label>

<input type="text"
name="city"
class="theme-input"
required>

</div>



<!-- STATE -->

<div class="col-md-4 mb-4">

<label class="form-label">

State

</label>

<input type="text"
name="state"
class="theme-input"
required>

</div>



<!-- PINCODE -->

<div class="col-md-4 mb-4">

<label class="form-label">

Pincode

</label>

<input type="text"
name="pincode"
class="theme-input"
required>

</div>



<!-- SCREENSHOT -->

<div class="col-12 mb-4">

<label class="form-label">

Payment Screenshot (Optional)

</label>

<input type="file"
name="payment_screenshot"
class="theme-input">

</div>

</div>



<button type="submit"
name="place_order"
class="checkout-btn">

Place Order

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