<?php
$ini_array = parse_ini_file("../settings.ini");
define("CONSUMER_KEY", $ini_array['consumer_key'] );
define("CONSUMER_SECRET", $ini_array['consumer_secret']);

session_start();
require_once('tumblroauth.php');


$consumer_key = CONSUMER_KEY;
$consumer_secret = CONSUMER_SECRET;

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $_SESSION['request_token'], $_SESSION['request_token_secret']);

$access_token = $tum_oauth->getAccessToken($_REQUEST['oauth_verifier']);

unset($_SESSION['request_token']);
unset($_SESSION['request_token_secret']);

if (200 == $tum_oauth->http_code) {
} else {
  die('Unable to authenticate');
}

echo "oauth_token: ".$access_token['oauth_token']."<br>oauth_token_secret: ".$access_token['oauth_token_secret']."<br><br>";
echo "Input these into the settings.ini file.";
$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

?>