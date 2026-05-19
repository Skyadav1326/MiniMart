<?php
session_start();
include 'db.php';

$msg = "";



/* LOGIN */

if(isset($_POST['login'])){


$email =
mysqli_real_escape_string($conn,
$_POST['email']);



$password =
mysqli_real_escape_string($conn,
$_POST['password']);



$query = mysqli_query($conn,

"SELECT * FROM users

WHERE email='$email'

AND password='$password'");



if(mysqli_num_rows($query) > 0){

$user = mysqli_fetch_assoc($query);



$_SESSION['user_id'] = $user['id'];

$_SESSION['role'] = $user['role'];



/* REDIRECT */

if($user['role'] == "seller"){

header("location:seller/seller-dashboard.php");
exit();
}



if($user['role'] == "delivery"){

header("location:delivery/delivery-order.php");
exit();
}



header("location:index.php");
exit();

}else{

$msg = "Invalid Email or Password";
}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login - MiniMart</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>



/* SECTION */

.login-section{

min-height:100vh;

display:flex;

align-items:center;

justify-content:center;

padding:40px 20px;

background:
linear-gradient(rgba(0,0,0,0.8),
rgba(0,0,0,0.8)),

url('https://images.unsplash.com/photo-1556740749-887f6717d7e4?q=80&w=1400');

background-size:cover;

background-position:center;
}



/* BOX */

.login-box{

width:100%;

max-width:520px;

padding:45px;

border-radius:30px;
}



/* INPUT */

.theme-input{

width:100%;
}



/* TEXT */

.bottom-text{

color:#d1d5db;
}

.bottom-text a{

color:#00bfff;

font-weight:600;
}

</style>

</head>

<body>



<section class="login-section">

<div class="login-box glass-card">

<h1 class="theme-title text-center mb-3">

Welcome Back

</h1>

<p class="theme-subtitle text-center mb-5">

Login to continue shopping

</p>



<?php
if($msg != ""){
?>

<div class="alert alert-danger">

<?php echo $msg; ?>

</div>

<?php } ?>



<form method="POST">



<!-- EMAIL -->

<div class="mb-4">

<input type="email"
name="email"
class="theme-input"
placeholder="Enter Email Address"
required>

</div>



<!-- PASSWORD -->

<div class="mb-4">

<input type="password"
name="password"
class="theme-input"
placeholder="Enter Password"
required>

</div>



<!-- BUTTON -->

<button type="submit"
name="login"
class="theme-btn w-100">

Login

</button>



<div class="text-center mt-4 bottom-text">

Don't have an account?

<a href="register.php">

Create Account

</a>

</div>

</form>

</div>

</section>
<?php include 'includes/footer.php'; ?>
</body>
</html>