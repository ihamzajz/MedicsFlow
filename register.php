<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon1.png"/>

		<!-- css plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
	<!--main css-->
	<link rel="stylesheet" href="assets/css/style.css">

	<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
</head>
<body>

	<div class="section-3">
		<div class="row align-items-center ">
			<div class="col-md-4 text-center justify-content-center d-none d-md-block">
					<p class="section3-p pt-5 m-0" data-aos="fade-down" data-aos-delay="100" data-aos-duration="500">Medic Laboratories</p>

					<span class="bg-span" data-aos="fade-left" data-aos-delay="150" data-aos-duration="500">Nature</span>
					<p class="section3-p2" data-aos="fade-right" data-aos-delay="150" data-aos-duration="500">Inspired</p>

   			     <div class="footer-lis pt-2 text-center">
              <ul class="d-flex text-center">
                  <li><a href="https://https://www.medicslab.com"><i class="fab fa-facebook-f footer-icon"></i></a></li>
                  <li class="ml-3"><a href="https://twitter.com/"><i class="fab fa-twitter footer-icon"></i></a></li>
                  <li class="ml-3"><a href="https://www.instagram.com"><i class="fab fa-instagram footer-icon"></i></a></li>
                  <li class="ml-3"><a href="https://www.youtube.com"><i class="fab fa-youtube footer-icon"></i></a></li>
              </ul>
         		 </div>

			</div> <!--col1-->

			<div class="col-md-4 offset-md-3 my-auto">


			<form class="form pb-3"method="POST" style="border: 2px solid whites; padding: 25px; padding-bottom: 0px; border-radius: 5px; background-color: white;">

				<h2 class="text-center pb-3" style="font-size: 25px;color: #76be43;font-weight: bolder;">Create Account</h2>



			  	<div class="mb-1 form-group">
				    <label class="form-label labelf">Full name:</label>
				    <input type="text" class="form-control" name="reg_fname" required autocomplete="off">
				</div>

			  	<div class="mb-1 form-group">
				    <label class="form-label labelf">Username</label>
				    <input type="text" class="form-control" name="reg_uname" required autocomplete="off">
				</div>

			  	<div class="mb-1 form-group">
				    <label class="form-label labelf">Password</label>
				    <input type="password" class="form-control" name="reg_pwd" required autocomplete="off">
				</div>

			  	<div class="mb-1 form-group">
				    <label class="form-label labelf">Email</label>
				    <input type="email" class="form-control" name="reg_email" required autocomplete="off">
				</div>

	  		  <div class="form-group">
				<label class="form-label labelf" >Department:</label>
				<select class="form-control"  name="reg_department">
				  <option value="Human-Resource">Human-Resource</option>
				  <option value="Information-Technology">Information-Technology</option>
				  <option value="Finance">Finance</option>
				  <option value="Sales">Sales</option>
				  <option value="Marketing">Marketing</option>

				</select>
				</div>

				<div class="form-group mb-1">
					<label class="form-label labelf" >Gender</label>
					<label class="radio-inline"><input type="radio" name="ugender" value="Male">Male</label>
					<label class="radio-inline"> <input type="radio"  name="ugender" value="Female">Female</label>
					
				</div>

				<a href="login.php">Login</a>

				<!-- <button type="submit" class="btn btn-dark" name="reg_btn">Register</button> -->

		        <div class="text-center mt-3">
	              	<button type="submit" class="btn w-50 text-uppercase" style="background-color: #76be43;color: white;font-size: 17px;" name="reg_btn" style="font-size: 20px">Register</button>
	            </div>

			</form>



			</div> <!--col2-->
		</div> <!--row-->
	</div> <!--container-->

	<?php

	include 'dbconfig.php';
	if (isset($_POST['reg_btn'])) {

	date_default_timezone_set("Asia/Karachi");

	$fullname =  $_POST['reg_fname'];
	$username =  $_POST['reg_uname'];
	$password =  $_POST['reg_pwd'];
	$email =  $_POST['reg_email'];
	$department =  $_POST['reg_department'];
	$gender =  $_POST['ugender'];
	$date = date('Y-m-d');

	$insert = "INSERT INTO users (fullname,username,password,email,department,gender,added_date) VALUES ('$fullname','$username','$password','$email','$department','$gender','$date')";

	$insert_q=mysqli_query($conn,$insert);
	if ($insert_q) {
		?>
		<script type="text/javascript">
			alert("Registration Successful!");
			window.location.href = "login.php";
		</script>
		<?php
	}
	else
	{
		?>
		<script type="text/javascript">
			alert("Registration failed!");
			window.location.href = "register.php";
		</script>
		<?php
	}
	}

?>

 <!-- js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script src="assets/js/main.js"></script>

  <script>
    AOS.init({
        duration: 850,
        once: true,
    });
  </script>
</body>
</html>