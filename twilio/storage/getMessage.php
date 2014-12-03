<?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once('/Services/Twilio.php'); // Loads the library
 
// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "AC8fc91bf2d8e6be880acb512c00ddb5bc"; 
$token = "e8995573826f9dc84758c4c7d3f611d1"; 
$client = new Services_Twilio($sid, $token);
 
// Get an object from its sid. If you do not have a sid,
// check out the list resource examples on this page
foreach ($client->account->sms_messages as $message) {
    if($message->direction == "outbound-reply"){
		echo $message->to . "<br />";
	}
	//echo count($client->account->sms_messages);
}

?>