<?php
/*
	Settings File
*/
	$url = "http://localhost:81/jsonrpc"; //path to the xbmc server
	$request = '{"jsonrpc": "2.0", "method": "VideoLibrary.GetTVShows", "id": 1, "params":{"properties":["art","genre","plot","title","originaltitle","year","rating","thumbnail","playcount","file","fanart","episode"]}}';
?>