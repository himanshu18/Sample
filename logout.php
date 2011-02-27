<?php
	session_start();
	require_once("login_funcs.php");
	team_logout($_SESSION['team_id'],$_SESSION['hash']);
	header("Location: login_int.php?ref=logout");
?>
