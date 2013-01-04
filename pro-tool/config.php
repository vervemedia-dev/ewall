<?php

/************ DB Settings *************/

// LIVE
/*
$db_server = "localhost";
$db_name = "verve2_tracker";
$db_user = "verve2_trackerus";
$db_password = "trackeruser!23";
*/

// LOCAL
$db_server = "localhost";
$db_name = "bala_vervemedia";
$db_user = "root";
$db_password = "";

$con = mysql_connect($db_server, $db_user, $db_password);
mysql_select_db($db_name, $con);

/************** SITE SETTINGS *************/
$site_name = "EWALL Projects Tracker";
$footer_text = "Copyright © EWALL Solutions. All rights reserved.";
?>