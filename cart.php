<?php include("includes/front/top.php"); ?>

<link rel="stylesheet" href="css/cart.css">
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
					<h3>Cart</h3>
				</header>
				<div class=" about-cols">

					<div class="row">
						<div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
							<div class="cart-subheading">
								<h4>Order details</h4>
							</div>
							<!-- Shopping cart table -->
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th scope="col" class="border-0 ">
												<div class="p-2 px-3 text-uppercase"></div>
												<!-- <hr id="vertical-line"> -->
											</th>
											<th scope="col" class="border-0 ">
												<div class="py-2 text-uppercase"></div>
												<!-- <hr id="vertical-line"> -->
											</th>
											<th scope="col" class="border-0 ">
												<div class="py-2 text-uppercase"></div>
												<!-- <hr id="vertical-line"> -->
											</th>
											<th scope="col" class="border-0 ">
												<div class="py-2 text-uppercase"></div>
												<!-- <hr id="vertical-line"> -->
											</th>
										</tr>
									</thead>
									<tbody>
										<?php $cust->display_cart_page(); ?>
										<?php $cust->delete_item_cart(); ?>
									</tbody>
								</table>
							</div>
							<!-- End -->
						</div>
					</div>

					<div class="row py-5 p-4 bg-white rounded shadow-sm">
						<div class="col-lg-6">
						</div>
						<div class="col-lg-6">
							<div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
							<div class="p-4">
								<p class="mb-4">Handling charges will be charged based on the order quantity.</p>
								<ul class="list-unstyled mb-4">
									<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>&#8377;&nbsp;<?php echo $cust->totalPrice; ?></strong></li>
									<?php
									if ($cust->totalQuantity > 2 || $cust->totalQuantity === 0) {
										$cust->handling = 0;
									} else {
										$cust->handling = 40;
									}
									?>
									<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Handling charges</strong><strong>&#8377;&nbsp;<?php echo $cust->handling; ?></strong></li>
									<?php
									$cust->amountToPay = $cust->totalPrice + $cust->handling;
									?>
									<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
										<h5 class="font-weight-bold">&#8377;&nbsp;<?php echo $cust->amountToPay; ?></h5>
									</li>
								</ul>
								<?php
								$cust->flag = 0;
								if (($cust->totalQuantity == 0 && $cust->totalPrice == 0)) {
									$disabled = "disabled ";
								} else {
									if (!$cust->check_current_orders()) {
										$disabled = "";
									} else {
										$cust->flag = 1;
										$disabled = "disabled ";
									}
								}
								if (isset($cust->totalQuantity) && $cust->totalQuantity <= 20) {
									if (!isset($_SESSION['CUSTOMER']['EMAIL'])) {
										echo '
                        <a tabindex="-1" data-toggle="tooltip" data-placement="bottom" title="Please login before placing an order. " class="btn btn-dark rounded-pill py-2 btn-block shadow-button">Proceed to checkout</a>
                        ';
									} else {
								?>
										<form action="checkout" method="POST">
											<input type="hidden" name="total_amount" value="<?php echo $cust->amountToPay; ?>">
											<input type="hidden" name="quantity" value="<?php echo $cust->totalQuantity; ?>">
											<input type="hidden" name="handling_charge" value="<?php echo $cust->handling; ?>">
											<?php
											$_SESSION['CUSTOMER']['amountToPay'] = $cust->amountToPay;
											$_SESSION['CUSTOMER']['totalQuantity'] = $cust->totalQuantity;
											$_SESSION['CUSTOMER']['handling'] = $cust->handling;
											?>
											<?php
											if ($cust->flag) {
												echo '
                                <a tabindex="-1" data-toggle="tooltip" data-placement="bottom" title="Cannot place orders when there`s an existing order. Please place the order after the current order is delivered. " class="btn btn-dark rounded-pill py-2 btn-block shadow-button">Proceed to checkout</a>
                                ';
											} else {
												if ($cust->totalPrice > 0) {
													echo '
                                    <button type="submit" name="checkout_submit" class="btn btn-dark rounded-pill py-2 btn-block shadow-button">Proceed to checkout</button>
                                    ';
												} else {
													echo '
                                    <button type="submit" disabled class="disabled btn btn-dark rounded-pill py-2 btn-block shadow-button">Proceed to checkout</button>
                                    ';
												}
											}
											?>
										</form>
									<?php
									}
									?>
								<?php
								} else {
								?>
									<a tabindex="-1" data-toggle="tooltip" data-placement="bottom" title="Max 20 units allowed per order. Please modify your order. " class="btn btn-dark rounded-pill py-2 btn-block shadow-button">Procceed to checkout</a>
								<?php
								}
								?>

							</div>
						</div>
					</div>

				</div>

			</div>
		</section><!-- #about -->

	</main>


	<!--==========================
    Footer
  ============================-->


	<?php include("includes/front/footer.php"); ?>