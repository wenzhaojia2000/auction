<!-- NO ACTION HERE  -->

<?php include_once("header.php")?>

<?php
  /*
  try {
    $dbh = new PDO('pgsql:host=localhost;port=5432;dbname=cameronmillen;user=postgres;password=');
    echo "PDO connection object created";
  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }
  */
?>

<div class="container">
  <h2 class="my-3 text-center">Welcome to</h2>
  <img src="img/index.png" alt="eBay Deluxe" style="max-width: 100%">
  <h2 class="my-3 text-center">Created by</h2>
  <h5 class="text-center">Yi Gu</h5>
  <h5 class="text-center">Cameron Millen</h5>
  <h5 class="text-center">Hugo Giddins</h5>
  <h5 class="text-center">James Jia</h5>

  <div class="text-center" style="padding: 20px"><small>The eBay&trade; name and logo are registered trademarks in the European Union, the UK, the US, and internationally under eBay, Inc. Use of the eBay name and logo allowed under a written licence agreement with eBay (We definitely have this and this definitely isn't illegal use of their brand).</small></div>
</div>

<?php include_once("footer.php")?>