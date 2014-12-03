<?php 

	include('./inc/dbconnect.php');
	//Gets the new Target
	$query = "Select killer.target_id,killer.full_name 'who_died',victim.full_name,killer.phone from players killer join players victim on 
				killer.target_id = victim.player_id where killer.player_id='6';";
	$result = mysqli_query($conn,$query);
	$result = mysqli_fetch_array($result);
	//print_r($result);
	
	if(is_null($result['phone'])){
		echo "y";
	}
	
	$victimId = 7;
	$killerId = 5;
	$gameId = 2;
	$getNewTarget = "Select killer.target_id,killer.full_name 'who_died',victim.full_name,killer.phone from players killer join players victim on 
				killer.target_id = victim.player_id where killer.player_id='{$victimId}';";
	$newTarget = mysqli_query($conn,$getNewTarget);
	$newTarget = mysqli_fetch_array($newTarget);

	print_r($newTarget);	
	//Assigns new target
	//$query = "Update players set target_id='{$result['target_id']}' where player_id='5'";
	//mysqli_query($conn,$query);
	// Coulda add name/w/e :L
	
	
	mysqli_query($conn,"UPDATE players SET game_id = NULL, target_id = NULL, kill_code=NULL WHERE player_id='{$victimId}'");
	mysqli_query($conn,"INSERT INTO kills (killer_id, victim_id, game_id) VALUES ('{$killerId}', '{$victimId}', '{$gameId}')");

	//Sets Victim Dead and their target to null

	
	// Notfities the other player that they died
?>