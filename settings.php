<?php
/*
	Settings File
*/
	$XBMC_USER = "xbmc";
	$XBMC_PASS = "xbmc";
	$XBMC_IP = "192.168.0.101";
	$XBMC_PORT = "81";
	$url = "";

	if($XBMC_PASS == ""){
		$url = "http://" . $XBMC_IP . ":" . $XBMC_PORT . "/jsonrpc";
	} else{
		$url = "http://" . $XBMC_USER . ":" . $XBMC_PASS . "@" . $XBMC_IP . ":" . $XBMC_PORT . "/jsonrpc";
	}

	$videoLibraryGetTVShows = '{"jsonrpc": "2.0", "method": "VideoLibrary.GetTVShows", "id": 1, "params":{"properties":["art","genre","plot","title","originaltitle","year","rating","thumbnail","playcount","file","fanart","episode"]}}';
	$fileGetDirectory = '{"jsonrpc":"2.0","method":"Files.GetDirectory","id":2,"params":{"directory":"D:\\TV Shows\\30 Rock","properties":["file"]}}'; // directory from above query
	$playerGetActivePlayers = '{"jsonrpc":"2.0","method":"Player.GetActivePlayers","id":1}';
	if(strlen($playerGetActivePlayers) > 35){
		$playerGetItem = '{"jsonrpc": "2.0","id": 1, "method": "Player.GetItem","params":{"playerid":'.$playerGetActivePlayers.'}}';
		$playerPlayPause = '{"jsonrpc":"2.0","method":"Player.PlayPause","params":{"playerid":'.$playerGetActivePlayers.'},"id":1}'; // speed = 0 --> paused, speed =  1 --> playing
		$playerGetProperties = '{"jsonrpc": "2.0", "method": "Player.GetProperties", "params": { "playerid": '.$playerGetActivePlayers.' ,"properties":["type","partymode", "speed", "time", "percentage", "totaltime", "playlistid", "position", "repeat", "shuffled", "canseek", "canchangespeed", "canmove", "canzoom", "canrotate", "canshuffle", "canrepeat", "currentaudiostream", "audiostreams", "subtitleenabled", "currentsubtitle", "subtitles", "live"]}, "id": 1}';
	}
	$filePrepareDownload = '{"jsonrpc": "2.0","id":2, "method": "Files.PrepareDownload", "params": {"path":"D:\\TV Shows\\30 Rock\\Season 7\\30.Rock.S07E06.720p.WEB-DL.DD5.1.H.264-POD.nfo"}}';
	$fileGetSources = '{"jsonrpc": "2.0","id":2, "method": "Files.GetSources", "params": {"media":"video"}}'; // media = audio, media = video
	$inputExecuteAction = '{"jsonrpc":"2.0","method":"Input.ExecuteAction","params":{"action":"back"},"id":1}'; // action list: "left","right","up","down","pageup","pagedown","select","highlight","parentdir","parentfolder","back","previousmenu","info","pause","stop","skipnext","skipprevious","fullscreen","aspectratio","stepforward","stepback","bigstepforward","bigstepback","osd","showsubtitles","nextsubtitle","codecinfo","nextpicture","previouspicture","zoomout","zoomin","playlist","queue","zoomnormal","zoomlevel1","zoomlevel2","zoomlevel3","zoomlevel4","zoomlevel5","zoomlevel6","zoomlevel7","zoomlevel8","zoomlevel9","nextcalibration","resetcalibration","analogmove","rotate","rotateccw","close","subtitledelayminus","subtitledelay","subtitledelayplus","audiodelayminus","audiodelay","audiodelayplus","subtitleshiftup","subtitleshiftdown","subtitlealign","audionextlanguage","verticalshiftup","verticalshiftdown","nextresolution","audiotoggledigital","number0","number1","number2","number3","number4","number5","number6","number7","number8","number9","osdleft","osdright","osdup","osddown","osdselect","osdvalueplus","osdvalueminus","smallstepback","fastforward","rewind","play","playpause","delete","copy","move","mplayerosd","hidesubmenu","screenshot","rename","togglewatched","scanitem","reloadkeymaps","volumeup","volumedown","mute","backspace","scrollup","scrolldown","analogfastforward","analogrewind","moveitemup","moveitemdown","contextmenu","shift","symbols","cursorleft","cursorright","showtime","analogseekforward","analogseekback","showpreset","presetlist","nextpreset","previouspreset","lockpreset","randompreset","increasevisrating","decreasevisrating","showvideomenu","enter","increaserating","decreaserating","togglefullscreen","nextscene","previousscene","nextletter","prevletter","jumpsms2","jumpsms3","jumpsms4","jumpsms5","jumpsms6","jumpsms7","jumpsms8","jumpsms9","filter","filterclear","filtersms2","filtersms3","filtersms4","filtersms5","filtersms6","filtersms7","filtersms8","filtersms9","firstpage","lastpage","guiprofile","red","green","yellow","blue","increasepar","decreasepar","volampup","volampdown","channelup","channeldown","previouschannelgroup","nextchannelgroup","leftclick","rightclick","middleclick","doubleclick","wheelup","wheeldown","mousedrag","mousemove","noop"
	
	$request = $videoLibraryGetTVShows;
	
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
?>