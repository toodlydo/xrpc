<?php
/*
	Main
*/
	session_start();
	require_once 'settings.php';
	GLOBAL $response, $file, $epid;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>XBMC Database Explorer</title>
		<link type="text/css" rel="stylesheet" href="styles/style.css" />
		<link type="text/css" rel="stylesheet" href="styles/tvshows_style.css" />
		<link type="text/css" rel="stylesheet" href="styles/remote_style.css" />
		<link rel="stylesheet" type="text/css" href="flowplayer/skin/playful.css">
		<link rel="shortcut icon" href="icon/favicon.ico" type="image/x-icon" />
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/remote.js"></script>
		<script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>
	</head>

	<body>
		<?php
			$rawresponse = getjsonrpc($request, $url);
			//var_dump($rawresponse);
			$response = json_decode($rawresponse, true);
			$_SESSION['response'] = $response;
			echo '<script> var response = \''.str_replace("'","\\'",$rawresponse).'\'; </script>';
		?>
		<hr>
		<div class="header">
			<p id="title">XBMC Database Explorer</p><span>Beta</span>
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='index.php' id="mhome"><span>Home</span></a></li>
					<li class=''><a href='#' id="mtv"><span>TV Shows</span></a></li>
					<li class=''><a href='#' id="mmovie"><span>Movies</span></a></li>
					<li class=''><a href='#' id="mmusic"><span>Music</span></a></li>
					<li class=''><a href='#' id="mremote"><span>Remote</span></a></li>
					<li class=''><a href='#' id="msystem"><span>System</span></a></li>
					<li class='last'><a href='#' id="mhome"><span>Exit</span></a></li>
				</ul>
			</div>
		</div>
		<hr>
		<div class="container"><?php include "tvshows.php";?></div>
		<hr>
		<div class="footer">
			<p>&copy;26</p>
			<div id="output"></div>
		</div>
		<div class="remote">
			<?php include "remote.php";?>
		</div>
	<body>
</html>
