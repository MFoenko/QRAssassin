<?php 
	include('./inc/dbconnect.php');
	include('./inc/parse.php');
	include ('./inc/outbound.php');
	
	/**
	 *	$response will hold what we will send to the Texter.
	 *	If the person texting isn't registered with a number, then we return nothing.
	 */
	
	header('content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
	<Sms><?php echo "Hello" ?></Sms>
</Response>