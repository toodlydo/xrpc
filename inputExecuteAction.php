<?php
// Set your return content type
$id = $_GET['id'];
$action = $_GET['action'];
header('Content-type: application/json');

// Website url to open
if($action == "home"){
	$daurl = 'http://xbmc:xbmc@192.168.0.101:81/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Home","id":1}';
} else if ($action == "play" || $action == "pause"){
	$daurl = 'http://xbmc:xbmc@192.168.0.101:81/jsonrpc?request={"jsonrpc":"2.0","method":"Player.PlayPause","params":{"playerid":'.$id.'},"id":1}';
} else{
	$daurl = 'http://xbmc:xbmc@192.168.0.101:81/jsonrpc?request={"jsonrpc":"2.0","method":"Input.ExecuteAction","params":{"action":"'.$action.'"},"id":1}';
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