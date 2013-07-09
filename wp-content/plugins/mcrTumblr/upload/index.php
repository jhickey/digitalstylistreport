<?php
$ini = parse_ini_file("../settings.ini");
$file =$_FILES["file"];

$path = $ini['upload_path'];
if (!file_exists($path)) {
    mkdir($path);
}

if (isset($file))
{
	$orderList = json_decode($_POST['json'], true);
	$key = array_search($file["name"], $orderList);
	$the_file = file_get_contents($file["tmp_name"]);
	file_put_contents($path.$key.'-'.$file["name"], $the_file);
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
