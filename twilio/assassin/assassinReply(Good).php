<?php 
	include('./inc/dbconnect.php');
	include('./inc/parse.php');
	include ('./inc/outbound.php');
	
	/**
	 *	$response will hold what we will send to the Texter.
	 *	If the person texting isn't registered with a number, then we return nothing.
	 */
	$response = "";
	
	$text = parseURL($_REQUEST['Body']);
	$number = $_REQUEST['From'];
	
	/**
	 *	Cases:
	 *	Who is my target ?  
	 *	QR Code
	 *	Empty Results => not a person. AND the persons target_qr code will be null thus, after this initial info nothing else is needed.
	 */
	
	// add nasme and make assoc
	//$query = $conn->prepare("Select Killer.phone,Killer.player_id,Victim.player_id,Victim.kill_code from players Killer join players Victim on Killer.target_id = Victim.player_id where Killer.phone='{$number}'");
	///REWRITE QUERIES!!
	$query = $conn->prepare("Select Killer.number,Victim.number,Victim.qr_code from players Killer join players Victim on Killer.target_qr_code = Victim.qr_code where Killer.number='{$number}'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_NUM);
	
	if(empty($result)){
		// Number isn't in database and thus doesn't have the right to query
		// or the player is DEAD thus their target_id is null 
	}else{
		if(preg_match('/my target/i',$text)){
			$response = $result[1] . " is the number of your target";
		}else{
			$patternToTest = "/" . substr($result[2],0,10) . "/i";
			if($text != $_REQUEST['Body']){
				$patternToTest = "/" . $result[2] . "/i";
			}
			
			if(preg_match($patternToTest,$text)){
				/*
				//Gets the new Target
				$getNewTarget = $conn->prepare("Select target_qr_code from players where number = '{$result[1]}'");
				$getNewTarget->execute();
				$newTarget = $getNewTarget->fetch(PDO::FETCH_NUM);
					
				//Assigns new target
				$assignTarget = $conn->prepare("Update players SET target_qr_code = '{$newTarget[0]}' where number = {$result[0]}");
				$assignTarget->execute();
				
				// Coulda add name/w/e :L
				$response = "You killed:" . $result[1] . "\n" . "You new target is " . $newTarget[0];

				//Sets Victim Dead and their target to null
				$setDead = $conn->prepare("UPDATE players SET dead = 1,target_qr_code = ''  where number = '{$result[1]}'");
				$setDead->execute();
				*/
				// Notfities the other player that they died
				$deathNote = "You have been Killed By " . $result[0] . " GG";
				
				
				$response = "success!!";
				$victimCleanNum = ltrim($result[1],'+1');
				
				
				sendOutboundOnlyMessage($victimCleanNum,$deathNote);
			}else{
				$response = "You Failed To Kill Him.";
			}
		}
	}
	ob_clean();
	
	
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