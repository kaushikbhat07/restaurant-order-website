<?php include("includes/front/top.php"); ?>
<?php if (!isset($_SESSION['CUSTOMER']['ADDRESSID'])) {
	redirect("index");
} //disallowing access 
?>

<link rel="stylesheet" type="text/css" href="css/checkout.css">
<link rel="stylesheet" href="css/thankyou.css">
</head>

<body>

	<!--==========================
    Header
  ============================-->
	<?php include("includes/front/header_static.php"); ?>

	<main id="main">
		<!--==========================
     Cart Section
    ============================-->
		<section id="about">
			<div class="container">

				<header class="section-header">
					<?php
					if (isset($_POST["STATUS"])) {
						if ($_POST["STATUS"] == "TXN_SUCCESS") {
							echo '<h3>ORDER PLACED</h3>';
						} else {
							echo '<h3>ORDER NOT PLACED</h3>';
						}
					} else {
						echo '<h3>ORDER PLACED</h3>';
					}
					?>
				</header>

				<!-- <div class=" about-cols"> -->

				<!-- <div class="row"> -->

				<div class="jumbotron text-center">

					<?php
					if (isset($_POST['CHECKSUMHASH'])) {
						include 'PaytmKit/pgResponse.php';
					} else {
						echo '<h1 class="display-3">Thank You!</h1>';
						echo '<p class="lead">Your order (ID: ' . $_POST['ORDERID'] . ') should be arriving soon. <strong>Please check your email</strong> for the order bill/receipt. Please keep &#8377; ' . $_POST['AMOUNT'] . ' cash ready. </p>';
						$cust->place_order_cash($_POST['ORDERID'], $_POST['CUSTID'], $_POST['AMOUNT'], $_SESSION['CUSTOMER']['ADDRESSID']);
						$cust->mail_order_cash($_POST['ORDERID'], $_POST['AMOUNT'], $_SESSION['CUSTOMER']['NAME'], $_SESSION['CUSTOMER']['EMAIL']);
						unset($_SESSION['CUSTOMER']['ADDRESSID']);
						// unset($_SESSION['CART']);
					}

					?>

					<hr>
					<p>
						Having trouble? <a href="index#contact">Contact us</a>
					</p>
					<p class="lead">
						<a class="btn btn-dark btn-md" href="index" role="button">Continue to homepage</a>
					</p>
				</div>

				<!-- </div> -->



				<!-- </div> -->

			</div>
		</section><!-- #about -->

	</main>

	<!--==========================
    Footer
  ============================-->


	<?php include("includes/front/footer.php"); ?>