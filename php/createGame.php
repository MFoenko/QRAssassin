<?php

	require("login_check.php");

	require("connect_to_database.php");

	$admin_id = $_SESSION['user'];
	$game_name = $_POST['game_name'];
	$game_code = $_POST['game_code'];
	$reg_start = $_POST['reg_start'];
	$reg_end = $_POST['reg_end'];
	$game_start = $_POST['game_start'];

	//check if game name is taken
	$result = mysqli_query($conn, "SELECT COUNT(game_id) FROM games WHERE name = '$game_name';");
	$row = mysqli_fetch_row($result);
	if($row[0] > 0){
		die('{"response":"NAME_TAKEN","message":"This game name is already taken!"}');
	}

	//check if this player already owns a game
	$result = mysqli_query($conn, "SELECT COUNT(game_id) FROM games WHERE admin_id = $admin_id AND isnull(winner);");
	$row = mysqli_fetch_row($result);
	if($row[0] > 0){
		die('{"response":"ALREADY_HAS_GAME","message":"You are administrating another game!"}');
	}




	mysqli_query($conn, "INSERT INTO games(admin_id,name, password, start_reg, end_reg, start_game) 
			VALUES ('$admin_id','$game_name','$game_code','$reg_start','$reg_end','$game_start');");

	if(mysqli_error($conn)){
		die('{"response":"SERVER_ERROR","message":"server error"}');
	}else{
		die('{"response":"OK","message":""}');
	}


?>