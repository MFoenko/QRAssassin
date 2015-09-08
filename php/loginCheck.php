<?php
	session_start();
	if (empty($_SESSION['user'])){
		header("Location : /qrassassin");
		die("Not Logged In");
	}
?>