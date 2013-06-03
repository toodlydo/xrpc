<?php
/*
	Main
*/
	include 'settings.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>XBMC Database Explorer</title>
		<link type="text/css" rel="stylesheet" href="styles/style.css" />
		<link rel="shortcut icon" href="icon/favicon.ico" type="image/x-icon" />
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
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
		
		echo '<script> var response = \''.str_replace("'","\\'",$rawresponse).'\';</script>';
	?>

		<hr>
		<div class="header">
			<p id="title">XBMC Database Explorer</p><span>Beta</span>
			<p id="menu">TV SHOWS</p>
		</div>
		<hr>
		<div class="sidebar">
			<img id="banner" src="<?php echo substr(urldecode(explode("://",$response["result"]["tvshows"][0]["art"]["banner"])[1]), 0, -1);?>"/>
			<img id="poster" src="<?php echo substr(urldecode(explode("://",$response["result"]["tvshows"][0]["art"]["poster"])[1]), 0, -1);?>"/>
			<div id="details">
				<div id="title"><p><?php echo $response["result"]["tvshows"][0]["label"];?></p></div>
				<div id="year"><p>Year: <?php echo $response["result"]["tvshows"][0]["year"];?></p></div>
				<div id="rating"><p>Rating: 
				<?php // put filled stars above blank stars and set visiblity to that of rating.
					$starNumber = round($response["result"]["tvshows"][0]["rating"], 1);
					echo $starNumber.'</p>';
					echo '<div style="z-index: 1;"><img style="z-index: 1;" src="img/stars_empty.png" /></div>';
					$fullwidth = 160* $starNumber / 10;
					echo '<div style="z-index: 2; width:'.$fullwidth.'px; overflow:hidden;"> <img src="img/stars_full.png" /></div>';
				?></div>
				
			</div>
			<div id="plot"><h3>Plot: </h3><p><?php echo $response["result"]["tvshows"][0]["plot"];?></p></div>
			<img id="prev" onclick="loadpn(response,0, i);" style="float: left; width: 50px; margin-top: 50px;" src="img/left_black.png" alt="Prev"/>
			<img id="next" onclick="loadpn(response,1, i);" style="float: right; width: 50px; margin-top: 50px;" src="img/right_black.png" alt="Next"/>
		</div>
		<div class="content">
			<img id="fanart" src="<?php echo substr(urldecode(explode("://",$response["result"]["tvshows"][0]["art"]["fanart"])[1]), 0, -1);?>"/>
			<div class="infobar">
				<div id="ib_info">
					<p id="notv"><?php echo count($response["result"]["tvshows"]); ?> TV SHOWS</p>
					<p id="date"><?php $today = getdate(); echo date('l, jS F Y');?></p>
				</div>
			</div>
			<div class="showbar">
				<div id="sb_info">
					<p id="stitle"><?php echo $response["result"]["tvshows"][0]["label"];?></p>
					<p id="sgenre"><?php echo implode(" / ", $response["result"]["tvshows"][0]["genre"]);?></p>
					<p id="sepno"><?php echo $response["result"]["tvshows"][0]["episode"];?> epsiodes</p>
				</div>
			</div>
		</div>
		<hr>
		<div class="footer">
			<p>&copy;26</p>
			<div id="output"></div>
		</div>
	<body>
</html>
