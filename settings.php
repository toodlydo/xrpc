<?php
/*
	Settings File
*/
	$XBMC_USER = "xbmc";
	$XBMC_PASS = "xbmc";
	$XBMC_IP = "localhost";
	$XBMC_PORT = "81";
	$url = "";

	if($XBMC_PASS == ""){
		$url = "http://" . $XBMC_IP . ":" . $XBMC_PORT . "/jsonrpc";
	} else{
		$url = "http://" . $XBMC_USER . ":" . $XBMC_PASS . "@" . $XBMC_IP . ":" . $XBMC_PORT . "/jsonrpc";
	}

	$request = '{"jsonrpc": "2.0", "method": "VideoLibrary.GetTVShows", "id": 1, "params":{"properties":["art","genre","plot","title","originaltitle","year","rating","thumbnail","playcount","file","fanart","episode"]}}';
?>