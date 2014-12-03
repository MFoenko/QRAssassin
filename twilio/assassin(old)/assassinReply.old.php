<?php 
	session_start();
	include('./inc/dbconnect.php');
	
	//response will hold text as of now, that will be texted.
	$response = "";
	
	$number = $_REQUEST['From'];
	//Just auto kills doesn't check yet.
	$query = $conn->prepare("Select Killer.number, Victim.number,Victim.qr_code from players Killer join players Victim on Killer.target_qr_code = Victim.qr_code where Killer.number='{$number}'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_NUM);
	 
	if(empty($result) || $_REQUEST['Body'] != $result[2]){
	// Penalize for false Killing????
		$response = "His qr_code is :" . $result[2] . " but u put" . $_REQUEST['Body'];
	}else{
		//Sets Victim Dead
		$setDead = $conn->prepare("UPDATE players SET dead = 1 where number = '{$result[1]}'");
		$setDead->execute();
		
		//Gets the new Target
		$getNewTarget = $conn->prepare("Select target_qr_code from players where number = '{$result[1]}'");
		$getNewTarget->execute();
		$newTarget = $getNewTarget->fetch(PDO::FETCH_NUM);
			
		//Assigns new target
		$assignTarget = $conn->prepare("Update players SET target_qr_code = '{$newTarget[0]}' where number = {$result[0]}");
		$assignTarget->execute();
		
		// Coulda add name/w/e :L
		$response = "Good Job You killed:" . $result[1] . "\n" . "You new target is " . $newTarget[0];
		
	}
	
	
	/**
	*	$_REQUEST - Superglobal that contains info abou the message recieved.
	*	$_SESSION - Superglobal that can store temp data for up to 4 hrs.
	*	
	*	Work on using php to write xml. That way I can enable multiple responses?
	*/
	header('content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
	<Sms><?php echo $response ; ?></Sms>
</Response>