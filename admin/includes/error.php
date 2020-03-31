<?php 
set_error_handler("customError");

function customError($errno, $errstring)
{
	echo "Custom Error";
}

?>