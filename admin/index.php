<?php include('includes/front/top.php'); ?>
<?php
if (!isset($_SESSION['ADMIN']['ADMINID'])) {
    redirect("login");
}
?>
<link rel="stylesheet" href="css/styles.css">
</head>

<?php include('includes/front/sidebar.php'); ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include('includes/front/navbar.php'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->

            <?php
            if (preg_match("/index/im", $_SERVER['PHP_SELF']) && $_SERVER['QUERY_STRING'] == "") {
                redirect("index?view_orders&new=1");
            }

            if (isset($_GET['add_cat']) && isset($_GET['cat'])) {
                include("includes/back/add_cat.php");
            } else if (isset($_GET['view_cat']) && isset($_GET['cat'])) {
                include("includes/back/view_cat.php");
            } else if (isset($_GET['modify_cat']) && isset($_GET['cat'])) {
                include("includes/back/modify_cat.php");
            } else if (isset($_GET['prod']) && isset($_GET['add_prod'])) {
                include("includes/back/modify_prod.php");
            } else if (isset($_GET['prod']) && isset($_GET['view_prod'])) {
                include("includes/back/view_prod.php");
            } else if (isset($_GET['prod']) && isset($_GET['modify_prod'])) {
                include("includes/back/view_prod.php");
            } else if (isset($_GET['view_orders']) && !isset($_GET['ordstatus']) && !isset($_GET['ordid'])) {
                include("includes/back/view_orders.php");
            } else if (isset($_GET['view_orders']) && isset($_GET['ordstatus']) && isset($_GET['ordid'])) {
                include("includes/back/view_order_address.php");
            } else if (isset($_GET['logins']) && (isset($_GET['admin']) || isset($_GET['cust']) || isset($_GET['staff']))) {
                include("includes/back/view_login.php");
            } else if (isset($_GET['zip']) && (isset($_GET['add']) || isset($_GET['modify']))) {
                include("includes/back/add_zip.php");
            } else if (isset($_GET['add_logins']) && (isset($_GET['staff']) || isset($_GET['admin']))) {
                include("includes/back/add_logins.php");
            } else if (isset($_GET['changePassword'])) {
                include("includes/back/change_pass.php");
            } else {
                include("includes/back/view_orders.php");
            }
            ?>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Swadesh Restaurant</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

<?php include('includes/front/footer.php'); ?>