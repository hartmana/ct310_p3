<?php 
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: text/json');

	$sitePurpose=array("purpose"=>"To bring people together for 1337ness");
	echo json_encode($sitePurpose);
?>
