<?php
// Start a session, load the library
session_start();
require_once('tumblroauth/tumblroauth/tumblroauth.php');

// Define the needed keys


function create_post ($the_files, $the_file_name, $id){

	$consumer_key = "BQBZcyujDME2DMgP5V7mUFo2FglhxYwk6jJy6BOTy5dflTODDf";
	$consumer_secret = "S6PG7n0xjqAVjd9Iul0YACP6eky3tWLBTZeyUEMH1mGEZNExId";
	$oauth_token = 'DF3Xhtbz7AUCK2ir3sXmB4Ua5MUvbRQJIwKsT0VMTzsH5X2Zi7';
	$oauth_token_secret = 'n6M5acKONvGjS4Qf2aZe86MdpgkntqmxrZHGV1y1oOUVzL4CiZ';
	$base_hostname = 'jhickeyiv.tumblr.com';

	$post_URI = 'http://api.tumblr.com/v2/blog/'.$base_hostname.'/post';
	$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

	$parameters = array();
	$parameters['type'] = "photo";
	$parameters['caption'] = "<a href='http://localhost:8888/digitalstylistnetwork/?page_id=7&i=$id' target='_blank'>Vote for this at digitalstylistnetwork</a>";
	$parameters['data'] = $the_files;
	
	$post = $tum_oauth->post($post_URI,$parameters);
	if (201 == $tum_oauth->http_code) {
      $pic = json_decode(file_get_contents('http://api.tumblr.com/v2/blog/jhickeyiv.tumblr.com/posts/photo?api_key=BQBZcyujDME2DMgP5V7mUFo2FglhxYwk6jJy6BOTy5dflTODDf&id='.$post->response->id));
	  $the_pic_url = $pic->response->posts[0]->photos[0]->alt_sizes[0]->url;
      $query = "INSERT INTO wp_mcr_batches (post_id, pic_url, time) VALUES ('".$id."','".$the_pic_url."', '".date("Y-m-d h:i:s")."')";
	  mysql_query($query);
	} else {
	  die('error');
	}
}
?>