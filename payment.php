<?php
require_once 'includes/config.php';

// if (isset($_POST) && count($_POST)>0 )
// { 
// 	foreach($_POST as $paramName => $paramValue) {
// 			echo "<br/>" . $paramName . " = " . $paramValue;
// 	}
// }
if (isset($_POST['address_submit'])) {
	$cust->last_id = $cust->insert_address();
	$_SESSION['CUSTOMER']['ADDRESSID'] = $cust->last_id;
	if (isset($_POST['payment_method']) && $_POST['payment_method'] === "cod") {
?>
		<form method="POST" name="cod" action="thankyou">
			<input type="hidden" name="AMOUNT" value="<?php echo $_POST['TXN_AMOUNT']; ?>">
			<input type="hidden" name="ORDERID" value="<?php echo $_POST['ORDER_ID']; ?>">
			<input type="hidden" name="CUSTID" value="<?php echo $_POST['CUST_ID']; ?>">
			<input type="hidden" name="COD_CONFIRM" value="COD_CONFIRM">
			<script type="text/javascript">
				document.cod.submit();
			</script>
		</form>
<?php
	} else {
		include 'PaytmKit/pgRedirect.php';
	}
} else {
	redirect("index");
}

?>