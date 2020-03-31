<?php include("includes/front/top.php"); ?>

<link rel="stylesheet" href="css/item.css">

</head>

<body>
	<?php include("includes/front/header_static.php"); ?>


	<section id="portfolio" class="section-bg">
		<!-- Page Content -->
		<div class="container container-main">
			<header class="section-header">
				<!-- <h3 class="section-title"></h3> -->
			</header>

			<div class="row">
				<div class="col-md-3 categories-left">
					<h3 class="my-3 sub-heading">Other Categories to choose from</h3>
					<div class="accordion" id="accordionExample">
						<?php $cust->display_categories_sidebar(); ?>
					</div>

				</div>
				<div class="col-md-5 shadow item-main">
					<?php $cust->display_item_page(); ?>
				</div>
				<div class="col-md-4">
					<div class="cart-buttons">
						<h3 class="my-3 sub-heading">Order now</h3>

						<?php !isset($itid) ? $itid = $_GET['itid'] : 0; ?>
						<?php $cust->add_cart(); ?>
						<?php $cust->remove_cart(); ?>

						<?php

						if (isset($_SESSION['CART'])) {
							foreach ($_SESSION['CART'] as $i => $item) {
								if (isset($_SESSION['CART'][$i]) && in_array(base64_decode($_GET['itid']), $_SESSION['CART'][$i])) {
									$qty = $_SESSION['CART'][$i]['QUANTITY'];
								}
								if (!isset($_SESSION['CART'][$i])) {
									unset($qty);
								}
							}
						}

						if (isset($qty) && $qty < 10) {
						?>

							<a href="item?itid=<?php echo $itid; ?>&cart=<?php echo $itid; ?>">
								<button class="btn btn-cart btn-add-cart btn-lg">
									<span class="icon text-white-50">
										<i class="fas fa-cart-plus"></i>
									</span>
									<span class="text">Add to cart</span>
								</button>
							</a>
						<?php
						} else if (!isset($qty)) { ?>
							<a href="item?itid=<?php echo $itid; ?>&cart=<?php echo $itid; ?>">
								<button class="btn btn-cart btn-add-cart btn-lg">
									<span class="icon text-white-50">
										<i class="fas fa-cart-plus"></i>
									</span>
									<span class="text">Add to cart</span>
								</button>
							</a>
						<?php
						} else {
						?>
							<a tabindex="-1" data-toggle="tooltip" data-placement="top" title="Max 10 units allowed per item">
								<button class="btn btn-cart btn-add-cart btn-lg">
									<span class="icon text-white-50">
										<i class="fas fa-cart-plus"></i>
									</span>
									<span class="text">Add to cart</span>
								</button>
							</a>
						<?php
						}
						?>

						<div class="cart-icons">

							<?php
							if (isset($qty) && $qty < 10) {
							?>

								<a href="item?itid=<?php echo $itid; ?>&cart=<?php echo $itid; ?>" class="cart-item-icon mr-2"><i class="fas fa-plus-circle"></i></a>
							<?php
							} else if (!isset($qty)) {
							?>
								<a href="item?itid=<?php echo $itid; ?>&cart=<?php echo $itid; ?>" class="cart-item-icon mr-2"><i class="fas fa-plus-circle"></i></a>
							<?php
							} else {
							?>
								<a tabindex="-1" class="cart-item-icon mr-2" data-toggle="tooltip" data-placement="bottom" title="Max 10 units allowed per item"><i class="fas fa-plus-circle"></i></a>
							<?php
							}
							?>

							<div class="mr-2 badge badge-secondary badge-pill cart-item-quantity">x<?php isset($qty) ? print($qty) : print("0"); ?></div>

							<a href="item?itid=<?php echo $itid; ?>&reduce=<?php echo $itid; ?>" class="cart-item-icon"><i class="fas fa-minus-circle"></i></a>

						</div>
						<br><br>
						<a href="cart">
							<button class="btn btn-cart btn-goto-cart btn-danger btn-lg">
								<span class="icon text-white-50">
									<i class="fas fa-arrow-right"></i>
								</span>
								<span class="text">Goto cart</span>
							</button>
						</a>
					</div>


					<?php $cust->display_cart_in_item(); ?>

				</div>
			</div>

			<!-- Portfolio Item Row -->
			<!-- /.row -->

			<!-- Related Items Row -->
			<h3 class="my-4 sub-heading">Related Items</h3>

			<div class="row portfolio-container">

				<!-- Team Member 1 -->
				<?php $cust->related_items(); ?>
				<!-- Team Member 4 -->
			</div>
			<!-- /.row -->

		</div>
		<!-- /.container -->
	</section>


	<?php include("includes/front/footer.php"); ?>