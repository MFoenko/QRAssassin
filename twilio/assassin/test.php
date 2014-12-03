<?php
//include ("./inc/outbound.php");
function sendOutboundOnlyMessage($number, $message){
	$ch = curl_init();
	$textingService = "http://textbelt.com/text";
	
	$data = array(
			'number' => $number,
			'message' => $message	
	);
	
	// opens the url and sends the POST data
	curl_setopt($ch,CURLOPT_URL,$textingService);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	curl_exec($ch);
	curl_close($ch);
	
	
}
$deathNote = "But can he do this?";

sendOutboundOnlyMessage("3477247305",$deathNote);

?>