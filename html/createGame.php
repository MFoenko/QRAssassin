<?php
	session_start();
	require("../php/connect_to_database.php");

	if (!isset($_SESSION['user']))
		//TODO redirect to index
	 header("/");
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../css/createGame.css">
	<script type="text/javascript">
		function createGame(form){
			$.post("../php/createGame.php", {
				game_name: form.gameName.value,
				game_code: form.gamePass.value,
				reg_start:form.startReg.valueAsNumber,
				reg_end:form.endReg.valueAsNumber,
				game_start:form.startGame.valueAsNumber}, function(data){
					alert(data);
				});
		return false;
	}
	</script>
</head>
<body>
<h1>Create a Game</h1>
	<form id="createGameForm" onsubmit="return createGame(this)">
		<input type="text" name="gameName" placeholder="Game Name">
		<input type="text" name="gamePass" placeholder="Entry Code (Optional)">
		<label>Time Registration Opens:<input type="datetime-local" name="startReg" id="startReg"></label>
		<label>Time Registration Closes:<input type="datetime-local" name="endReg" id="endReg"></label>
		<label>Time Game Starts:<input type="datetime-local" name="startGame" id="startGame"></label>

		<input type="submit" value="Create">
	</form>
	<script type="text/javascript">
	var d=new Date();
	d.setMilliseconds(0);
	d.setSeconds(0);
	d.setMinutes(0);
	document.getElementById("startReg").valueAsNumber = d.getTime();
	document.getElementById("endReg").valueAsNumber = d.getTime() + 6 * 1000 * 60 * 60 * 24;
	document.getElementById("startGame").valueAsNumber = d.getTime() + 7 * 1000 * 60 * 60 * 24;
	</script>
</body>
</html>