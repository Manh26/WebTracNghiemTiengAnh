<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">

<head>
	<title>LOGIN</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Glassy Login Form Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements" />
	
	<link rel="stylesheet" href="css/font-awesome.css"> <!-- Font-Awesome-Icons-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" /> <!-- Style-CSS -->
	<!-- //css files -->
	<!-- web-fonts -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700" rel="stylesheet">
	<!-- //web-fonts -->

</head>
<<body>
	<header>
		<div class="header-w3l">
			<h1></h1>
		</div>
		<!--//header-->
		<!--main-->
		<div class="main-w3layouts-agileinfo">
			<!--form-stars-here-->
			<div class="wthree-form">
				<h2>Register</h2>

				<form name="registrationForm" action="register.php" method="post" onsubmit="return validateForm()">
					<div class="form-sub-w3">
						<input type="text" name="Username" placeholder="Username " required="" />
						<div class="icon-w3">
							<i class="fa fa-user" aria-hidden="true"></i>
						</div>
					</div>

					<div class="form-sub-w3">
						<input type="text" name="Email" placeholder="email " required="" />
						<div class="icon-w3">
							<i class="fa fa-user" aria-hidden="true"></i>
						</div>
					</div>
					<div class="form-sub-w3">
						<input type="password" name="Password" placeholder="Password" required="" />
						<div class="icon-w3">
							<i class="fa fa-unlock-alt" aria-hidden="true"></i>
						</div>
					</div>
					<div class="form-sub-w3">
						<input type="password" name="ConfirmPassword" placeholder="ConfirmPassword " required="" />
						<div class="icon-w3">
						<i class="fa fa-unlock-alt" aria-hidden="true"></i>
						</div>
					</div>
		
					<div class="clear"></div>
					<div class="submit-agileits">
						<input type="submit" value="Register">
					</div>
				</form>
			</div>
			<!--//form-ends-here-->







		</div>
		<!--//main-->
		<!--footer-->
		<div class="footer">
			<!-- <p>&copy; 2017 Glassy Login Form. All rights reserved | Design by <a href="http://w3layouts.com"></a></p> -->
		</div>

		<script>
			function validateForm() {
				var username = document.forms["registrationForm"]["Username"].value;
				var email = document.forms["registrationForm"]["Email"].value;
				var password = document.forms["registrationForm"]["Password"].value;
				var confirmPassword = document.forms["registrationForm"]["ConfirmPassword"].value;

				// Kiểm tra username
				if (username == "") {
					alert("Please enter your username.");
					return false;
				}

				// Kiểm tra email
				if (email == "") {
					alert("Please enter your email.");
					return false;
				} else {
					var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
					if (!emailPattern.test(email)) {
						alert("Invalid email format. Please enter a valid email address.");
						return false;
					}
				}

				// Kiểm tra password
				if (password == "") {
					alert("Please enter your password.");
					return false;
				}
				var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
				if (!passwordPattern.test(password)) {
					alert("Password must contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.");
					return false;
				}
				// Kiểm tra confirmPassword
				if (confirmPassword == "") {
					alert("Please confirm your password.");
					return false;
				}

				// So sánh password và confirmPassword
				if (password != confirmPassword) {
					alert("Passwords do not match. Please try again.");
					return false;
				}

				return true;
			}
		</script>
		<!--//footer-->
		</body>


</html>