<?php 
require("connect_to_database.php");

$USERNAME_MAX = 20;

if(!preg_match("/^[a-zA-z0-9]*$/", $_POST['uname']))
	die("invalid characters in username");
if(!preg_match("/^[a-zA-z0-9]*$/", $_POST['pword']))
	die("invalid characters in password");

$uname = mysqli_real_escape_string($conn, $_POST['uname']);
$pword = mysqli_real_escape_string($conn, $_POST['pword']);
$fname = mysqli_real_escape_string($conn, $_POST['fname']);

$isTakenResult = mysqli_query($conn, "SELECT username FROM players WHERE username = '$uname';");
$isTaken = mysqli_fetch_assoc($isTakenResult);

if (!empty($isTaken)){
		die('{"response":"USERNAME_TAKEN","message":"That username is taken, try another"}');
}
if (strlen($uname) >= $USERNAME_MAX){
		$length_over = strlen($uname) - $USERNAME_MAX;
		die('{"response":"USERNAME_TOO_LONG","message":"That username is '.$length_over.' characters too long, keep it under 20 characters!"}');
}

$pword = md5($pword);

mysqli_query($conn, "INSERT INTO players (username, password, full_name) VALUES ('$uname', '$pword', '$fname');");
die('{"response":"OK","message":"Good, now log in"}');
exit;
?>