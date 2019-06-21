<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$db_host = "localhost"; //Host address (most likely localhost)
$db_name = "ordinazioni"; //Name of Database
$db_user = "ordinazioni"; //Name of database user
$db_pass = "ordinazioni2019"; //Password for database user

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

require_once 'funcs.php';
