<?php
	session_start();
	require("php/connect_to_database.php");

	if (!isset($_SESSION['user']))
		//TODO redirect to index
	 header("/");
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
	<script type="text/javascript">
		function createGame(form){
			$.post("./php/createGame.php", {
				game_name: form.gameName.value,
				game_code: form.gamePass.value,
				reg_start: form.startReg.value,
				reg_end: form.endReg.value,
				game_start: form.startGame.value}, function(data){
					//on game create result
				});
		return false;
	}
	</script>
</head>
<body>
	<span class="link_span" onclick="$('#createGameForm').toggle()">Or Create a Game</span>
	<form id="createGameForm" onsubmit="return createGame(this)" style="display:none">
		<input type="text" name="gameName" placeholder="Game Name">
		<input type="text" name="gamePass" placeholder="Entry Code (Optional)">
		<label>Time Registration Opens:<input type="datetime-local" name="startReg"></label>
		<label>Time Registration Closes:<input type="datetime-local" name="endReg"></label>
		<label>Time Game Starts:<input type="datetime-local" name="startGame"></label>

		<input type="submit" value="Create">
	</form>
</body>
</html>