<?

require("login_check.php");
require("connect_to_database.php");


$name = mysqli_real_escape_string($conn, $_POST['gameName']);
$pass = $_POST['gamePass'];


$result = mysqli_query($conn, "SELECT * FROM games WHERE name = '$name';");
$game = mysqli_fetch_assoc($result);
$timeResult = mysqli_query($conn, "SELECT NOW() FROM DUAL;");
	$time = mysqli_fetch_array($timeResult);
	$time = $time[0];
	$time = strtotime($time);

	echo $time;
	echo count($game);
	echo $name;

if (strtotime($game['start_reg'])>$time)
	die('{"response":"REG_NOT_OPEN_YET","message":"Registration is not open yet"}');
if (strtotime($game['end_reg'])<$time)
	die('{"response":"REG_CLOSED","message":"RRegistration is closed"}');



if ($game['password'] == $pass){
	$uid = $_SESSION['user'];
	$gameId = $game['game_id'];
	mysqli_query($conn, "UPDATE players SET game_id='$gameId' WHERE player_id = '$uid';");
}else{
die('{"response":"REG_NOT_OPEN","message":"Invalid Name/Password"}');
}
header("Location: /qrassassin");
exit;
?>