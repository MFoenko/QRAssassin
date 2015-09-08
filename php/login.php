<?php
session_start();
require("connect_to_database.php");


$uname = $_POST['uname'];
$pword = $_POST['pword'];

$result = mysqli_query($conn, "SELECT player_id, username, password FROM players WHERE username = '$uname';");
$user = mysqli_fetch_assoc($result);
if ($user['password'] == md5($pword)){
	$_SESSION['user'] = $user['player_id'];
	http_response_code(200);
	die('{"response":"OK","message":""}');
}else{
	http_response_code(200);
	die('{"response":"INVALID_INFO","message":"Invalid Username or Password"}');
}


exit;
?>