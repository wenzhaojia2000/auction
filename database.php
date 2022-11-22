<?php

$connection = pg_connect("host=localhost port=5432 dbname=auction user=postgres password='root'");

if (!$connection) {
	echo "There was an error connecting to the database.";
}

?>