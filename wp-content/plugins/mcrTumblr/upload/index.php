<?php
//grab the files and send them to tumblr
require_once('mysql_connect.php');

require_once('tumblr_post.php');

$files =$_FILES;
var_dump($files);

if (isset($files))
{
	dbconnect();
	$the_files = array();
	foreach ($files as $file)
	{
		$the_file = file_get_contents($file["tmp_name"]);
		$the_files[] = $the_file;		
	}	
	create_post($the_files);
}		
else
{
	echo 'no files';
}
