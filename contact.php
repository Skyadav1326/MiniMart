<?php include 'includes/navbar.php'; ?>

<!DOCTYPE html>
<html>

<head>

<title>Contact Us</title>

<link rel="stylesheet"
href="assets/css/theme.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

.contact-section{

padding:80px 0;
}

.contact-card{

padding:45px;

border-radius:30px;
}

textarea.theme-input{

height:160px;

padding-top:15px;
}

.contact-btn{

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



<section class="contact-section">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="contact-card glass-card">

<h1 class="theme-title text-center mb-3">

Contact Us

</h1>

<p class="theme-subtitle text-center mb-5">

Send your message to MiniMart

</p>



<form>



<div class="row">



<div class="col-md-6 mb-4">

<input type="text"
class="theme-input"
placeholder="Your Name">

</div>



<div class="col-md-6 mb-4">

<input type="email"
class="theme-input"
placeholder="Your Email">

</div>



<div class="col-12 mb-4">

<textarea
class="theme-input"
placeholder="Write your message..."></textarea>

</div>

</div>



<button class="contact-btn">

Send Message

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