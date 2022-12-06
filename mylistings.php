<?php include_once("header.php")?>
<?php require("database.php")?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">My listings</h2>

<?php
  // This page is for showing a user the auction listings they've made.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.


  // TODO-DONE: Check user's credentials (cookie/session).

if (!isset($_SESSION['username']) && $_SESSION['account_seller'] != True) {
  echo "<div class='alert alert-warning col-sm-12'><div class='card-body'>";
  echo "<span class='text-danger'> <b>Error 403:</b> You do not have permission to view this page.</span>";
  echo "</div></div>";
  header("refresh:2;url=browse.php");
  exit();
} else {
  $userID = $_SESSION['uid'];
}
?>

<?php



  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }


    $countSql = <<<SQL
select count(*) as cnt from "Items" where userID = $userID
SQL;

    $count_res = fetch_row($countSql);

  $num_results = $count_res['cnt'];
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);
?>

<div class="container mt-5">

<?php
if ($num_results==0){
  echo 'No results matched your query';
}
?>

<ul class="list-group">

    <?php
    $offset = ($curr_page - 1) * $results_per_page;
    $query_sql = <<<SQL
select *, (select count(*) from "Bid" where "Bid".itemid = "Items".itemid) as bids from "Items" where userID = $userID limit $results_per_page offset {$offset}
SQL;
    $query_data = fetch_all($query_sql);

    foreach ($query_data as $item) {
      $query = <<<SQL
      SELECT itemimage from "Image" where itemid = {$item['itemid']}
      SQL;
      // just need one image
      $image = fetch_row($query);
      if (!$image) {
        $image['itemimage'] = "system/noimage.png";
      }
        print_listing_li($item['itemid'], $image['itemimage'], $item['itemname'], $item['itemdescription'], $item['currentprice'], $item['bids'],
            new DateTime(date('Y-m-dTH:i:s', strtotime($item['enddate']))));
    }
    ?>

</ul>

<!-- Pagination for results listings -->
<nav aria-label="Search results pages" class="mt-5">
  <ul class="pagination justify-content-center">

<?php

  // Copy any currently-set GET variables to the URL.
  $querystring = "";
  foreach ($_GET as $key => $value) {
    if ($key != "page") {
      $querystring .= "$key=$value&amp;";
    }
  }

  $high_page_boost = max(3 - $curr_page, 0);
  $low_page_boost = max(2 - ($max_page - $curr_page), 0);
  $low_page = max(1, $curr_page - 2 - $low_page_boost);
  $high_page = min($max_page, $curr_page + 2 + $high_page_boost);

  if ($curr_page != 1) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
        <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
    </li>');
  }

  for ($i = $low_page; $i <= $high_page; $i++) {
    if ($i == $curr_page) {
      // Highlight the link
      echo('
    <li class="page-item active">');
    }
    else {
      // Non-highlighted link
      echo('
    <li class="page-item">');
    }

    // Do this in any case
    echo('
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }

  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="mylistings.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>
</nav>


</div>

</div>

<?php include_once("footer.php")?>
