<?php
  // For now, index.php just redirects to browse.php, but you can change this
  // if you like.

  try {
    $dbh = new PDO('pgsql:host=localhost;port=5432;dbname=cameronmillen;user=postgres;password=Mullingar1609!');
    echo "PDO connection object created";
  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }
  
  header("Location: browse.php");
?>
