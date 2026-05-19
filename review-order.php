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



/* REVIEW */

if(isset($_POST['submit_review'])){


$rating =
mysqli_real_escape_string($conn,
$_POST['rating']);



$review =
mysqli_real_escape_string($conn,
$_POST['review']);



/* UPDATE ORDER */

mysqli_query($conn,

"UPDATE orders

SET rating='$rating',
review='$review'

WHERE id='$order_id'");



/* INSERT REVIEW */

mysqli_query($conn,

"INSERT INTO reviews

(user_id,
product_id,
order_id,
rating,
review)

VALUES

('$user_id',
'{$order['product_id']}',
'$order_id',
'$rating',
'$review')");



$msg = "Review Submitted Successfully";

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Review Product - MiniMart</title>

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

.review-section{

padding:70px 0;
}



/* CARD */

.review-card{

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



/* STARS */

.star-box{

display:flex;

gap:15px;

margin-top:25px;

margin-bottom:25px;
}



/* STAR */

.star{

font-size:40px;

cursor:pointer;

color:#374151;

transition:0.3s;
}

.star.active{

color:#facc15;
}



/* TEXTAREA */

textarea.theme-input{

height:180px;

padding-top:18px;

width:100%;
}



/* BUTTON */

.review-btn{

width:100%;

height:58px;

border:none;

border-radius:14px;

background:#06b6d4;

color:white;

font-size:20px;

font-weight:700;

margin-top:25px;
}



/* HIDDEN */

.rating-input{

display:none;
}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="review-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

Write Review

</h1>

<p class="theme-subtitle text-center mb-5">

Share your product experience

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

<div class="review-card glass-card">

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

<div class="review-card glass-card">

<form method="POST">



<label class="mb-3">

Give Rating

</label>



<div class="star-box">

<i class="fa-solid fa-star star"
data-value="1"></i>

<i class="fa-solid fa-star star"
data-value="2"></i>

<i class="fa-solid fa-star star"
data-value="3"></i>

<i class="fa-solid fa-star star"
data-value="4"></i>

<i class="fa-solid fa-star star"
data-value="5"></i>

</div>



<input type="hidden"
name="rating"
id="ratingInput"
class="rating-input"
required>



<label class="mb-3">

Write Review

</label>

<textarea
name="review"
class="theme-input"
placeholder="Write your review..."
required></textarea>



<button type="submit"
name="submit_review"
class="review-btn">

Submit Review

</button>

</form>

</div>

</div>

</div>

</div>

</section>



<script>

const stars =
document.querySelectorAll('.star');

const ratingInput =
document.getElementById('ratingInput');



stars.forEach(star => {

star.addEventListener('click', () => {

const value =
star.getAttribute('data-value');



ratingInput.value = value;



stars.forEach(s => {

s.classList.remove('active');
});



for(let i=0; i<value; i++){

stars[i].classList.add('active');
}

});

});

</script>
<?php include 'includes/footer.php'; ?>
</body>
</html>