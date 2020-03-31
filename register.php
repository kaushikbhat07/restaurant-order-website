<?php require_once 'includes/config.php';
isset($_SESSION['CUSTOMER']) ? redirect("index") : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Swadesh Restaurant - Create Account</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Google Fonts -->
	<link href="css/fonts.css" rel="stylesheet">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="lib/font-awesome/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginpage/css/util.css">
	<link rel="stylesheet" type="text/css" href="loginpage/css/main.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="loginpage/css/register.css">
</head>

<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 form-row">
				<form class="login100-form validate-form needs-validation was-validated" method="POST" action="register" novalidate="">
					<span class="login100-form-title p-b-43">
						Create account
					</span>
					<?php
					if (!isset($_GET['s'])) {
						$cust->register_account();
					?>
						<div class="row">
							<div class="col-lg-6">

								<div class="wrap-input100 validate-input" data-validate="Do not leave name field blank">
									<input class="input100" type="text" name="fname" pattern="[A-Za-z]{2,30}" required="" data-toggle="tooltip" data-placement="top" data-original-title="Min 2 characters. Alphabets only.">
									<span class="focus-input100"></span>
									<span class="label-input100">First Name</span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="wrap-input100 validate-input" data-validate="Do not leave name field blank">
									<input class="input100" type="text" name="lname" pattern="[A-Za-z]{2,30}" required="" data-toggle="tooltip" data-placement="top" data-original-title="Min 2 characters. Alphabets only.">
									<span class="focus-input100"></span>
									<span class="label-input100">Last Name</span>
								</div>
							</div>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
							<input class="input100" type="text" name="email" required="">
							<span class="focus-input100"></span>
							<span class="label-input100">Email</span>
						</div>
						<hr>
						<div class="wrap-input100 validate-input" data-validate="Password is required">
							<input class="input100" type="password" name="pass" pattern=".{6,}" data-toggle="tooltip" data-placement="top" data-original-title="Min 6 characters." required="">
							<span class="focus-input100"></span>
							<span class="label-input100">Password</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Password is required">
							<input class="input100" type="password" name="pass_confirm" pattern=".{6,}" data-toggle="tooltip" data-placement="top" data-original-title="Min 6 characters." required="">
							<span class="focus-input100"></span>
							<span class="label-input100">Confirm Password</span>
						</div>

						<div class="flex-sb-m w-full p-t-3 p-b-32">
							<div class="contact100-form-checkbox">
								<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember_me">
								<label class="label-checkbox100" for="ckb1">
									Remember me
								</label>
							</div>

						</div>


						<div class="container-login100-form-btn">
							<button type="submit" class="login100-form-btn" name="register_submit">
								Create Account
							</button>
						</div>

						<div class="text-center p-t-46 p-b-20">
							<span class="no-account">
								Already have an account? <span class="no-account-a"><a href="login">Click here</a></span> to sign in.
							</span>
						</div>
						<div>
							<?php isset($_SERVER['HTTP_REFERER']) ? $goback = $_SERVER['HTTP_REFERER'] : $goback = "index" ?>
							<a href="<?php echo $goback; ?>"><button type="button" class="go-back-phone login100-form-btn">Go back</button></a>
						</div>
					<?php
					}
					if (isset($_GET['s'])) {
						if ($_GET['s'] == 1 && isset($_GET['cid'])) {
							setMessage("A verification link has been sent to your Email ID. Please click on the link and verify your email ID. <a href='register?s=1&cid=" . $_GET['cid'] . "&resend'>Click here</a> to resend the verification link. ");
							$cust->resend_verify_email();
						}
						if ($_GET['s'] == 1 && isset($_GET['resend']) && !isset($_GET['cid'])) {
							$cust->resend_verify_email();
						}
						if ($_GET['s'] == 2 && isset($_GET['email']) && isset($_GET['key'])) {
							$cust->verify_email();
						}
					}
					?>
				</form>
				<script>
					// Example starter JavaScript for disabling form submissions if there are invalid fields
					(function() {
						'use strict';
						window.addEventListener('load', function() {
							// Fetch all the forms we want to apply custom Bootstrap validation styles to
							var forms = document.getElementsByClassName('needs-validation');
							// Loop over them and prevent submission
							var validation = Array.prototype.filter.call(forms, function(form) {
								form.addEventListener('submit', function(event) {
									if (form.checkValidity() === false) {
										event.preventDefault();
										event.stopPropagation();
									}
									form.classList.add('was-validated');
								}, false);
							});
						}, false);
					})();
				</script>

				<div class="login100-more" style="background-image: url('loginpage/images/login_copy.jpg');">
					<div id="header">
						<div id="logo" class="pull-left">
							<h1><a href="index#intro" class="scrollto">Swadesh</a></h1>
							<!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
						</div>
					</div>
					<footer id="footer">
						<div class="container">
							<div class="row">
								<?php isset($_SERVER['HTTP_REFERER']) ? $goback = $_SERVER['HTTP_REFERER'] : $goback = "index" ?>
								<a href="<?php echo $goback ?>"><button class="login100-form-btn">Go back</button></a>
							</div>
						</div>
					</footer>
				</div>

			</div>
		</div>
	</div>
	<div id="preloader"></div>
	<!--===============================================================================================-->
	<script src="lib/jquery/jquery.min.js"></script>

	<script src="loginpage/vendor/bootstrap/js/popper.js"></script>
	<script src="lib/bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	<!--===============================================================================================-->
	<script src="loginpage/js/main.js"></script>
	<script src="js/main.js"></script>
</body>

</html>