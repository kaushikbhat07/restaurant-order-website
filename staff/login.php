<?php include('includes/front/top.php'); ?>
<?php if (isset($_SESSION['STAFF']['STAFFID'])) {
	redirect("index");
}
?>
<style>
	.bd-placeholder-img {
		font-size: 1.125rem;
		text-anchor: middle;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	@media (min-width: 768px) {
		.bd-placeholder-img-lg {
			font-size: 3.5rem;
		}
	}
</style>
<!-- Custom styles for this template -->
<link href="../admin/css/signin.css" rel="stylesheet">
</head>

<body>
	<form class="form-signin needs-validation" method="POST" action="login" novalidate>
		<div class="text-center">
			<img class="mb-4" src="../img/favicon.png" alt="" width="72" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Sign in - Staff</h1>
			<?php $staff->login(); ?>
		</div>
		<div class="form-row">
			<div class="col-md-12 mb-3">
				<!-- <label for="validationCustom01">Email Address</label> -->
				<input type="email" name="email" data-toggle="tooltip" data-placement="top" title="" data-original-title="Email Address" pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$" class="form-control" id="validationCustom01" placeholder="Email Address" required>
				<div class="valid-feedback">
					Looks good!
				</div>
				<div class="invalid-feedback">
					Please provide a valid email!
				</div>
			</div>
			<div class="col-md-12 mb-3">
				<!-- <label for="validationCustom02">Password</label> -->
				<input type="password" name="pass" data-toggle="tooltip" data-placement="top" title="" data-original-title="Password" pattern=".{6,}" class="form-control" id="validationCustom02" placeholder="Password" required>
				<div class="valid-feedback">
					Looks good!
				</div>
				<div class="invalid-feedback">
					Please enter a valid password!
				</div>
			</div>
		</div>

		<button class="btn btn-lg btn-primary btn-block" type="submit" name="login_submit">Sign in</button>
	</form>

	<?php include('includes/front/footer.php'); ?>