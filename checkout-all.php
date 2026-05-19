<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){

header("location:login.php");
exit();
}

$user_id = $_SESSION['user_id'];



/* CART PRODUCTS */

$query = mysqli_query($conn,

"SELECT cart.*,
products.*

FROM cart

JOIN products
ON cart.product_id = products.id

WHERE cart.user_id='$user_id'");



if(mysqli_num_rows($query) == 0){

header("location:cart.php");
exit();
}



$total = 0;

$products = [];

while($row = mysqli_fetch_assoc($query)){

$products[] = $row;

$total += $row['price'] * $row['quantity'];
}



$msg = "";



/* PLACE ORDER */

if(isset($_POST['place_order'])){


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



/* INSERT ALL ORDERS */

foreach($products as $product){

$product_total =
$product['price'] * $product['quantity'];



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
'{$product['product_id']}',
'{$product['product_name']}',
'{$product['price']}',
'{$product['quantity']}',
'$product_total',
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
}



/* CLEAR CART */

mysqli_query($conn,

"DELETE FROM cart
WHERE user_id='$user_id'");



$msg = "All Orders Placed Successfully";

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Checkout All - MiniMart</title>

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



/* PRODUCT */

.product-box{

display:flex;

align-items:center;

gap:18px;

padding:18px;

background:#111827;

border-radius:18px;

margin-bottom:18px;
}



/* IMAGE */

.product-img{

width:90px;

height:90px;

object-fit:cover;

border-radius:14px;
}



/* TITLE */

.product-title{

font-size:20px;

font-weight:700;
}



/* PRICE */

.product-price{

font-size:22px;

font-weight:700;

color:#00bfff;
}



/* TOTAL */

.total-box{

padding:25px;

background:#111827;

border-radius:20px;

margin-top:30px;
}



/* TOTAL PRICE */

.total-price{

font-size:40px;

font-weight:800;

color:#00bfff;
}



/* INPUT */

.theme-input{

width:100%;
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

height:120px;

padding-top:15px;
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

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="checkout-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

Checkout All Products

</h1>

<p class="theme-subtitle text-center mb-5">

Complete all cart orders together

</p>



<?php
if($msg != ""){
?>

<div class="alert alert-success">

<?php echo $msg; ?>

</div>

<?php } ?>



<div class="row g-5">



<!-- PRODUCTS -->

<div class="col-lg-5">

<div class="checkout-card glass-card">

<h3 class="mb-4">

Cart Products

</h3>



<?php
foreach($products as $product){
?>



<div class="product-box">

<img src="uploads/<?php echo $product['image']; ?>"
class="product-img">

<div>

<div class="product-title">

<?php echo $product['product_name']; ?>

</div>

<div class="product-price">

₹ <?php echo $product['price']; ?>

</div>

<div class="mt-2">

Qty:
<b>

<?php echo $product['quantity']; ?>

</b>

</div>

</div>

</div>

<?php } ?>



<div class="total-box">

<h4>Total Amount</h4>

<div class="total-price">

₹ <?php echo $total; ?>

</div>

</div>

</div>

</div>



<!-- FORM -->

<div class="col-lg-7">

<div class="checkout-card glass-card">

<form method="POST"
enctype="multipart/form-data">



<div class="row">



<!-- MOBILE -->

<div class="col-md-6 mb-4">

<label class="mb-2">

Mobile Number

</label>

<input type="text"
name="mobile"
class="theme-input"
required>

</div>



<!-- DELIVERY -->

<div class="col-md-6 mb-4">

<label class="mb-2">

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

<div class="col-12 mb-4">

<label class="mb-2">

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

<label class="mb-2">

Address

</label>

<textarea
name="address"
class="theme-input"
required></textarea>

</div>



<!-- CITY -->

<div class="col-md-4 mb-4">

<label class="mb-2">

City

</label>

<input type="text"
name="city"
class="theme-input"
required>

</div>



<!-- STATE -->

<div class="col-md-4 mb-4">

<label class="mb-2">

State

</label>

<input type="text"
name="state"
class="theme-input"
required>

</div>



<!-- PINCODE -->

<div class="col-md-4 mb-4">

<label class="mb-2">

Pincode

</label>

<input type="text"
name="pincode"
class="theme-input"
required>

</div>



<!-- SCREENSHOT -->

<div class="col-12 mb-4">

<label class="mb-2">

Payment Screenshot

</label>

<input type="file"
name="payment_screenshot"
class="theme-input">

</div>

</div>



<button type="submit"
name="place_order"
class="checkout-btn">

Place All Orders

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