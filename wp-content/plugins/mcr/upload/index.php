<?php
require_once('mysql_connect.php');

require_once('tumblr_post.php');
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

$files =$_FILES;
var_dump($files);

if (isset($files))
{
	dbconnect();
	$the_batch_query = "SELECT option_value FROM wp_mcr_votes_data WHERE option_name = 'current_batch'";
	$the_batch = mysql_result(mysql_query($the_batch_query),0);
	$the_files = array();
	foreach ($files as $file)
	{
		$the_file = file_get_contents($file["tmp_name"]);
		$the_files[] = $the_file;
		
		$name = urlencode($file['name']);
		$query = "INSERT INTO wp_files (filename, batch) VALUES ('$name', '$the_batch')";
		mysql_query($query);
		$id = mysql_insert_id();
		
	}	
	create_post($the_files, $name, $id);
}		
else
{
	echo 'no files';
}
