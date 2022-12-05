<?php

$adminpw = fopen("adminpassword.txt", "r") or die("Unable to open file containing admin password.");
$password = fread($adminpw, filesize("adminpassword.txt"));
fclose($adminpw);

global $connection;

$connection = pg_connect("host=localhost port=5432 dbname=auction user=auctionadmin password='$password'");

if (!$connection) {
	echo "There was an error connecting to the database.";
}

?>
