<?php 
require_once 'includes/config.php';
// session_destroy();
session_destroy();
// session_unset();
redirect("login");
?>