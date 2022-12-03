
<?php

global $connection;

$connection = pg_connect("host=localhost port=5432 dbname=auction user=postgres password='root'");

if (!$connection) {
	echo "There was an error connecting to the database.";
}


function fetch_row($sql = '')
{
    global $connection;
    $stmt = pg_query($connection, $sql);
    return @pg_fetch_assoc($stmt, 0);
}

function fetch_all($sql = '')
{
    global $connection;
    $stmt = pg_query($connection, $sql);

    $out = [];
    while ($r = pg_fetch_assoc($stmt)) {
        $out[] = $r;
    }

    return $out;
}

?>
