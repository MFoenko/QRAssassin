<script type = "text/javascript">
	function joinGame(form){

		var name = form.elements['gameName'].value;
		var entryCode = form.elements['gamePass'].value;

		$.post("php/joinGame.php", {
			gameName: name,
			gamePass: entryCode
		},function(data){
			alert(data);
		});
		return false;
	}

	function leaveGame(){
		//this POST is done so that players cannot make a qr code 
		//that kicks players who scan it out of the game
		//anticipating hacks ftw
		$.post("/php/leaveGame.php", {"junkPostValue": "true"}, function(data){
			window.reload();
		})
	}

	
</script>
<?php
	
	$result = mysqli_query($conn, "SELECT * FROM players p INNER JOIN games g ON p.game_id = g.game_id WHERE p.username =  '$uname';");
	$game = mysqli_fetch_assoc($result);
	if (empty($game)){?>
	
	<form id="joinGameForm" onsubmit = "return joinGame(this);">
		<input type="text" name="gameName" placeholder="Game Name">
		<input type="text" name="gamePass" placeholder="Entry Code (Optional)">
		<input type="submit" value="Join">
	</form>


	<a href="html/createGame.php">Or Create a Game</a>
	
	
	<?
	}else{
		if($game['started'] == 1){
		//kill log 
?>
			<h3>Recent Kills</h3>
			<div class="killLog">
				<table>
					<thead>
						<tr>
							<td>Time</td>
							<td>Killer</td>
							<td>Victim</td>
						</tr>
					</thead>
					<tbody>
		<?php
		$gameId = $game['game_id'];
		$killLog = mysqli_query($conn,"
		SELECT l.time, k.full_name \"killer\", v.full_name \"victim\"
		FROM kills l INNER JOIN players k ON l.killer_id = k.player_id INNER JOIN players v ON l.victim_id = v.player_id
		WHERE l.game_id = '$gameId'
		ORDER BY l.time DESC
		");
		$logLength = mysqli_num_rows($killLog);
		for ($i = 0;$i<$logLength;$i++){
			$kill = mysqli_fetch_assoc($killLog);
?>
				<tr>
					<td><?php echo date("m/d g:ia",strtotime($kill['time'])); ?></td>
					<td><?php echo $kill['killer']; ?></td>
					<td><?php echo $kill['victim']; ?></td>
				</tr>
<?php
		} //for loop close
?>
				</tbody>
				</table>
			</div>
				<!-- <a href="php/leaveGame.php">Leave Game</a> -->
				
<span onclick="leaveGame" class="link">Leave Game</span>
<?php
	}else{
?>
	<div class="gameInfo">Start Registration:<br> <?php echo $game['start_reg'];?></div>
	<div class="gameInfo">End Registration:<br> <?php echo $game['end_reg'];?></div>
	<div class="gameInfo">Start Game:<br> <?php echo $game['start_game'];?></div>
	<!-- <a href="php/leaveGame.php">Leave Game</a> -->
	<span onclick="leaveGame()" class="link_span">Leave Game</span>


<?php
	}	
}
?>