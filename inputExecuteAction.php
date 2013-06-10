<?php
require "settings.php";

$id = isset($_GET['id'])?$_GET['id']:1;
$action = isset($_GET['action'])?$_GET['action']:"home";
$param = isset($_GET['param'])?$_GET['param']:"";
$type = isset($_GET['type'])?$_GET['type']:"";

// Set your return content type
header('Content-type: application/json');

// Website url to open
if($action == "home"){
	$daurl = $rurl.'jsonrpc?request={"jsonrpc":"2.0","method":"Input.Home","id":1}';
} else if ($action == "play" || $action == "pause"){
	$daurl = $rurl.'jsonrpc?request={"jsonrpc":"2.0","method":"Player.PlayPause","params":{"playerid":'.$id.'},"id":1}';
} else if($action == "editmeta"){
	$sparam = "";
	
	$decode = json_decode($param, true);
	
	foreach ($decode as $d){
		$sparam = (strlen($sparam)==0?$sparam:$sparam.',').'"'.$d["id"].'":"'.$d["value"].'"';
	}

	if($type=="movie"){
		$daurl = $rurl.'jsonrpc?request={"jsonrpc":"2.0","method":"VideoLibrary.SetMovieDetails","id":1,"params":{"movieid":'.$id.','.$sparam.'}}';
	} else if ($type=="tvshow"){
	} else if ($type=="episode"){
	}
	$daurl = str_replace(" ","%20",$daurl);
} else{
	$daurl = $rurl.'jsonrpc?request={"jsonrpc":"2.0","method":"Input.ExecuteAction","params":{"action":"'.$action.'"},"id":1}';
}

// Get that website's content
$handle = fopen($daurl, "r");
// If there is something, read and return
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        echo $buffer;
    }
    fclose($handle);
}
?>