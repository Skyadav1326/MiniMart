<?php
session_start();
include 'db.php';

$msg = "";



/* REGISTER */

if(isset($_POST['register'])){


$name =
mysqli_real_escape_string($conn,
$_POST['name']);



$email =
mysqli_real_escape_string($conn,
$_POST['email']);



$mobile =
mysqli_real_escape_string($conn,
$_POST['mobile']);



$password =
mysqli_real_escape_string($conn,
$_POST['password']);



$role =
mysqli_real_escape_string($conn,
$_POST['role']);



$shop_name = "";

$shop_category = "";



/* SELLER EXTRA */

if($role == "seller"){

$shop_name =
mysqli_real_escape_string($conn,
$_POST['shop_name']);



$shop_category =
mysqli_real_escape_string($conn,
$_POST['shop_category']);
}



/* CHECK EMAIL */

$check = mysqli_query($conn,

"SELECT * FROM users
WHERE email='$email'");



if(mysqli_num_rows($check) > 0){

$msg = "Email Already Exists";

}else{



/* PROFILE IMAGE */

$profile_image = "";

if(
isset($_FILES['profile_image']['name'])
&& !empty($_FILES['profile_image']['name'])
){

$profile_image =
time() . "_" .
$_FILES['profile_image']['name'];

$tmp =
$_FILES['profile_image']['tmp_name'];

move_uploaded_file($tmp,

"uploads/" . $profile_image);
}



/* INSERT */

mysqli_query($conn,

"INSERT INTO users

(name,
email,
mobile,
password,
role,
profile_image,
shop_name,
shop_category)

VALUES

('$name',
'$email',
'$mobile',
'$password',
'$role',
'$profile_image',
'$shop_name',
'$shop_category')");



$msg = "Registration Successful";

}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Register - MiniMart</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>



/* SECTION */

.register-section{

min-height:100vh;

display:flex;

align-items:center;

justify-content:center;

padding:60px 20px;

background:
linear-gradient(rgba(0,0,0,0.8),
rgba(0,0,0,0.8)),

url('https://images.unsplash.com/photo-1556740749-887f6717d7e4?q=80&w=1400');

background-size:cover;

background-position:center;
}



/* BOX */

.register-box{

width:100%;

max-width:850px;

padding:45px;

border-radius:30px;
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



/* IMAGE */

.preview{

width:140px;

height:140px;

border-radius:50%;

object-fit:cover;

display:none;

margin:auto;

margin-top:20px;

border:4px solid #00bfff;
}



/* HIDE */

.seller-fields{

display:none;
}

</style>

</head>

<body>



<section class="register-section">

<div class="register-box glass-card">

<h1 class="theme-title text-center mb-3">

Create Account

</h1>

<p class="theme-subtitle text-center mb-5">

Join MiniMart Premium Ecommerce

</p>



<?php
if($msg != ""){
?>

<div class="alert alert-info">

<?php echo $msg; ?>

</div>

<?php } ?>



<form method="POST"
enctype="multipart/form-data">



<div class="row">



<!-- NAME -->

<div class="col-md-6 mb-4">

<input type="text"
name="name"
class="theme-input"
placeholder="Full Name"
required>

</div>



<!-- EMAIL -->

<div class="col-md-6 mb-4">

<input type="email"
name="email"
class="theme-input"
placeholder="Email Address"
required>

</div>



<!-- MOBILE -->

<div class="col-md-6 mb-4">

<input type="text"
name="mobile"
class="theme-input"
placeholder="Mobile Number"
required>

</div>



<!-- PASSWORD -->

<div class="col-md-6 mb-4">

<input type="password"
name="password"
class="theme-input"
placeholder="Password"
required>

</div>



<!-- ROLE -->

<div class="col-md-6 mb-4">

<select name="role"
class="theme-input"
required
onchange="toggleSeller(this.value)">

<option value="">

Select Role

</option>

<option value="customer">

Customer

</option>

<option value="seller">

Seller

</option>

<option value="delivery">

Delivery Boy

</option>

</select>

</div>



<!-- IMAGE -->

<div class="col-md-6 mb-4">

<input type="file"
name="profile_image"
class="theme-input"
accept="image/*"
onchange="previewImage(event)">

</div>

</div>



<!-- PREVIEW -->

<div class="text-center">

<img id="preview"
class="preview">

</div>



<!-- SELLER FIELDS -->

<div class="seller-fields"
id="sellerFields">

<div class="row mt-4">



<div class="col-md-6 mb-4">

<input type="text"
name="shop_name"
class="theme-input"
placeholder="Shop Name">

</div>



<div class="col-md-6 mb-4">

<select name="shop_category"
class="theme-input">

<option value="">

Select Shop Category

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

</div>

</div>



<button type="submit"
name="register"
class="theme-btn w-100 mt-4">

Create Account

</button>



<div class="text-center mt-4">

Already have an account?

<a href="login.php"
class="text-info">

Login

</a>

</div>

</form>

</div>

</section>



<script>

function toggleSeller(role){

let sellerFields =
document.getElementById('sellerFields');

if(role == "seller"){

sellerFields.style.display = "block";
}
else{

sellerFields.style.display = "none";
}

}



/* IMAGE PREVIEW */

function previewImage(event){

const reader = new FileReader();

reader.onload = function(){

const output =
document.getElementById('preview');

output.src = reader.result;

output.style.display = 'block';
}

reader.readAsDataURL(event.target.files[0]);

}

</script>
<?php include 'includes/footer.php'; ?>
</body>
</html>