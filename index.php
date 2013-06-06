<?php
/*
	Main
*/
	session_start();
	require 'settings.php';
	GLOBAL $response;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>XBMC Database Explorer</title>
		<link type="text/css" rel="stylesheet" href="styles/style.css" />
		<link type="text/css" rel="stylesheet" href="styles/remote_style.css" />
		<link rel="shortcut icon" href="icon/favicon.ico" type="image/x-icon" />
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/remote.js"></script>
	</head>

	<body>
		<?php
			function getjsonrpc($data, $url){
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER,
						array("Content-type: application/json"));
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

				$json_response = curl_exec($curl);

				$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

				if ( $status != 200 ) {
					die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
				}

				curl_close($curl);
				return $json_response;
			}

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
					<li class='last'><a href='#' id="mhome"><span>Exit</span></a></li>
				</ul>
			</div>
		</div>
		<hr>
		<div class="container"><?php include "remote.php";?></div>
		<hr>
		<div class="footer">
			<p>&copy;26</p>
			<div id="output"></div>
		</div>
	<body>
</html>
