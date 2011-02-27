<?php
	session_start();
	require_once("login_funcs.php");
	
	function displaymessage($message)
	{
		echo "<div id='message'>".$message."</div>";
	}
	
	if(team_isloggedin())
		header("Location: home.php");
?>
<html>
	<head>
		<link rel="stylesheet" href="css/slide.css" type="text/css" />
	  	<link rel="stylesheet" href="css/rateit.css" type="text/css" />
		<link rel="stylesheet" href="css/f_style.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.js"></script>
<!--		<script type="text/javascript" src="js/jquery.lavalamp.js"></script> -->
		<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
		<script type="text/javascript" src="js/jquery.smoothScroll.js"></script>
		<script type="text/javascript" src="js/jquery.input-hints.js"></script>
		<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="js/jquery.rateit.min.js"></script>
		<script type="text/javascript" src="js/jquery.jqBarGraph.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/slide.js"></script>
	</head>
	
	<body>
		<div class="container_16">
		<div class="clear"></div>
			<div id="login-heading">WIZARDS OF BIZ</div>
<?php
	//the following code handles login errors
	if($_GET['feedback'] == 2)
			displaymessage('Missing username or password.');
	if($_GET['feedback'] == 3)
			displaymessage('Username or password incorrect.');
	//display success message on logout
	if(isset($_GET['ref']) && $_GET['ref']=="logout")
		displaymessage('You have logged out successfully.');
	
	//display error if someone tries to access a protected page
	if($_GET['errorcode']==1)
		displaymessage('You must signup to view this page.');
?>
			<div class="grid_5">&nbsp;</div>
			<div class="grid_6" id="loginbox">
				<form action="checklogin.php" method="post">
				  	<fieldset>
				   	<legend style="color:white;">&nbsp;Login Here&nbsp;</legend>
							<div id="team-div">Team:<br/><input autofocus type="text" name="name" class="wideinput inputstyle" /></div>
							<div id="password-div">Password:<br /><input type="password" name="password" /></div>
							<input id="login-button" type="submit" name="submit" value="Login" />
					</fieldset>
				</form>
			</div>
			<div class="grid_5"></div>
			<div class="clear"></div>
		</div>
	</body>
</html>
