<?php 

	include('./inc/dbconnect.php');
	
	$query = "Select Killer.phone,Killer.player_id 'killer_id',Victim.player_id,Victim.kill_code 
	from players Killer join players Victim on Killer.target_id = Victim.player_id 
	where Killer.phone='123'";
	///REWRITE QUERIES!!
	// Tests how assoc array mysqli works
	/*$result = mysqli_query($conn,$query);
	$result = mysqli_fetch_assoc($result);
	echo "<pre>";
	print_r($result);
	echo "</pre>";
	if(empty($result)){
		echo "bug";
	}*/
	
	$query = "Select full_name from players where player_id='5'";
	$queryResult =	mysqli_query($conn,$query);
	$queryResult = mysqli_fetch_row($queryResult);
	
	print_r($queryResult);
?>