<?php 
	include('./inc/dbconnect.php');
	include('./inc/parse.php');
	include ('./inc/outbound.php');
	
	/**
	 *	$response will hold what we will send to the Texter.
	 *	If the person texting isn't registered with a number, then we return nothing.
	 */
	$response = "Twillio Works D:";
	
	$text = parseURL($_REQUEST['Body']);
	$number = $_REQUEST['From'];
	
	/**
	 *	Cases:
	 *	Who is my target ?  
	 *	QR Code
	 *	Empty Results => not a person. AND the persons target_qr code will be null thus, after this initial info nothing else is needed.
	 */
	
	//make assoc
	$query = "Select Killer.phone,Killer.player_id 'killer_id',Victim.player_id,Victim.kill_code 
	from players Killer join players Victim on Killer.target_id = Victim.player_id 
	where Killer.phone='{$number}'";
	
	$result = mysqli_query($conn,$query);
	$result = mysqli_fetch_array($result);
	
	
	
	if(empty($result)){
		// Number isn't in database and thus doesn't have the right to query
		// or the player is DEAD thus their target_id is null 
	}else{
		// Variables to store data from the $result Assoc Array
		$killerPhone = $result['phone'];
		$killerId = $result['killer_id'];
		$victimId = $result['player_id'];
		$victimCode = $result['kill_code'];
		
		if(preg_match('/my target/i',$text)){
			$query = "Select full_name from players where player_id='5'";
			$queryResult =	mysqli_query($conn,$query);
			$queryResult = mysqli_fetch_row($queryResult);
			$response = $queryResult[0] . " is the name of your target";
		}else{
			$patternToTest = "/" . substr($victimCode,0,10) . "/i";
			if($text != $_REQUEST['Body']){
				$patternToTest = "/" . $victimCode . "/i";
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
				//$deathNote = "You have been Killed By " . $result[0] . " GG";
				
				
				$response = "success!!";
				//$victimCleanNum = ltrim($result[1],'+1');
				
				
				//sendOutboundOnlyMessage($victimCleanNum,$deathNote);
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
	*/
	header('content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
	<Sms>WTF php no work?</Sms>
</Response>