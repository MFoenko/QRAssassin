	<?php 
	if (isset($_SESSION['killCode']) && $_SESSION['killCode'] != "")
		header("Location: /qrassassin/php/kill.php");

	session_start();
	if (empty($_SESSION['user'])){
		header("Location : /qrassassin");
		die("Not Logged In");
	}

	$uname = $_SESSION['user'];

	$result = mysqli_query($conn, "SELECT t.full_name 'full_name' FROM players u JOIN players t ON u.target_id = t.player_id WHERE u.username = '$uname';");
	$target = mysqli_fetch_array($result);
	$target = $target[0];


	$result = mysqli_query($conn, "SELECT * FROM players WHERE username = '$uname';");
	$userInfo = mysqli_fetch_assoc($result);

	$game_id = $userInfo['game_id'];
	$result = mysqli_query($conn, "SELECT * FROM games WHERE game_id = '$game_id';");
	$gameInfo = mysqli_fetch_assoc($result);



	?>
	<html>
	<head>

		<script type="text/javascript">
			function displayKillResult(result){
				alert(result.response);
			}
		</script>
	</head>
	<body>
		<div id="main_content">
			<nav>
			<!-- <a href="/">Home</a>
			<a href="info.html">Info</a> -->
			<span class="currentUser"> <?php echo $userInfo['full_name']; ?></span> <br />
			<a href="php/logout.php">Logout</a>
		</nav>
		<div class="content">

			<div class="gameMenu">
				<?php require("html/game.php"); ?>
			</div>

			<? if($target != null && $game_id != null) {?>
			<div class = "target">
				Target: 
				<span class="targetName">
					<?php
					if($target == ""){
						echo "No Target";
					}else{
						echo $target;
					}
					?>
				</span>

				<!-- <form id="killForm" method="get" action="php/kill.php">
					<input class="killCodeInput" name="kill_code" type="text">
					<input class="killCodeSubmit" type="submit" value="Assassinate">
				</form> -->
			</div>
			<?}?>
			<div class="myQRCode">
			<!-- TODO make button check if a qr code exists -->
				<img src="images/qr.png"><span class="link_span" onclick="window.print()">Print my QR Code</span>
			</div>
			<div class="bindToPhone">
				<img src="images/smartphone.png"><a href="html/phoneBind.php">Bind my Phone</a>
			</div>
			
		</div>
	</div>
	<div id="qrcode">
		<?php include("html/qrcode.php"); ?>
	</div>
</body>
<?php
if(isset($_GET['kill_code'])){
	?>
	<script type="text/javascript">
		displayKillResult(JSON.parse(include(php/kill.php)));
	</script>
	<?
}
?>

</html>