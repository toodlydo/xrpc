<?php
	if(session_id() == '') {
		session_start();
		$file = $_SESSION["file"];
		$epid = $_SESSION["epid"];
	}
	require_once 'settings.php';
	if(isset($_GET["epid"])){
		$epid = $_GET["epid"];
		$request = '{"jsonrpc":"2.0","method":"Player.Open","params":{"item":{"episodeid": '.$epid.'}}, "id":1}';
		$epresponse = getjsonrpc($request, $url);
	} else {
?>
<!doctype html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="flowplayer/skin/playful.css">
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>
	</head>
	<body style="background: #000;">
		<div id="videocontainer" style="position: relative;">
			<a href="<?php echo $file;?>" target="_blank" style="text-decoration: none; color: #000; padding: 10px; background: #ccc; border-radius: 5px; display: block; text-align: center; width: 150px; margin: 0 auto; margin-bottom: 10px;">Download</a>
			<a href="stream.php?epid=<?php echo $epid;?>" target="_blank" style="text-decoration: none; color: #000; padding: 10px; background: #ccc; border-radius: 5px; display: block; text-align: center; width: 150px; margin: 0 auto; margin-bottom: 10px;">Play in XBMC</a>
			<?php //http://www.videolan.org/doc/vlc-user-guide/en/ch07.html ?>
			<embed type="application/x-vlc-plugin" name="videoplayer" autoplay="no" loop="no" width="400" height="300" target="<?php echo $file; ?>" />
			<!--<div class="flowplayer" data-swf="flowplayer/flowplayer.swf" data-ratio="0.5625" style="left: 10%; width: 80%; margin: 0 auto;" class="flowplayer no-toggle" data-embed="false">
				<video>
					<source type="video/mp4" src="<?php echo $file;?>">
				</video>
			</div>-->
		</div>
	</body>
</html>
<?php
	}
?>