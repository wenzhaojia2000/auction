<?php
include_once("header.php");
include "database.php"?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">Browse listings</h2>

<div id="searchSpecs">
<!-- When this form is submitted, this PHP page is what processes it.
     Search/sort specs are passed to this page through parameters in the URL
     (GET method of passing data to a page). -->
<form method="get" action="browse.php">
  <div class="row">
    <div class="col-md-5 pr-0">
      <div class="form-group">
        <label for="keyword" class="sr-only">Search keyword:</label>
	    <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent pr-0 text-muted">
              <i class="fa fa-search"></i>
            </span>
          </div>
          <input type="text" class="form-control border-left-0" id="keyword" placeholder="Search for anything"
                 name="keyword">
        </div>
      </div>
    </div>
    <div class="col-md-3 pr-0">
      <div class="form-group">
        <label for="cat" class="sr-only">Search within:</label>
        <select class="form-control" id="cat" name="cat">
          <option selected value="">All categories</option>
          <?php
            //this is a loop to auto insert the categories into the drop down
            $query = "SELECT * FROM \"Category\"";
            $categories = pg_query($connection, $query);
            while ($row = pg_fetch_assoc($categories)) {
              $categoryName = trim($row['categoryname']);
              echo "<option value='$categoryName'>$categoryName</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="col-md-3 pr-0">
      <div class="form-inline">
        <label class="mx-2" for="order_by">Sort by:</label>
        <select class="form-control" id="order_by" name="order_by">
          <option selected value="pricelow">Price (low to high)</option>
          <option value="pricehigh">Price (high to low)</option>
          <option value="date">Soonest expiry</option>
        </select>
      </div>
    </div>
    <div class="col-md-1 px-0">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </div>
</form>
</div> <!-- end search specs bar -->


</div>

<?php


  // Retrieve these from the URL
  if (!isset($_GET['keyword'])) {
    // TODO-DONE: Define behavior if a keyword has not been specified.
      $keyword = '';
  }
  else {
    $keyword = $_GET['keyword'];
  }

  if (!isset($_GET['cat'])) {
    // TODO-DONE: Define behavior if a category has not been specified.
      $category  = '';
  }
  else {
    $category = $_GET['cat'];
  }

  if (!isset($_GET['order_by'])) {
    // TODO-DONE: Define behavior if an order_by value has not been specified.
      $ordering = 'date';
  }
  else {
    $ordering = $_GET['order_by'];
  }

  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }

  /* TODO-DONE: Use above values to construct a query. Use this query to
     retrieve data from the database. (If there is no form data entered,
     decide on appropriate default value/default query to make. */
    $where = ' 1=1 ';

    if ($keyword) {
        $where .= " AND itemname like '$keyword%' ";
    }

    if ($category) {
        $where .=  " AND categoryname = '$category' ";
    }

    if ($ordering == 'pricelow') {
        $orderBy = ' order by startingprice asc';
    }

    if ($ordering == 'pricehigh') {
        $orderBy = ' order by startingprice desc';
    }

    if ($ordering == 'date') {
        $orderBy = ' order by enddate desc';
    }

    $countSql = <<<SQL
select count(*) as cnt from "Items" where $where
SQL;

    $count_res = fetch_row($countSql);
  /* For the purposes of pagination, it would also be helpful to know the
     total number of results that satisfy the above query */
  $num_results = $count_res['cnt']; // TODO-DONE: Calculate me for real
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);
?>

<div class="container mt-5">

<!-- TODO-DONE: If result set is empty, print an informative message. Otherwise... -->
<?php
if ($num_results==0){
  echo 'No results matched your query';
}
?>

<ul class="list-group">

<!-- TODO-DONE: Use a while loop to print a list item for each auction listing
     retrieved from the query -->
    <?php
    $offset = ($curr_page - 1) * $results_per_page;
    $query_sql = <<<SQL
select *, (select count(*) from "Bid" where "Bid".itemid = "Items".itemid) as bids from "Items"  where $where $orderBy limit $results_per_page offset {$offset}
SQL;
    $query_data = fetch_all($query_sql);

    foreach ($query_data as $item) {
        print_listing_li($item['itemid'], $item['itemimage'], $item['itemname'], $item['itemdescription'], $item['currentprice'], $item['bids'],
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
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
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
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }

  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>
</nav>


</div>



<?php include_once("footer.php")?>
