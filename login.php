<?php require_once 'includes/config.php';
isset($_SERVER['HTTP_REFERER']) && !isset($_SESSION['REFERER']) ? $_SESSION['REFERER'] = $_SERVER['HTTP_REFERER'] : 0;
isset($_SESSION['CUSTOMER']) ? redirect("index") : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Swadesh Restaurant - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Google Fonts -->
	<link rel="stylesheet" href="css/fonts.css">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="img/favicon.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="lib/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="loginpage/css/util.css">
	<link rel="stylesheet" type="text/css" href="loginpage/css/main.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="loginpage/css/login.css">
</head>

<body style="background-color: #666666;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<?php
				if (isset($_GET['forgotPassword'])) {
					include('forgotPassword.php');
				} else {
					include('loginAccount.php');
				}
				?>
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
								<a href="<?php echo $goback; ?>"><button class="login100-form-btn">Go back</button></a>
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
	<script src="loginpage/js/main.js"></script>
	<script src="js/main.js"></script>
	<script>
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
</body>

</html>