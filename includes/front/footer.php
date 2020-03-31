  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>Swadesh Restaurant</h3>
            <p>Prices may be subject to applicable taxes and charges and may also change without prior notice. Please check prices on the website before ordering.</p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4 class="footer-h4">Useful Links</h4>
            <ul>
              <li><i class="ion-ios-arrow-right"></i> <a href="index#intro">Home</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="index#about">About us</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="index#services">Menu</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="login">Login</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="register">Register</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4 class="footer-h4">Contact Us</h4>
            <p>
              Amuruthmahal, Near Checkpost<br> Vamanjoor, Mangalore<br>Karnataka, India<br>
              <strong>Phone:</strong>  0824 2262593<br>
              <strong>Email:</strong> swadesh@kproj.me<br>
            </p>

            <div class="social-links">
              <a href="https://twitter.com" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="https://facebook.com" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="https://instagram.com" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="https://google.com" target="_blank" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="https://linkedin.com" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>

          <div class="col-lg-3 col-md-6 footer-newsletter">
            <h4 class="footer-h4">Our Newsletter</h4>
            <p>Be updated with our new offers, coupons and addition of new food items into the menu. Enter your email ID below and subscribe to our newsletter so that you do not miss any update.</p>
            <form action="index" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Swadesh Restaurant</strong>. All Rights Reserved
      </div>
      <div class="credits">

      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below i you want to use a preloader -->
  <div id="preloader"></div>
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title cart-item-icon" id="exampleModalLabel"><i class="fas fa-shopping-cart"></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $cust->display_cart_in_item(); ?>
      </div>
      <div class="modal-footer">
        <a href="cart" class="btn btn-success">
            <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
            </span>
            <span class="text">Goto Cart</span>
        </a>        
        <button type="button" class="btn btn-danger" data-dismiss="modal">
            <span class="icon text-white-50">
            <i class="fas fa-times"></i>
            </span>
            <span class="text">Close</span>
        </button>
    </div>
    </div>
  </div>
</div>

<!-- View Orders Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="modalOrders" aria-hidden="true">
  <div class="modal-dialog modal-dialog-orders modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalOrders">My Orders</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th>Order #</th>
                <th>Item Title</th>
                <th>Amount</th>
                <th>Order Placed</th>
                <th>Payment Mode</th>
                <th>Order Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $cust->view_orders_cust(); ?>         
          </tbody>
        </table>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Order History Modal -->
<div class="modal fade" id="exampleModalOrderHistory" tabindex="-1" role="dialog" aria-labelledby="modalOrders" aria-hidden="true">
  <div class="modal-dialog modal-dialog-orders modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalOrders">Order History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th>Order #</th>
                <th>Item Title</th>
                <th>Amount</th>
                <th>Order Placed</th>
                <th>Payment Mode</th>
                <th>Order Delivered</th>
            </tr>
          </thead>
          <tbody>
            <?php $cust->view_order_history_cust(); ?>         
          </tbody>
        </table>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/jquery/jquery-migrate.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
<!--   <script type="text/javascript">
$('#cart-tooltip').popover('show')

setTimeout("$('#cart-tooltip').popover('hide')", 5000);
</script> -->
<script src="lib/easing/easing.min.js"></script>
<script src="lib/superfish/hoverIntent.js"></script>
<script src="lib/superfish/superfish.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<!-- <script src="lib/owlcarousel/owl.carousel.min.js"></script> -->
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.js"></script>
<script src="lib/touchSwipe/jquery.touchSwipe.min.js"></script>
<!-- Contact Form JavaScript File -->
<script src="contactform/contactform.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>
<script src="loginpage/js/main.js"></script>
<?php
$filename = substr($_SERVER['PHP_SELF'], strlen($_SERVER['PHP_SELF']) - 8, strlen($_SERVER['PHP_SELF'])); 
if($filename === "item.php") {
    if(isset($_SESSION['CART']) && sizeof($_SESSION['CART']) >= 1) {
        echo "<script type='text/javascript'>$('#exampleModal').modal('show'); </script>";
        // unset($_SESSION['CART_UPDATED']);
    }        
}

?>
</body>
</html>