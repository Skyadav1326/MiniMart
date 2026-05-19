<?php
session_start();
include 'db.php';



/* ADD TO CART */

if(
isset($_GET['cart'])
&& isset($_SESSION['user_id'])
){

$user_id = $_SESSION['user_id'];

$product_id = $_GET['cart'];



$checkCart = mysqli_query($conn,

"SELECT * FROM cart

WHERE user_id='$user_id'

AND product_id='$product_id'");



if(mysqli_num_rows($checkCart) == 0){

mysqli_query($conn,

"INSERT INTO cart

(user_id,product_id,quantity)

VALUES

('$user_id','$product_id','1')");
}

}



/* ADD TO WISHLIST */

if(
isset($_GET['wishlist'])
&& isset($_SESSION['user_id'])
){

$user_id = $_SESSION['user_id'];

$product_id = $_GET['wishlist'];



$checkWish = mysqli_query($conn,

"SELECT * FROM wishlist

WHERE user_id='$user_id'

AND product_id='$product_id'");



if(mysqli_num_rows($checkWish) == 0){

mysqli_query($conn,

"INSERT INTO wishlist

(user_id,product_id)

VALUES

('$user_id','$product_id')");
}

}



/* SEARCH */

$search = "";

if(isset($_GET['search'])){

$search =
mysqli_real_escape_string($conn,
$_GET['search']);
}



/* CATEGORY */

$category = "";

if(isset($_GET['category'])){

$category =
mysqli_real_escape_string($conn,
$_GET['category']);
}



/* QUERY */

$sql =

"SELECT * FROM products
WHERE 1";



if($search != ""){

$sql .=

" AND product_name
LIKE '%$search%'";
}



if($category != ""){

$sql .=

" AND category='$category'";
}



$sql .= " ORDER BY id DESC";

$query = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>Products - MiniMart</title>

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

.products-section{

padding:70px 0;
}



/* FILTER */

.filter-box{

padding:30px;

border-radius:24px;

margin-bottom:50px;
}



/* SEARCH */

.search-input{

width:100%;
}



/* CATEGORY */

.category-btn{

display:inline-block;

padding:12px 22px;

background:#111827;

border-radius:50px;

color:white;

margin:8px;

transition:0.3s;
}

.category-btn:hover{

background:#00bfff;

color:white;
}



/* PRODUCT CARD */

.product-card{

position:relative;
}



/* PRODUCT IMAGE */

.product-img{

height:270px;
}



/* ICONS */

.icon-group{

position:absolute;

top:15px;

right:15px;

display:flex;

flex-direction:column;

gap:12px;
}



/* ICON BTN */

.icon-btn{

width:46px;

height:46px;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

background:white;

color:black;

transition:0.3s;
}

.icon-btn:hover{

background:#00bfff;

color:white;

transform:scale(1.1);
}



/* BUTTON */

.buy-btn{

display:block;

width:100%;

height:52px;

border:none;

border-radius:14px;

background:linear-gradient(to right,#00bfff,#0066ff);

color:white;

font-weight:600;

margin-top:18px;
}



/* EMPTY */

.empty-box{

text-align:center;

padding:90px 20px;
}

.empty-box i{

font-size:90px;

color:#00bfff;

margin-bottom:25px;
}



/* RESPONSIVE */

@media(max-width:768px){

.filter-box{

padding:20px;
}

}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- PRODUCTS -->

<section class="products-section">

<div class="container">



<h1 class="theme-title text-center mb-3">

Shop Products

</h1>

<p class="theme-subtitle text-center mb-5">

Browse premium products

</p>



<!-- FILTER -->

<div class="filter-box glass-card">



<form method="GET">

<div class="row align-items-center">



<!-- SEARCH -->

<div class="col-md-6 mb-3">

<input type="text"
name="search"
class="theme-input search-input"
placeholder="Search products..."
value="<?php echo $search; ?>">

</div>



<!-- CATEGORY -->

<div class="col-md-4 mb-3">

<select name="category"
class="theme-input">

<option value="">

All Categories

</option>

<option>Clothing & Fashion</option>

<option>Electronics & Gadgets</option>

<option>Grocery & Daily Needs</option>

<option>Food & Restaurant</option>

<option>Beauty & Cosmetics</option>

<option>Footwear</option>

<option>Furniture</option>

<option>Mobile Accessories</option>

<option>Books & Stationery</option>

<option>Sports & Fitness</option>

<option>Toys & Gifts</option>

<option>Medical & Pharmacy</option>

<option>Jewellery</option>

<option>Pet Shop</option>

<option>Hardware</option>

<option>Automobile</option>

<option>Other</option>

</select>

</div>



<!-- BUTTON -->

<div class="col-md-2 mb-3">

<button class="theme-btn w-100">

Search

</button>

</div>

</div>

</form>

</div>



<!-- PRODUCTS -->

<div class="row">

<?php

if(mysqli_num_rows($query) > 0){

while($row = mysqli_fetch_assoc($query)){

?>



<div class="col-lg-3 col-md-6 mb-5">

<div class="product-card glass-card">



<!-- IMAGE -->

<img src="uploads/<?php echo $row['image']; ?>"
class="product-img w-100">



<!-- ICONS -->

<div class="icon-group">



<a href="?cart=<?php echo $row['id']; ?>"
class="icon-btn">

<i class="fa-solid fa-cart-shopping"></i>

</a>



<a href="?wishlist=<?php echo $row['id']; ?>"
class="icon-btn">

<i class="fa-solid fa-heart"></i>

</a>

</div>



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



<p class="mt-3 text-light">

<?php echo substr($row['description'],0,80); ?>

...

</p>



<a href="checkout.php?id=<?php echo $row['id']; ?>">

<button class="buy-btn">

Buy Now

</button>

</a>

</div>

</div>

</div>

<?php } } else { ?>



<div class="empty-box">

<i class="fa-solid fa-box-open"></i>

<h2>

No Products Found

</h2>

</div>

<?php } ?>

</div>

</div>

</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>