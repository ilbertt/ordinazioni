<?php

$db_host = "localhost";
$db_name = "ordinazioni";
$db_user = "ordinazioni";
$db_pass = "Ordi2019!";

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

require_once './utils/php/funcs.php';
