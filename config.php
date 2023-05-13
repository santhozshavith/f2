<?php

session_start();

$host = "sql348.main-hosting.eu"; /* Host name */
$user = "u296169589_ncv_acpro"; /* User */
//$user = "admin"; /* User */
$password = "PkYp@1971"; /* Password */
$dbname = "u296169589_ncv_acpro"; /* Database name */
//$dbname = "pcw"; /* Database name */
$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

