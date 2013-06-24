<?php
$ini_array = parse_ini_file("../settings.ini");
define("CONSUMER_KEY", $ini_array['consumer_key'] );
define("CONSUMER_SECRET", $ini_array['consumer_secret']);
define("BASE_URL", $ini_array['base_url']);

session_start();

require_once('tumblroauth.php');

$consumer_key = CONSUMER_KEY;
$consumer_secret = CONSUMER_SECRET;


$callback_url = BASE_URL."wp-content/plugins/mcrTumblr/upload/tumblroauth/callback.php";


$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret);

$request_token = $tum_oauth->getRequestToken($callback_url);

$_SESSION['request_token'] = $token = $request_token['oauth_token'];
$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];

switch ($tum_oauth->http_code) {
  case 200:
    $url = $tum_oauth->getAuthorizeURL($token);
	
    header('Location: ' . $url);
	
    break;
default:
    echo 'Could not connect to Tumblr. Refresh the page or try again later.';
}
exit();

?>