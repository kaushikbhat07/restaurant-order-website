<?php  
ob_start();		//to fix headers already sent error
require 'connectDB.php';
$con = new connectDB();
// $con->connect();

require 'functions.php';
session_start();

// unset($_SESSION['location_query']);

if(!isset($_SESSION['location_query']))
{
	$con->connect();
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
	    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
	    $ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
	    $ipaddress = $_SERVER['REMOTE_ADDR'];
	else
	    $ipaddress = 'UNKNOWN';
	$user_agent = $_SERVER['HTTP_USER_AGENT'];	//get user IP

	date_default_timezone_set('Asia/Kolkata');
	$datetime = date("Y-m-d H:i:s");

	$email = "guest@swadesh.com";
	$page_accessed = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
	$sql = "INSERT INTO `login_user_ip` (`email`, `ip`, `user_agent`, `date_accessed`, `page_accessed`) VALUES ('{$email}', '{$ipaddress}', '{$user_agent}', '{$datetime}', '{$page_accessed}')";

	$send_query = $con->escape($con->query($sql));
	$con->confirm($send_query);
	// echo mysqli_error($con->connection);
	
	$_SESSION['location_query'] = "sent";
	$con->disconnect();
}

// $con->disconnect();
$staff = new staff();
// $con->disconnect();

isset($_GET['cat']) ? define('CAT_DROPDOWN_SHOW', 'show') : define('CAT_DROPDOWN_SHOW', '');
isset($_GET['prod']) ? define('PROD_DROPDOWN_SHOW', 'show') : define('PROD_DROPDOWN_SHOW', '');
isset($_GET['view_orders']) ? define('ORD_DROPDOWN_SHOW', 'show') : define('ORD_DROPDOWN_SHOW', '');
isset($_GET['logins']) ? define('LOGIN_DROPDOWN_SHOW', 'show') : define('LOGIN_DROPDOWN_SHOW', '');
isset($_GET['zip']) ? define('ZIP_DROPDOWN_SHOW', 'show') : define('ZIP_DROPDOWN_SHOW', '');
isset($_GET['add_logins']) ? define('ADD_LOGIN_DROPDOWN_SHOW', 'show') : define('ADD_LOGIN_DROPDOWN_SHOW', '');

isset($_GET['cat']) && isset($_GET['add_cat']) ? define('ADD_CAT', 'active') : define('ADD_CAT', '');
isset($_GET['cat']) && isset($_GET['view_cat']) ? define('VIEW_CAT', 'active') : define('VIEW_CAT', '');
isset($_GET['cat']) && isset($_GET['modify_cat']) ? define('MODIFY_CAT', 'active') : define('MODIFY_CAT', '');
isset($_GET['view_orders']) && isset($_GET['new']) ? define('NEW_ORD', 'active') : define('NEW_ORD', '');
isset($_GET['view_orders']) && isset($_GET['delivered']) ? define('DEL_ORD', 'active') : define('DEL_ORD', '');

isset($_GET['logins']) && isset($_GET['admin']) ? define('ADMIN_LOGIN', 'active') : define('ADMIN_LOGIN', '');
isset($_GET['logins']) && isset($_GET['cust']) ? define('CUST_LOGIN', 'active') : define('CUST_LOGIN', '');
isset($_GET['logins']) && isset($_GET['staff']) ? define('STAFF_LOGIN', 'active') : define('STAFF_LOGIN', '');
isset($_GET['zip']) && isset($_GET['modify']) ? define('VIEW_ZIP', 'active') : define('VIEW_ZIP', '');
isset($_GET['zip']) && isset($_GET['add']) ? define('ADD_ZIP', 'active') : define('ADD_ZIP', '');
isset($_GET['add_logins']) && isset($_GET['staff']) ? define('ADD_STAFF_LOGIN', 'active') : define('ADD_STAFF_LOGIN', '');
isset($_GET['add_logins']) && isset($_GET['admin']) ? define('ADD_ADMIN_LOGIN', 'active') : define('ADD_ADMIN_LOGIN', '');


isset($_GET['prod']) && isset($_GET['add_prod']) ? define('ADD_PROD', 'active') : define('ADD_PROD', '');
(isset($_GET['prod']) && isset($_GET['view_prod'])) || (isset($_GET['prod']) && isset($_GET['modify_prod'])) ? define('VIEW_PROD', 'active') : define('VIEW_PROD', '');

isset($_GET['cat']) && isset($_GET['add_cat']) && !isset($_GET['img']) ? define('DISABLED', 'disabled') : define('DISABLED', '');

?>