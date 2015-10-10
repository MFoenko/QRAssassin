<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
	<script type="text/javascript">
		function createGame(s){
			//TODO write JS function to create game via AJAX

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