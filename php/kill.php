<?php

/*
	//response template
	'{
		"response":"ASSASSINATION_SUCCESFUL",
		"message":"sample text",
		"extra": {
					//extra info
				 }
	}'
*/

	session_start();

	if(isset($_GET['kill_code']))
		$_SESSION['killCode'] = $_GET['kill_code'];

	if(!isset($_SESSION['killCode'])){
		die('No Kill Code');
	}

	require("loginCheck.php");

	require("./connect_to_database.php");
	$killCode = mysqli_real_escape_string($conn, $_SESSION['killCode']);
	

	$uid = $_SESSION['user'];
	$query = "SELECT u.player_id, u.target_id, t.full_name, t.kill_code, t.target_id \"new_target\", t.game_id
								FROM players u INNER JOIN players t ON u.target_id = t.player_id
								WHERE u.player_id = '$uid'";					
								
	$result = mysqli_query($conn, $query ) 
		 or trigger_error(mysql_error());
	$killInfo = mysqli_fetch_array($result);
	
	$killerId = $killInfo['player_id'];
	$targetId = $killInfo['target_id'];
	$newTarget = $killInfo['new_target'];
	$gameId = $killInfo['game_id'];
	
	if (empty($killInfo) || strlen($killCode) != 10 && $killCode != $killInfo['kill_code'] || strlen($killCode) == 10 && $killCode != substr($killInfo['kill_code'],0,10)){
		//echo "The Kill Code is Incorrect";
		echo '{
		"response":"INCORRECT_CODE",
		"message":"That\'s the wrong person!"
		
			}';
		unset($_SESSION['kill_code']);
		//header('Location: /qrassassin');
		die();
	}else{
		mysqli_query($conn, "INSERT INTO kills (killer_id, victim_id, game_id) VALUES ('$killerId', '$targetId', '$gameId');");
		mysqli_query($conn, "UPDATE players SET game_id = NULL, target_id = NULL, kill_code=NULL WHERE player_id= '$targetId'");
		unset($_SESSION['killCode']);
		
		//checks if victim has a phoneNumber
		$result = mysqli_query($conn,"Select phone from players where player_id = '{$targetId}'");
		$victimPhone = mysqli_fetch_row($result);
		
		//notifies victim that they were killed
		if(strlen($victimPhone[0]) > 0){
			include("../twilio/assassin/inc/outbound.php");
			$victimPhone = ltrim($victimPhone[0],'+1');
			$killerQuery = mysqli_query($conn,"select full_name from players where player_id = '{$killerId}'");
			$killerName = mysqli_fetch_row($killerQuery);
			$deathNote = "You have been Killed By " . $killerName[0];
			//i guess i liked anime back then
			sendOutboundOnlyMessage($victimPhone,$deathNote);
			ob_clean();
		}
		mysqli_query($conn, "UPDATE players SET target_id = '$newTarget' WHERE player_id = '$killerId';");
		echo "Assissination Succesful!";
		
		
		// Load your new target 
		$result = mysqli_query($conn,"Select full_name from players where player_id='{$newTarget}'");
		$newTargetInfo = mysqli_fetch_row($result);
		 
		//echo "Your new target is " . $newTargetInfo[0] . "\n";
		
		
		// Thought this might be an interesting feature to add. The number of players in the game left
		$result = mysqli_query($conn,"Select count(*) from players where game_id = '{$gameId}'");
		$result = mysqli_fetch_row($result);
		//echo "There are " . $result[0] . " assassins left.";

		echo '{
		"response":"ASSASSINATION_SUCCESSFUL",
		"message":"sample text",
		"extra": {
					"newTarget":"{$newTargetInfo[0]}",
					"remainingPlayers":"$result[0]";
				 }
			}';
}
		


?>