<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){

header("location:login.php");
exit();
}

$user_id = $_SESSION['user_id'];



/* USER */

$query = mysqli_query($conn,

"SELECT * FROM users
WHERE id='$user_id'");

$user = mysqli_fetch_assoc($query);



$msg = "";



/* UPDATE PROFILE */

if(isset($_POST['update_profile'])){


$name =
mysqli_real_escape_string($conn,
$_POST['name']);



$mobile =
mysqli_real_escape_string($conn,
$_POST['mobile']);



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



$upi_id = "";

if(isset($_POST['upi_id'])){

$upi_id =
mysqli_real_escape_string($conn,
$_POST['upi_id']);
}



/* IMAGE */

$profile_image = $user['profile_image'];

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



/* UPI QR */

$upi_qr = $user['upi_qr'];

if(
isset($_FILES['upi_qr']['name'])
&& !empty($_FILES['upi_qr']['name'])
){

$upi_qr =
time() . "_" .
$_FILES['upi_qr']['name'];

$tmp =
$_FILES['upi_qr']['tmp_name'];

move_uploaded_file($tmp,

"uploads/" . $upi_qr);
}



/* UPDATE */

mysqli_query($conn,

"UPDATE users SET

name='$name',
mobile='$mobile',
address='$address',
city='$city',
state='$state',
pincode='$pincode',
profile_image='$profile_image',
upi_id='$upi_id',
upi_qr='$upi_qr'

WHERE id='$user_id'");



$msg = "Profile Updated Successfully";



/* REFRESH */

$query = mysqli_query($conn,

"SELECT * FROM users
WHERE id='$user_id'");

$user = mysqli_fetch_assoc($query);

}
?>

<!DOCTYPE html>
<html>

<head>

<title>My Profile - MiniMart</title>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>



/* SECTION */

.profile-section{

padding:70px 0;
}



/* CARD */

.profile-card{

padding:35px;

border-radius:28px;
}



/* IMAGE */

.profile-img{

width:180px;

height:180px;

border-radius:50%;

object-fit:cover;

border:5px solid #00bfff;
}



/* TITLE */

.profile-title{

font-size:40px;

font-weight:800;

margin-top:25px;
}



/* ROLE */

.role-badge{

display:inline-block;

padding:10px 22px;

border-radius:50px;

background:#00bfff;

margin-top:15px;

font-weight:700;
}



/* INPUT */

.theme-input{

width:100%;
}



/* TEXTAREA */

textarea.theme-input{

height:130px;

padding-top:15px;
}



/* BUTTON */

.update-btn{

width:100%;

height:58px;

border:none;

border-radius:14px;

background:linear-gradient(to right,#00bfff,#0066ff);

color:white;

font-size:20px;

font-weight:700;

margin-top:25px;
}



/* QR */

.qr-img{

width:220px;

border-radius:20px;

margin-top:20px;
}

</style>

</head>

<body>



<!-- NAVBAR -->

<?php include 'includes/navbar.php'; ?>



<!-- SECTION -->

<section class="profile-section">

<div class="container">

<h1 class="theme-title text-center mb-3">

My Profile

</h1>

<p class="theme-subtitle text-center mb-5">

Manage your account details

</p>



<?php
if($msg != ""){
?>

<div class="alert alert-success">

<?php echo $msg; ?>

</div>

<?php } ?>



<div class="row g-5">



<!-- PROFILE -->

<div class="col-lg-4">

<div class="profile-card glass-card text-center">

<?php
if($user['profile_image'] != ""){
?>

<img src="uploads/<?php echo $user['profile_image']; ?>"
class="profile-img">

<?php } else { ?>

<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
class="profile-img">

<?php } ?>



<div class="profile-title">

<?php echo $user['name']; ?>

</div>



<div class="role-badge">

<?php echo ucfirst($user['role']); ?>

</div>



<?php
if($user['role']=="seller"){
?>

<div class="mt-4">

<h5>

Shop Name

</h5>

<p>

<?php echo $user['shop_name']; ?>

</p>

</div>



<div class="mt-3">

<h5>

Shop Category

</h5>

<p>

<?php echo $user['shop_category']; ?>

</p>

</div>

<?php } ?>

</div>

</div>



<!-- FORM -->

<div class="col-lg-8">

<div class="profile-card glass-card">

<form method="POST"
enctype="multipart/form-data">



<div class="row">



<!-- NAME -->

<div class="col-md-6 mb-4">

<label class="mb-2">

Full Name

</label>

<input type="text"
name="name"
value="<?php echo $user['name']; ?>"
class="theme-input"
required>

</div>



<!-- MOBILE -->

<div class="col-md-6 mb-4">

<label class="mb-2">

Mobile Number

</label>

<input type="text"
name="mobile"
value="<?php echo $user['mobile']; ?>"
class="theme-input">

</div>



<!-- PROFILE -->

<div class="col-md-6 mb-4">

<label class="mb-2">

Profile Image

</label>

<input type="file"
name="profile_image"
class="theme-input">

</div>



<?php
if($user['role']=="seller"){
?>



<!-- UPI ID -->

<div class="col-md-6 mb-4">

<label class="mb-2">

UPI ID

</label>

<input type="text"
name="upi_id"
value="<?php echo $user['upi_id']; ?>"
class="theme-input">

</div>



<!-- UPI QR -->

<div class="col-12 mb-4">

<label class="mb-2">

Upload UPI QR

</label>

<input type="file"
name="upi_qr"
class="theme-input">

</div>



<?php
if($user['upi_qr'] != ""){
?>

<div class="col-12 mb-4 text-center">

<img src="uploads/<?php echo $user['upi_qr']; ?>"
class="qr-img">

</div>

<?php } ?>



<?php } ?>



<!-- ADDRESS -->

<div class="col-12 mb-4">

<label class="mb-2">

Address

</label>

<textarea
name="address"
class="theme-input"><?php echo $user['address']; ?></textarea>

</div>



<!-- CITY -->

<div class="col-md-4 mb-4">

<label class="mb-2">

City

</label>

<input type="text"
name="city"
value="<?php echo $user['city']; ?>"
class="theme-input">

</div>



<!-- STATE -->

<div class="col-md-4 mb-4">

<label class="mb-2">

State

</label>

<input type="text"
name="state"
value="<?php echo $user['state']; ?>"
class="theme-input">

</div>



<!-- PINCODE -->

<div class="col-md-4 mb-4">

<label class="mb-2">

Pincode

</label>

<input type="text"
name="pincode"
value="<?php echo $user['pincode']; ?>"
class="theme-input">

</div>

</div>



<button type="submit"
name="update_profile"
class="update-btn">

Update Profile

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