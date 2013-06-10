<?php
	if(session_id() == '') {
		session_start();
		//$response = $_SESSION["response"];
	}
	require_once 'settings.php';
	$i = isset($_GET["i"])?$_GET["i"]:0;

	$rawresponse = getjsonrpc($videoLibraryGetTVShows, $url);
	//var_dump($rawresponse);
	$response = json_decode($rawresponse, true);
	//$_SESSION['response'] = $response;
	echo '<script> var response = \''.str_replace("'","\\'",$rawresponse).'\'; rurl ="'.$rurl.'"; totalv='.count($response["result"]["tvshows"]).'; showid=1; i = 0;</script>';
?>
		<div class="sidebar">
			<img id="banner" src="<?php echo $rurl.'image/image://'.str_replace("%","%25",urlencode(substr(urldecode(explode("://",$response["result"]["tvshows"][$i]["art"]["banner"])[1]), 0, -1)));?>"/>
			<img id="poster" src="<?php echo $rurl.'image/image://'.str_replace("%","%25",urlencode(substr(urldecode(explode("://",$response["result"]["tvshows"][$i]["art"]["poster"])[1]), 0, -1)));?>"/>
			<div id="details">
				<div id="title"><p><?php echo $response["result"]["tvshows"][$i]["label"];?></p></div>
				<div id="year"><p>Year: <?php echo $response["result"]["tvshows"][$i]["year"];?></p></div>
				<div id="rating"><p>Rating: 
				<?php // put filled stars above blank stars and set visiblity to that of rating.
					$starNumber = round($response["result"]["tvshows"][$i]["rating"], 1);
					echo $starNumber.'</p>';
					echo '<div style="z-index: 1;"><img style="z-index: 1;" src="img/stars_empty.png" /></div>';
					$fullwidth = 160* $starNumber / 10;
					echo '<div style="z-index: 2; width:'.$fullwidth.'px; overflow:hidden;"> <img src="img/stars_full.png" /></div>';
				?></div>
				
			</div>
			<div id="plot"><h3>Plot: </h3><p><?php echo $response["result"]["tvshows"][$i]["plot"];?></p></div>
			<img id="prev" onclick="loadpn(response,0, i);" style="float: left; width: 50px; margin-top: 50px;" src="img/left_black.png" alt="Prev"/>
			<img id="next" onclick="loadpn(response,1, i);" style="float: right; width: 50px; margin-top: 50px;" src="img/right_black.png" alt="Next"/>
		</div>
		<div class="content">
			<img id="fanart" class="ftvshow" src="<?php echo $rurl.'image/image://'.str_replace("%","%25",urlencode(substr(urldecode(explode("://",$response["result"]["tvshows"][$i]["art"]["fanart"])[1]), 0, -1)));?>"/>
			<div class="infobar">
				<div id="ib_info">
					<p id="notv"><?php echo ($i+1).' / '.count($response["result"]["tvshows"]); ?> TV SHOWS</p>
					<p id="date"><?php $today = getdate(); echo date('l, jS F Y');?></p>
				</div>
			</div>
			<div id="browse">
			</div>
			<div class="showbar">
				<div id="sb_info">
					<p id="stitle"><?php echo $response["result"]["tvshows"][$i]["label"];?></p>
					<p id="sgenre"><?php echo implode(" / ", $response["result"]["tvshows"][$i]["genre"]);?></p>
					<p id="sepno"><?php echo $response["result"]["tvshows"][$i]["episode"];?> epsiodes</p>
				</div>
			</div>
		</div>