<?php 
	include("../inc/outbound.php");
	$phoneNumber = $_GET['phone']; 
	$code = $_GET['code'];
	
	sendOutboundOnlyMessage($phoneNumber,$code);


?>
