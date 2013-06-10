<?php
	if(session_id() == '') {
		session_start();
	}
	require_once 'settings.php';
	isset($_GET['id'])? $showid = $_GET['id']:$showid=0;
	isset($_GET['season'])? $seasonnum = $_GET['season']:$seasonnum=0;
	isset($_GET['episode'])? $epnum = $_GET['episode']:$epnum=-1;
	isset($_GET['action'])? $action = $_GET['action']:$action="seasons";

	if($epnum == -1 && ($action == "seasons" || $action == "episodes")){
?>
				<ul>
					<li id="up">..</a></li>
<?php
	}
	if($showid == 0){
		$showid = 1;
	}
	if($action == "seasons"){
		$request = '{"jsonrpc":"2.0","method":"VideoLibrary.GetSeasons","id":1,"params":{"tvshowid":'.$showid.', "properties":["episode","watchedepisodes","season"]}}';
		$seasonresponse = getjsonrpc($request, $url);
		$response = json_decode($seasonresponse, true);
		if(count($response["result"])!=1){
			$seasons = ($response["result"]["seasons"]);
			usort($seasons, function($a, $b) {
				return $a['season'] - $b['season'];
			});
			foreach($seasons as $season){
				echo '<li class="season" id="'.$season["season"].'"><p id="ll">'.$season["label"].'</p><p id="lr">'.$season["episode"].' episodes  '.($season["episode"]==$season["watchedepisodes"]? json_decode('"\u2713"'):json_decode('"\u2007"')).'</p></li>';
			}
		}
	} else if($action == "episodes"){
		$request = '{"jsonrpc":"2.0","method":"VideoLibrary.GetEpisodes","id":1,"params":{"tvshowid":'.$showid.',"season":'.$seasonnum.', "properties":["episode","showtitle","firstaired","season"]}}';
		$epresponse = getjsonrpc($request, $url);
		$response = json_decode($epresponse, true);
		$episodes = ($response["result"]["episodes"]);
		foreach($episodes as $episode){
			echo '<li class="episode" id="'.$episode["episodeid"].'"><p id="ll">'.
				'<table style="border-collapsed: collpased; margin: 0px; padding: 0px; width: 100%;"><tr>'.
				'<td style="border: none !important; width: 10%;">'."S".($episode["season"]<10?'0'.$episode["season"]:$episode["season"])."E".($episode["episode"]<10?'0'.$episode["episode"]:$episode["episode"]).'</td>'.
				'<td style="border: none !important; width: 75%; text-align: left;">'.explode(".",$episode["label"],2)[1].'</td>'.
				'<td style="border: none !important; width: 10%;">'.$episode["firstaired"].'</td>'.
				'</tr></table>'.
				'</p></li>';
		}
	} else if($action == "epdetails"){
		$request = '{"jsonrpc":"2.0","method":"VideoLibrary.GetEpisodeDetails","id":1,"params":{"episodeid":'.$epnum.',"properties":["tvshowid","rating","showtitle","runtime","plot","cast","writer","director","streamdetails","firstaired","title","thumbnail","season","episode","file","productioncode"]}}';
		$epdresponse = getjsonrpc($request, $url);
		$response = json_decode($epdresponse, true);
		$episode = ($response["result"]["episodedetails"]);
?>
		<table class="epd" id="<?php echo $episode["episodeid"];?>">
			<tr>
				<td style="border: none;" colspan="3" id="up" class="<?php echo $episode["season"];?>">..</td>
			</tr>
			<tr>
				<td colspan="3" id="eptitle"><?php echo $episode["title"];?><br>
					<span><?php echo $episode["showtitle"];?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;"><?php echo "S".($episode["season"]<10?'0'.$episode["season"]:$episode["season"])."E".($episode["episode"]<10?'0'.$episode["episode"]:$episode["episode"]);?></td><td>First aired: <br><?php echo $episode["firstaired"];?></td>
			</tr>
			<tr>
				<td>Director</td><td colspan="2"><?php echo join(" / ",$episode["director"]);?></td>
			</tr>
			<tr>
				<td>Writer</td><td colspan="2"><?php echo implode(" / ",$episode["writer"]);?></td>
			</tr>
			<tr>
				<td>Runtime: </td><td><?php echo round($episode["runtime"]/60,0);?> Minutes</td><td>Rating: <?php echo round($episode["rating"],1);?></td>
			</tr>
			<tr>
					<td valign="top">Cast</td>
					<td colspan="2">
						<div style="height:150px; overflow-y:auto;">
							<?php $names = array_map(function($item) { return $item["name"].($item["role"]==""?"":" as ".$item["role"]); }, $episode["cast"]); echo implode("<br>",$names);?>
						</div>
					</td>
			</tr>
			<tr>
				<?php 
					if($XBMC_PASS == ""){
						$_SESSION["file"] = "http://".$XBMC_IP.":".$XBMC_PORT."/vfs/".$episode["file"];
					} else{
						$_SESSION["file"] = "http://" . $XBMC_USER . ":" . $XBMC_PASS . "@" . $XBMC_IP . ":" . $XBMC_PORT."/vfs/".str_replace("\\","\\\\",$episode["file"]);
					}
					$_SESSION["epid"]=$episode["episodeid"];
				?>
				<td colspan="3" style="text-align: center; background: #8CCBFF;"><a href="stream.php" target="_blank">Play / Download</a></td>
			</tr>
			<tr>
				<td colspan="3">Plot<br><?php echo $episode["plot"];?></td>
			</tr>
		</table>
<?php
	} else if($action == "movie"){
		$request = '{"jsonrpc": "2.0", "method": "VideoLibrary.GetMovieDetails","id":1,"params":{"movieid":'.$showid.',"properties":["rating","runtime","plot","cast","writer","director","streamdetails","year","title","thumbnail","file","tagline","votes","mpaa","genre"]}}';
		$mdresponse = getjsonrpc($request, $url);
		$response = json_decode($mdresponse, true);
		$movie = ($response["result"]["moviedetails"]);
		$_SESSION["movie"] = $movie;
?>
		<table class="md" id="<?php echo $movie["movieid"];?>">
			<tr>
				<td style="border: none;" colspan="3" id="up" class="<?php echo $movie["movieid"];?>">..</td>
			</tr>
			<tr>
				<td colspan="3" id="eptitle"><?php echo $movie["title"];?><br>
					<span><?php echo $movie["tagline"];?></span>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;"><?php if($movie["mpaa"]=="Rated "){echo "Not Rated";} else{ echo $movie["mpaa"];}?></td><td>Year: <?php echo $movie["year"];?></td><td><?php echo implode($movie["genre"]," / ");?></td>
			</tr>
			<tr>
				<td>Director</td><td colspan="2"><?php echo join(" / ",$movie["director"]);?></td>
			</tr>
			<tr>
				<td>Writer</td><td colspan="2"><?php echo implode(" / ",$movie["writer"]);?></td>
			</tr>
			<tr>
				<td>Runtime: </td><td><?php echo round($movie["runtime"]/60,0);?> Minutes</td><td>Rating: <?php echo round($movie["rating"],1).' ('.$movie["votes"].' votes)';?></td>
			</tr>
			<tr>
					<td valign="top">Cast</td>
					<td colspan="2">
						<div style="height:150px; overflow-y:auto;">
							<?php $names = array_map(function($item) { return $item["name"].($item["role"]==""?"":" as ".$item["role"]); }, $movie["cast"]); echo implode("<br>",$names);?>
						</div>
					</td>
			</tr>
			<tr>
				<?php 
					if($XBMC_PASS == ""){
						$_SESSION["file"] = "http://".$XBMC_IP.":".$XBMC_PORT."/vfs/".$movie["file"];
					} else{
						$_SESSION["file"] = "http://" . $XBMC_USER . ":" . $XBMC_PASS . "@" . $XBMC_IP . ":" . $XBMC_PORT."/vfs/".str_replace("\\","\\\\",$movie["file"]);
					}
					$_SESSION["epid"]=$movie["movieid"];
				?>
				<td style="text-align: center; background: #8CCBFF;"><a href="stream.php" target="_blank">Play / Download</a></td>
				<td><p id="vedit" style="text-align: center; margin:0; padding: 0; text-decoration: none;">Edit</p></td>
				<td><p id="vrefresh" style="text-align: center; margin:0; padding: 0; text-decoration: none;">Refresh</p></td>
			</tr>
			<tr>
				<td colspan="3">Plot<br><?php echo $movie["plot"];?></td>
			</tr>
		</table>
<?php
	}

	if($epnum == -1){
?>
				</ul>
<?php
	}
?>