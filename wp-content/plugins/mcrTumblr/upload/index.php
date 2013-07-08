<?php
//grab the files and send them to tumblr
require_once('mysql_connect.php');

require_once('tumblr_post.php');

$files =$_FILES;

$path = "/Users/jameshickey/Projects/mcr/wp-content/uploads/current/";
if (!file_exists($path)) {
    mkdir($path);
}

if (isset($files))
{
	$orderList = json_decode($_POST['json'], true);
	dbconnect();
	$the_files = array();
	$i = 0;
	foreach ($files as $file)
	{
		$key = array_search($file["name"], $orderList);
		echo $key;
		$the_file = file_get_contents($file["tmp_name"]);
		file_put_contents($path.$key.'-'.$file["name"], $the_file);
		$i++;
	}
}
if (isset($_GET['delete']))
{
	$files = glob($path.'*'); // get all file names
	foreach($files as $file){
	echo $files; // iterate files
 	if(is_file($file))
    	unlink($file); // delete file
	}
}
