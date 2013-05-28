<?php
$ini_array = parse_ini_file("settings.ini");
define("IPADDRESS", $ini_array['ipaddress'] );
define("USERNAME", $ini_array['username']);
define("PASSWORD", $ini_array['password']);
define("DATABASE", $ini_array['database']);

function dbconnect () {
$link = mysql_connect(IPADDRESS, USERNAME, PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db(DATABASE) or die(mysql_error());
}
?>
