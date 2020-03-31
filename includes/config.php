<?php  
ob_start();		//to fix headers already sent error
require_once 'connectDB.php';
require_once 'functions.php';
session_start();
// session_destroy();
// unset($_SESSION['location_query']);

if(!isset($_SESSION['location_query']))
{
	$con = new connectDB();
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

	isset($_SESSION['CUSTOMER']['EMAIL']) ? $email = $_SESSION['CUSTOMER']['EMAIL'] : $email = "guest@swadesh.com";

	$page_accessed = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
	$sql = "INSERT INTO `login_user_ip` (`email`, `ip`, `user_agent`, `date_accessed`, `page_accessed`) VALUES ('{$email}', '{$ipaddress}', '{$user_agent}', '{$datetime}', '{$page_accessed}')";

	$send_query = $con->escape($con->query($sql));
	$con->confirm($send_query);
	// echo mysqli_error($con->connection);
	
	$_SESSION['location_query'] = "sent";
	$con->disconnect();
}

$cust = new customer();
// $con->disconnect();

// $con->disconnect();

// isset($_GET['cat']) ? define('CAT_DROPDOWN_SHOW', 'show') : define('CAT_DROPDOWN_SHOW', '');

?>