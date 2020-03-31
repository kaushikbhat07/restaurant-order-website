<?php 
require_once 'includes/config.php';
// session_destroy();
$cust->delete_cart();
session_destroy();
// session_unset();
redirect("index");
