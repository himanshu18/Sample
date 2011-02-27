<?php
	session_start();
	require_once("login_funcs.php");
	global $secret;
	if(team_isloggedin()) {
?>

<html>
	<head>
	  	<link rel="stylesheet" href="css/slide.css" type="text/css" />
	  	<link rel="stylesheet" href="css/rateit.min.css" type="text/css" />
	  <!--	<link rel="stylesheet" href="css/graph.css" type="text/css" /> -->
		<link rel="stylesheet" href="css/f_style.css" type="text/css" />
		<link rel="stylesheet" href="css/popup.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.min.js"></script>
		<script type="text/javascript" src="js/utilities.js"></script>
<!--		<script type="text/javascript" src="js/jquery.lavalamp.js"></script> -->
		<script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
		<script type="text/javascript" src="js/jquery.smoothScroll.min.js"></script>
		<script type="text/javascript" src="js/jquery.input-hints.min.js"></script>
<!--		<script type="text/javascript" src="js/jquery.mousewheel.js"></script> -->
		<script type="text/javascript" src="js/jquery.rateit.min.js"></script>
		<script type="text/javascript" src="js/jquery.jqBarGraph.min.js"></script>
		<script type="text/javascript" src="js/jquery.navigation.js"></script>
		<script type="text/javascript" src="js/jquery.accordion.min.js"></script>
		<script type="text/javascript" src="js/jquery.scenarios.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/slide.js"></script>
	</head>
<?php
		if($_GET['scroll']=='results') {
?>
		<script type="text/javascript">
		$(function() {
			setTimeout(function() {
				scroll($('a.panel[href=#results]'));
			},1000);
		});
		</script>
<?php
		}
		else if($_GET['scroll']=='buy') {
?>
		<script type="text/javascript">
		$(function() {
			setTimeout(function() {
				scroll($('a.panel[href=#buy]'));
			},1000);
		});
		</script>
<?php
		}
?>
	<body>
		
		<div id="fade"></div>
		
		<div id="wrapper">
			
			<!-- <div class="notify">
				This is a notification.
			</div>
			<style type="text/css">
				.notify {
					height:70px;
					line-height:70px;
					width:200px;
					position:absolute;
					top:30px;
					right:30px;
					background-color:rgba(0,0,0,0.8);
					-webkit-border-radius:7px;
					color:#ddd;
					z-index:999 !important;
					border:1px solid gray;
					font-size:20px !important;
					padding:0px 20px !important;
				}
			</style> -->
			
			<div id="wrapper2">
			
				<div id="controls">
					<div id="nav-bar">
						<ul id="nav-list" class="lavalamp">
							<li class="front current"><a href="#setup" data-fetch="f_cineplex_setup.php" class="panel">Cineplex Setup</a></li>
							<li class="front"><a href="#buy" data-fetch="f_buy_movie.php" class="panel">Buy Movies</a></li>
							<li class="front"><a href="#schedule" data-fetch="f_scheduling.php" class="panel">Schedule Movies</a></li>
							<li class="front last"><a href="#results" data-fetch="f_graph_results.php" class="panel">Results</a></li>
						</ul>
					</div>
				</div>
			
				<div id="mask">
					<div id="setup" class="item">
						<div class="content"></div>
					</div>
					<div id="buy" class="item">
						<div class="content"></div>
					</div>
					<div id="schedule" class="item">
						<div class="content"></div>
					</div>
					<div id="results" class="item">
						<div class="content"></div>
					</div>
				</div>
			
			</div>
		</div>
	
		<!-- Panel -->
		<div id="toppanel">
			<div id="panel">
				<div id="panel-wrapper">
					<div id="cineplex-div" class="left right">
						<div id="cineplex-title" class="panel-title"><img src="images/mono/32/monitor.png" class="panel-title-img" />Cineplexes</div>
						<div id="cineplex-content" class="panel-content"></div>
						<div class="panel-bg"><img src="images/mono/48/preso.png" /></div>
					</div>
					<div id="stats-div" class="right">
						<div id="stats-title" class="panel-title"><img src="images/mono/32/cur_dollar.png" class="panel-title-img" />Financials</div>
						<div id="stats-content" class="panel-content"></div>
						<div class="panel-bg"><img src="images/mono/48/db.png" /></div>
					</div>
					<div id="bought-movies-div">
						<div id="bought-movies-title" class="panel-title"><img src="images/mono/32/movie.png" class="panel-title-img" />Bought Movies</div>
						<div id="bought-movies-content" class="panel-content"></div>
						<div class="panel-bg"><img src="images/mono/48/tape.png" /></div>
					</div>
				</div>
			</div>
			<!-- The tab on top -->	
			<div class="tab">
				<ul class="login">
					<li class="left">&nbsp;</li>
					<li id="toggle">
						<a id="open" class="open" href="#">Stats</a>
						<a id="close" style="display: none;" class="close" href="#">Close</a>			
					</li>
					<li><a style="font-size:20px;">|</a></li>
					<li><a id="updates-popup" class="show-popup" name="u">Updates</a></li>
				</ul> 
			</div> <!-- / top -->
		</div> <!--panel -->
		
		<!-- timer -->
		<div id="timer-div">
			<div id="round-title">Date: </div>
			<div id="round-content"></div>
			<hr style="border-bottom:1px solid #333 !important;">
			<div id="timer-title">Time left: </div>
			<div id="timer-content"><span id="timer-mins"></span>:<span id="timer-secs"></span></div>
		</div>
		
		<script type="text/javascript">
			$(timer);
			
			function timer() {
				$.ajax({
					url:'gettime.php',
					success:function(times) {
						var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
						var round_time = 120;					// ROUND TIME CONSTANT (TO BE CHECKED LATER)========================================
						var time_array = times.split("|");
						var server_time = time_array[0];
						var round_start_time = time_array[1];
						var round_no = time_array[2];
						var month = ((round_no%12)>0)?((round_no%12)):(12);
						var year = 2011 + Math.floor(round_no/12);
						var time_left = round_time - (server_time-round_start_time);
						$('#timer-mins').html(parseInt(time_left/60));
						$('#timer-secs').html(time_left%60);
						
						if(round_no!=1 && round_no!=4 && round_no!=7) {
							// disable the appropriate links
							var disabled = ['#setup'];
//							$('li.front').each(function() {
//								$(this).removeClass('disabled');
//							});
							for(var i in disabled) {
								$('li.front').has('a[href='+disabled[i]+']').addClass('disabled');
							}
							// update nav links
							updateNavLinks();
						}
						
						disablePopup();
						setupPopup();
						centerPopup();
						loadPopup();
						$('#popup-heading').html('Round Start');
						$('#popup-content').html('Round '+(parseInt(round_no))+' has started');
						setTimeout(function() {
							disablePopup();
						},5000);
						
						var t = setInterval(function() {
							var mins = parseInt($('#timer-mins').html());
							var secs = parseInt($('#timer-secs').html());
							secs = secs - 1;
							
							if(secs == -1 && mins == 0) {
								disablePopup();
								secs = 59;
								mins = parseInt(round_time/60)-1;
								clearTimeout(t);
								if(round_no==0 || round_no==3 || round_no==6)
									window.location.href = 'home.php';
								else
									window.location.href = 'home.php?scroll=buy';
							}
							else if(secs == -1 && mins!=0) {
								secs = 59;
								mins = mins - 1;
							}
							
							if(secs == 0 && mins == 1) {
								$.ajax({
									url:'gettime.php',
									success:function(data) {
										timer = data.split('|');
										setupPopup();
										centerPopup();
										loadPopup();
										checkScenarios(parseInt(timer[2])+2);
										$("#popup-close").remove();
										fade(0.6,997,300);
									},
									dataType:'text'
								});
							}
							
							// display the above calculated time
							$('#timer-mins').html(mins);
							$('#timer-secs').html(secs);
							$('#round-content').html(months[month-1]+', '+year);
						},1000);
					},
					dataType:'text'
				});
			}
		</script>
	</body>
</html>
<?php
	}
	else {
		header("Location: login_int.php?errorcode=1");
	}
?>
