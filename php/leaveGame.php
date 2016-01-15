<?php
session_start();
if (empty($_SESSION['user'])){
	header("Location : /qrassassin");
	die("Not Logged In");
}
if(empty($_POST['junkPostValue'])){
	die('{"response":"UNAUTHORIZED_LEAVE", "message":"You are attempting to leave the game. If you see this message after 
		attempting to assissinate someone, please let the game admin know; the person you scanned is attempting to cheat."}')
}

require("connect_to_database.php");
$uid = $_SESSION['user'];

//get player info
$result = mysqli_query($conn, "SELECT p.player_id, p.target_id, p.game_id, g.started
								FROM players p INNER JOIN games g
								ON p.game_id = g.game_id
								WHERE player_id = '$uid';");
$playerInfo = mysqli_fetch_assoc($result);

$uId = $playerInfo['player_id'];
$tId = $playerInfo['target_id'];
$gId = $playerInfo['game_id'];
$isStart = $playerInfo['started'];

//give quitter's target to the next player
mysqli_query($conn, "UPDATE players 
					SET target_id = '$tId'
					WHERE target_id = '$uId';");

//removes quitter from the game
mysqli_query($conn, "UPDATE players 
					SET game_id = NULL, target_id=NULL, kill_code=NULL
					WHERE player_id = '$uid';");


//if game is started, insert a suicide into the logs
if ($isStart == 1){
mysqli_query($conn, "INSERT INTO kills (killer_id, victim_id, game_id)
					VALUES ('$uId','$uId','$gId');");
}

//header("Location: /qrassassin");
exit;
?>
