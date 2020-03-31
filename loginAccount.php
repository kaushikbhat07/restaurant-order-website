<form class="login100-form validate-form needs-validation" method="POST" action="login" novalidate="">
    <span class="login100-form-title p-b-43">
        Login to continue
    </span>
    <?php $cust->login(); ?>
    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
        <input class="input100" type="text" name="email">
        <span class="focus-input100"></span>
        <span class="label-input100">Enter Email</span>
    </div>


    <div class="wrap-input100 validate-input" data-validate="Password is required">
        <input class="input100" type="password" name="pass" data-toggle="tooltip" data-placement="top" data-original-title="Min 6 characters.">
        <span class="focus-input100"></span>
        <span class="label-input100">Password</span>
    </div>

    <div class="flex-sb-m w-full p-t-3 p-b-32">
        <div class="contact100-form-checkbox">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
            <label class="label-checkbox100" for="ckb1">
                Remember me
            </label>
        </div>

        <div>
            <a href="login?forgotPassword" class="txt1">
                Forgot Password?
            </a>
        </div>
    </div>


    <div class="container-login100-form-btn">
        <button class="login100-form-btn" type="submit" name="login_submit">Login</button>
    </div>

    <div class="text-center p-t-46 p-b-20">
        <span class="no-account">
            Don't have an account? <span class="no-account-a"><a href="register">Click here</a></span> to register.
        </span>
    </div>
    <div>
        <?php isset($_SERVER['HTTP_REFERER']) ? $goback = $_SERVER['HTTP_REFERER'] : $goback = "index" ?>
        <a href="<?php echo $goback; ?>"><button type="button" class="go-back-phone login100-form-btn">Go back</button></a>
    </div>
</form>