<?php
session_start();
error_reporting(0);
include('connection.php');

$sid = $_POST['sid'];

// $flightcodequery = mysql_query("SELECT * FROM `airport_codes` where city='$sid' ");
// while($flightcodedata = mysql_fetch_array($flightcodequery)){
// 	$codes[] =   $flightcodedata['code'];
// 	}
// echo $codes[0];

echo $sid;
?>
