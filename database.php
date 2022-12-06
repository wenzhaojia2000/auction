<?php

if (file_exists("adminpassword.txt")) {
	$adminpw = fopen("adminpassword.txt", "r");
	$password = fread($adminpw, filesize("adminpassword.txt"));
	fclose($adminpw);
} else if (file_exists("../adminpassword.txt")) {
	$adminpw = fopen("../adminpassword.txt", "r");
	$password = fread($adminpw, filesize("../adminpassword.txt"));
	fclose($adminpw);
} else {
	die("Cannot open file containing admin password");
}

global $connection;

$connection = pg_connect("host=localhost port=5432 dbname=auction user=auctionadmin password='$password'");

if (!$connection) {
	echo "There was an error connecting to the database.";
}

?>
