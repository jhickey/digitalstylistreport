<?php
//grab the files and send them to tumblr
require_once('mysql_connect.php');

require_once('tumblr_post.php');

$files =$_FILES;

$path = "/Users/jameshickey/Projects/digitalstylistreport/wp-content/uploads/current/";
if (!file_exists($path)) {
    mkdir($path);
}

if (isset($files))
{
	dbconnect();
	$the_files = array();
	foreach ($files as $file)
	{
		$the_file = file_get_contents($file["tmp_name"]);
		file_put_contents($path.$file["name"], $the_file);
	}
	var_dump($files);
}
else
{
	echo 'no files';
}
