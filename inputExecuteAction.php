<?php
require "settings.php";

$id = $_GET['id'];
$action = $_GET['action'];

// Set your return content type
header('Content-type: application/json');

// Website url to open
if($action == "home"){
	$daurl = $rurl.'jsonrpc?request={"jsonrpc":"2.0","method":"Input.Home","id":1}';
} else if ($action == "play" || $action == "pause"){
	$daurl = $rurl.'jsonrpc?request={"jsonrpc":"2.0","method":"Player.PlayPause","params":{"playerid":'.$id.'},"id":1}';
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