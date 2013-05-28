<?php
// Start a session, load the library
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "BQBZcyujDME2DMgP5V7mUFo2FglhxYwk6jJy6BOTy5dflTODDf";
$consumer_secret = "S6PG7n0xjqAVjd9Iul0YACP6eky3tWLBTZeyUEMH1mGEZNExId";
$oauth_token = 'DF3Xhtbz7AUCK2ir3sXmB4Ua5MUvbRQJIwKsT0VMTzsH5X2Zi7';
$oauth_token_secret = 'n6M5acKONvGjS4Qf2aZe86MdpgkntqmxrZHGV1y1oOUVzL4CiZ';
$base_hostname = 'jhickeyiv.tumblr.com';

//posting URI - http://www.tumblr.com/docs/en/api/v2#posting
$post_URI = 'http://api.tumblr.com/v2/blog/'.$base_hostname.'/post';

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

// Make an API call with the TumblrOAuth instance. For text Post, pass parameters of type, title, and body
$parameters = array();
$parameters['type'] = "text";
$parameters['title'] = "title text";
$parameters['body'] = "body text";

$post = $tum_oauth->post($post_URI,$parameters);
//var_dump($tum_oauth);
echo "<br><br>";
var_dump($post);

// Check for an error.
if (201 == $tum_oauth->http_code) {
  echo $post->meta->msg;
  echo "<br>id:".$post->response->id;
} else {
  //die('error');
  var_dump($post);
}

?>