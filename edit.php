<?php
	if(session_id() == '') {
		session_start();
	}
	require_once 'settings.php';
	isset($_GET['id'])? $showid = $_GET['id']:$showid=0;
	isset($_GET['season'])? $seasonnum = $_GET['season']:$seasonnum=0;
	isset($_GET['episode'])? $epnum = $_GET['episode']:$epnum=-1;
	isset($_GET['action'])? $action = $_GET['action']:$action="seasons";
	$movie = $_SESSION["movie"];
?>
		<form>
			<table class="vedit" id="<?php echo $showid;?>">
				<tr>
					<td style="border: none;" colspan="3" id="up" class="<?php echo $showid?>">..</td>
				</tr>
				<tr>
					<td colspan="3" id="eptitle" style="font-size: 24pt;"><input class="editcheck" type="checkbox" name="title" value=""><p><?php echo $movie["title"];?></p><br>
						<span style="font-size: 18pt;"><input class="editcheck" type="checkbox" name="tagline" value=""><p><?php echo $movie["tagline"];?></p></span>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;"><?php if($movie["mpaa"]=="Rated "){echo "Not Rated";} else{ echo $movie["mpaa"];}?></td><td>Year: <input class="editcheck" type="checkbox" name="year" value=""><p><?php echo $movie["year"];?></p></td><td><input class="editcheck" type="checkbox" name="genre" value=""><p><?php echo implode($movie["genre"]," / ");?></p></td>
				</tr>
				<tr>
					<td>Director</td><td colspan="2"><input class="editcheck" type="checkbox" name="director" value=""><p><?php echo join(" / ",$movie["director"]);?></p></td>
				</tr>
				<tr>
					<td>Writer</td><td colspan="2"><input class="editcheck" type="checkbox" name="writer" value=""><p><?php echo implode(" / ",$movie["writer"]);?></p></td>
				</tr>
				<tr>
					<td>Runtime: </td><td><input class="editcheck" type="checkbox" name="runtime" value=""><p><?php echo round($movie["runtime"]/60,0);?></p> Minutes</td><td>Rating: <?php echo round($movie["rating"],1).' ('.$movie["votes"].' votes)';?></td>
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
					<td style="text-align: center; background: #E66767;" colspan="3"><a style="text-decoration: none; color: #000;" href="#" id="confirmedit" class="movcedit">Confirm</a></td>
				</tr>
				<tr>
					<td colspan="3">Plot<br><input class="editcheck" type="checkbox" name="plot" value=""><p><?php echo $movie["plot"];?></p></td>
				</tr>
			</table>
		</form>