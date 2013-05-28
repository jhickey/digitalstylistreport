<?php
	require_once('mysql_connect.php');
	dbconnect();
	
	$current_batch = mysql_query("SELECT post_id, pic_url FROM wp_mcr_batches");
	while ($row = mysql_fetch_array($current_batch))
	{
		echo '<div>'.$row['post_id'].'<img class="batch-pic" src="'.$row['pic_url'].'"/></div>';
	}