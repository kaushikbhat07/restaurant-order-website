  <header id="header">
    <div class="container-fluid">

      <div id="logo" class="pull-left">
        <h1><a href="index#intro" class="scrollto">Swadesh</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
            <li class="menu-active"><a href="index#intro">Home</a></li>
            <li><a href="index#about">About Us</a></li>
            <li><a href="index#services">Menu</a></li>
            <li><a href="index#contact">Contact</a></li>
            <li id="cart-tooltip" tabindex="0" data-placement="bottom" role="button" data-toggle="popover" data-html="true" data-trigger="focus"><a href="cart">Cart</a></li>
            <?php 
            if(!isset($_SESSION['CUSTOMER'])) { 
                echo '<li class="menu-has-children"><a href="#account">Signup/Login</a>';
            } else {
                echo '<li class="menu-has-children"><a href="#account">My Account</a>';
            }
            ?>
            
            <ul>
                <?php 
                if(!isset($_SESSION['CUSTOMER'])) { 
                    echo '<li><a href="login">Login</a></li>';
                    echo '<li><a href="register">Register</a></li>';
                } else {
                    echo '<li><a href="" data-toggle="modal" data-target="#exampleModalOrderHistory">Order History</a></li>';
                    echo '<li><a href="" data-toggle="modal" data-target="#exampleModalScrollable">My Orders</a></li>';
                    echo '<li><a href="logout">Logout</a></li>'; 
                }
                ?>
            </ul>
        </li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->