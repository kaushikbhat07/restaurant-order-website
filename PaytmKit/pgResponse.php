<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("lib/config_paytm.php");
require_once("lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	// echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS" && $cust->place_order($_POST['ORDERID'], $_SESSION['CUSTOMER']['CUSTOMERID'], $_POST['TXNAMOUNT'], $_SESSION['CUSTOMER']['ADDRESSID'], $_POST['TXNID'], $_POST['STATUS'], $_POST['BANKTXNID'], $_POST['BANKNAME'], $_POST['CHECKSUMHASH'])) {

		$cust->mail_order_prepaid($_POST['ORDERID'], $_POST['TXNAMOUNT'], $_SESSION['CUSTOMER']['NAME'], $_SESSION['CUSTOMER']['EMAIL'], $_POST['BANKTXNID'], $_POST['PAYMENTMODE']);

		echo '<h1 class="display-3">Thank You!</h1>';
		echo "<b>Transaction successful.</b>" . "<br/>";

		echo '<p class="lead">Your order (ID: '.$_POST['ORDERID'].') should be arriving sooon. <strong>Please check your email</strong> for the order bill/receipt.</p>';
		unset($_SESSION['CUSTOMER']['ADDRESSID']);
		// unset($_SESSION['CART']);
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.

	}
	else {
		unset($_GET);
		echo '<h1 class="display-3">Sorry!</h1>';
		echo "<b>Transaction failed.</b>" . "<br/>";
		echo $_POST['RESPMSG'];
		//unset($_SESSION['CUSTOMER']['ADDRESSID']);
	}
}
else {
	unset($_GET);
	echo '<h1 class="display-3">Sorry!</h1>';
	echo "<b>Transaction failed.</b>" . "<br/>";
	echo $_POST['RESPMSG'];
	//unset($_SESSION['CUSTOMER']['ADDRESSID']);	
	//redirect("index");
}
?>