<?php include("includes/front/top.php"); ?>
<?php if (!isset($_POST['checkout_submit'])) {
	redirect("cart");
} //disallowing access 
?>
<?php
if (isset($_POST['total_amount']) && isset($_POST['quantity']) && isset($_POST['handling_charge'])) {
	//condition 
	if (($_SESSION['CUSTOMER']['amountToPay'] != $_POST['total_amount']) || ($_SESSION['CUSTOMER']['totalQuantity'] != $_POST['quantity']) || ($_SESSION['CUSTOMER']['handling'] != $_POST['handling_charge'])) {
		redirect("cart");
		unset($_SESSION['CUSTOMER']['amountToPay']);
		unset($_SESSION['CUSTOMER']['totalQuantity']);
		unset($_SESSION['CUSTOMER']['handling']);
	} else {
		unset($_SESSION['CUSTOMER']['amountToPay']);
		unset($_SESSION['CUSTOMER']['totalQuantity']);
		unset($_SESSION['CUSTOMER']['handling']);
	}
}
?>
<link rel="stylesheet" href="css/checkout2.css">

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
					<h3>Checkout</h3>
				</header>

				<div class=" about-cols">

					<div class="row">
						<!-- <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5"> -->

						<!-- Shopping cart table -->
						<div class="col-md-4 order-md-2 mb-4">
							<?php $cust->display_cart_in_checkout(); ?>
							<?php //unset($_SESSION['CART']); 
							?>
						</div>
						<div class="col-md-8 order-md-1">
							<h4 class="mb-3">Billing address</h4>

							<form class="needs-validation was-validated" method="POST" action="payment">
								<div class="row">
									<div class="col-md-12 mb-3">
										<label for="firstName">Name <span class="text-note">&nbsp;(Cannot be modified)</span></label>
										<input type="text" class="form-control" name="fname" id="firstName" placeholder="<?php echo $_SESSION['CUSTOMER']['NAME']; ?>" pattern=".{1,}[a-zA-Z]" required="" disabled="">
										<div class="invalid-feedback">
											Valid first name is required.
										</div>
									</div>
								</div>

								<div class="mb-3">
									<label for="email">Email <span class="text-note">&nbsp;(Cannot be modified)</span></label>
									<input type="email" disabled class="form-control" name="email" id="email" placeholder="<?php echo $_SESSION['CUSTOMER']['EMAIL']; ?>">
									<div class="invalid-feedback">
										Please enter a valid email address for shipping updates.
									</div>
								</div>

								<div class="mb-3">
									<label for="address">Address Line 1</label>
									<input type="text" class="form-control" id="address" name="address1" placeholder="1234 Main St" required="" pattern=".{8,}" required title="8 characters minimum">
									<div class="invalid-feedback">
										Please enter your shipping address. (8 characters minimum)
									</div>
								</div>

								<div class="mb-3">
									<label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
									<input type="text" class="form-control" name="address2" id="address2" placeholder="Apartment or suite">
								</div>

								<div class="row">
									<div class="col-md-4 mb-3">
										<label for="country">Zip</label>
										<select class="custom-select d-block w-100" id="country" name="zip" required="">
											<option value="" selected="selected">Choose...</option>
											<?php $cust->display_pincodes(); ?>
										</select>
										<div class="invalid-feedback">
											Please select a valid zip code.
										</div>
									</div>
									<div class="col-md-4 mb-3">
										<label for="state">State</label>
										<select disabled class="custom-select d-block w-100" id="state" required="">
											<!-- <option value="" selected="selected">Choose...</option> -->
											<option value="Karnataka">Karnataka</option>
										</select>
										<div class="invalid-feedback">
											Please provide a valid state.
										</div>
									</div>
									<div class="col-md-4 mb-3">
										<label for="zip">City</label>
										<select disabled class="custom-select d-block w-100" id="zip" required="">
											<option value="Mangalore">Mangalore</option>
										</select>
										<!-- <input disabled type="text" class="form-control" id="zip" placeholder="" required=""> -->
										<div class="invalid-feedback">
											City required.
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="lastName">Phone Number</label>
										<input type="tel" class="form-control" name="phone_number" id="lastName" placeholder="" required="" maxlength="10" minlength="10" pattern="[0-9]{10}">
										<div class="invalid-feedback">
											Valid phone number required.
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label for="lastName">Alternate Phone Number</label>
										<input type="tel" class="form-control" name="alt_phone_number" id="lastName" placeholder="" pattern="[0-9]{10}" maxlength="10" minlength="10">
										<div class="invalid-feedback">
											Valid phone number is required.
										</div>
									</div>
								</div>
								<span class="text-note">If you cannot find your zip code in the drop-down, we do not deliver to your location yet!</span>
								<hr class="mb-4">
								<hr class="mb-4">

								<h4 class="mb-3">Payment</h4>

								<div class="d-block my-3">
									<div class="custom-control custom-radio">
										<input id="credit" name="payment_method" type="radio" value="cod" class="custom-control-input" required="">
										<label class="custom-control-label" for="credit">Cash on Delivery</label>
									</div>
									<div class="custom-control custom-radio">
										<input id="debit" name="payment_method" type="radio" value="prepaid" class="custom-control-input" required="">
										<label class="custom-control-label" for="debit">Credit Card / Debit Card / UPI / PayTM wallet</label>
									</div>
								</div>
								<input type="hidden" name="TXN_AMOUNT" value="<?php echo sprintf("%.2f", $cust->amountToPay); ?>">
								<input type="hidden" name="ORDER_ID" value="<?php echo rand(1, getrandmax()); ?>">
								<input type="hidden" name="CUST_ID" value="<?php echo $_SESSION['CUSTOMER']['CUSTOMERID']; ?>">
								<input type="hidden" name="state" value="Karnataka">
								<input type="hidden" name="city" value="Mangalore">

								<hr class="mb-4">
								<button class="btn btn-dark btn-lg btn-block shadow-button" type="submit" name="address_submit">Place Order</button>
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
						</div>
						<!-- End -->
						<!-- </div> -->
						<!-- col-lg-12 -->
					</div>



				</div>

			</div>
		</section><!-- #about -->

	</main>

	<!--==========================
    Footer
  ============================-->


	<?php include("includes/front/footer.php"); ?>