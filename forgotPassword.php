<?php
if (!isset($_GET['key']) && !isset($_GET['ts']) && isset($_GET['forgotPassword']) && !isset($_GET['error']) && !isset($_GET['expired']) && !isset($_GET['changed'])) {
?>
	<form class="login100-form validate-form" action="login?forgotPassword" method="POST">
		<span class="login100-form-title p-b-43">
			Forgot Password?
		</span>
		<?php $cust->forgotPassword(); ?>
		<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
			<input class="input100" type="text" name="email">
			<span class="focus-input100"></span>
			<span class="label-input100">Enter your registered email</span>
		</div>

		<div class="flex-sb-m w-full p-t-3 p-b-32">

		</div>


		<div class="container-login100-form-btn">
			<button class="login100-form-btn" type="submit" name="forgot_submit">
				Send reset link
			</button>
		</div>

		<div class="text-center p-t-46 p-b-20">
			<span class="no-account">
				Don't have an account? <span class="no-account-a"><a href="register">Click here</a></span> to register.
			</span><br>
			<span class="no-account">
				<span class="no-account-a"><a href="login">Click here</a></span> to login to your account.
			</span>
		</div>
		<div>
			<button class="go-back-phone login100-form-btn">Go back</button>
		</div>
	</form>

<?php
} else
if (isset($_GET['key']) && isset($_GET['ts']) && isset($_GET['forgotPassword'])) {
?>

	<form class="login100-form validate-form needs-validation was-validated" action="login?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST" novalidate>
		<span class="login100-form-title p-b-43">
			Change Password
		</span>
		<?php $cust->forgotPassword(); ?>
		<div class="wrap-input100 validate-input" data-validate="Do not leave the password field blank. ">
			<input class="input100" type="password" data-toggle="tooltip" data-original-title="Min 6 characters" data-placement="top" name="pass" pattern=".{6,}" required>
			<span class="focus-input100"></span>
			<span class="label-input100">New Password</span>
		</div>

		<div class="flex-sb-m w-full p-t-3 p-b-32"></div>

		<div class="wrap-input100 validate-input" data-validate="Do not leave the password field blank. ">
			<input class="input100" type="password" data-toggle="tooltip" data-original-title="Min 6 characters" data-placement="top" name="confirm_pass" pattern=".{6,}" required>
			<span class="focus-input100"></span>
			<span class="label-input100">Confirm Password</span>
		</div>

		<div class="flex-sb-m w-full p-t-3 p-b-32"></div>

		<div class="container-login100-form-btn">
			<button class="login100-form-btn" type="submit" name="change_pass">
				Change Password
			</button>
		</div>

		<div class="text-center p-t-46 p-b-20">
			<span class="no-account">
				Don't have an account? <span class="no-account-a"><a href="register">Click here</a></span> to register.
			</span><br>
			<span class="no-account">
				<span class="no-account-a"><a href="login">Click here</a></span> to login to your account.
			</span>
		</div>
		<div>
			<button class="go-back-phone login100-form-btn">Go back</button>
		</div>
	</form>
<?php
} else if (isset($_GET['forgotPassword']) && isset($_GET['error'])) {
?>
	<form class="login100-form validate-form">
		<span class="login100-form-title p-b-43">
			<!-- Forgot Password? -->
		</span>
		<?php setMessage("Invalid link. "); ?>
		<div class="text-center p-t-46 p-b-20">
			<span class="no-account">
				Don't have an account? <span class="no-account-a"><a href="register">Click here</a></span> to register.
			</span><br>
			<span class="no-account">
				<span class="no-account-a"><a href="login">Click here</a></span> to login to your account.
			</span>
		</div>
	</form>
<?php
} else if (isset($_GET['forgotPassword']) && isset($_GET['expired'])) {
?>
	<form class="login100-form validate-form">
		<span class="login100-form-title p-b-43">
			<!-- Forgot Password? -->
		</span>
		<?php setMessage("Sorry! This link has expired. "); ?>
		<div class="text-center p-t-46 p-b-20">
			<span class="no-account">
				Don't have an account? <span class="no-account-a"><a href="register">Click here</a></span> to register.
			</span><br>
			<span class="no-account">
				<span class="no-account-a"><a href="login">Click here</a></span> to login to your account.
			</span>
		</div>
	</form>
<?php
} else if (isset($_GET['forgotPassword']) && isset($_GET['changed'])) {
?>
	<form class="login100-form validate-form">
		<span class="login100-form-title p-b-43">
			<!-- Forgot Password? -->
		</span>
		<?php setMessage("Password changed successfully. "); ?>
		<div class="text-center p-t-46 p-b-20">
			<span class="no-account">
				<span class="no-account-a"><a href="login">Click here</a></span> to login to your account.
			</span>
		</div>
	</form>
<?php
}
?>