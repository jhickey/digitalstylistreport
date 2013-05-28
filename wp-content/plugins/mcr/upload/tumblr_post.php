<?php
session_start();
require_once('tumblroauth/tumblroauth/tumblroauth.php');

$ini_array = parse_ini_file("settings.ini");
define("CONSUMER_KEY", $ini_array['consumer_key'] );
define("CONSUMER_SECRET", $ini_array['consumer_secret']);
define("OAUTH_TOKEN", $ini_array['oauth_token']);
define("OAUTH_TOKEN_SECRET", $ini_array['oauth_token_secret']);
define("BASE_HOSTNAME", $ini_array['base_hostname']);
define("VOTE_PAGE", $ini_array['vote_page']);

function create_post ($the_files){
	$post_URI = 'http://api.tumblr.com/v2/blog/'.BASE_HOSTNAME.'/post';
	$tum_oauth = new TumblrOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);

	$parameters = array();
	$parameters['type'] = "photo";
	$parameters['caption'] = "<a href='".VOTE_PAGE."&i=$id' target='_blank'>Vote for this at digitalstylistreport</a>";
	$parameters['data'] = $the_files;
	
	$post = $tum_oauth->post($post_URI,$parameters);
	if (201 == $tum_oauth->http_code) {
      $pic = json_decode(file_get_contents('http://api.tumblr.com/v2/blog/'.BASE_HOSTNAME.'/posts/photo?api_key='.CONSUMER_KEY.'&id='.$post->response->id));
	  $the_pic_url = $pic->response->posts[0]->photos[0]->alt_sizes[0]->url;
      $query = "INSERT INTO wp_files (url, time) VALUES ('$the_pic_url', '".time()."')";
	  mysql_query($query);
	} else {
	  die('error');
	}
}
?>