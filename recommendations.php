<?php include_once("header.php")?>
<?php require("database.php")?>
<?php require("utilities.php")?>

<div class="container">

<h2 class="my-3">Recommendations for you</h2>
<p><i>Recommendations are based on collaborative filtering and will appear as soon as you have bid on an item with at least one other bid</i>.</p>

<?php
  // This page is for showing a buyer recommended items based on their bid 
  // history. It will be pretty similar to browse.php, except there is no 
  // search bar. This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
  
  // TODO: Check user's credentials (cookie/session).
  if (!$_SESSION['username'] || $_SESSION['account_buyer'] != True) {
    echo "<div class='alert alert-warning col-sm-12'><div class='card-body'>";
    echo "<span class='text-danger'> <b>Error 403:</b> You do not have permission to view this page.</span>";
    echo "</div></div>";
    header("refresh:2;url=browse.php");
    exit();
}
  // TODO: Perform a query to pull up auctions they might be interested in.
  
  // TODO: Loop through results and print them out as list items.
  
?>

<?php


if (!isset($_GET['page'])) {
    $curr_page = 1;
}
else {
    $curr_page = $_GET['page'];
}

$create_temp_table = <<<SQL
create temporary table "similar_users" as 
select "similar".userid, count(*) rank
from "Bid" target 
join "Bid" as "similar" on "target".itemid = "similar".itemid and "target".userid != "similar".userid
where "target".userid = {$_SESSION['uid']}
group by "similar".userid;

create temporary table "similar_items" as
select SUM("similar_users".rank) total_rank, "similar".itemid
from "similar_users"
join "Bid" as "similar" on "similar_users".userid = "similar".userid 
left join "Bid" target on "target".userid = {$_SESSION['uid']} and "target".itemid = "similar".itemid
where "target".itemid is null
group by "similar".itemid;

create temporary table "similar_items_2" as
SELECT total_rank, "similar_items".itemId, itemName, itemDescription, endDate
FROM "similar_items"
JOIN "Items" ON "similar_items".itemId = "Items".itemId
order by total_rank desc;

create temporary table "Bid_with_cnt_max" as
SELECT bidid, "Bid1".itemId, userId, bidPrice, bidDate, bidMax, bidCnt FROM
"Bid" "Bid1"
JOIN
(SELECT itemId, max(bidPrice) as bidMax, COUNT(bidPrice) as bidCnt 
FROM "Bid" 
GROUP BY itemId) "Bid2"
ON "Bid1".itemId = "Bid2".itemId AND bidMax = bidPrice;
SQL;

pg_query($connection, $create_temp_table);

$countSql = <<<SQL
select count(*) as cnt from (SELECT * FROM (
SELECT DISTINCT ON ("similar2".itemId) total_rank, "similar2".itemId, itemName, itemDescription, bidMax, bidCnt, endDate 
FROM "similar_items_2" as "similar2"
JOIN "Bid_with_cnt_max" as "Bwcm"
ON "similar2".itemId = "Bwcm".itemId
ORDER BY "similar2".itemid
) AS SUB
ORDER BY total_rank DESC) as sub;
SQL;

$count_res = fetch_row($countSql);
/* For the purposes of pagination, it would also be helpful to know the
   total number of results that satisfy the above query */
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
SELECT * FROM (
SELECT DISTINCT ON ("similar2".itemId) total_rank, "similar2".itemId, itemName, itemDescription, bidMax, bidCnt, endDate 
FROM "similar_items_2" as "similar2"
JOIN "Bid_with_cnt_max" as "Bwcm"
ON "similar2".itemId = "Bwcm".itemId
ORDER BY "similar2".itemid
) AS SUB
ORDER BY total_rank DESC limit $results_per_page offset {$offset};
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
            print_listing_li($item['itemid'], $image['itemimage'], $item['itemname'], $item['itemdescription'], $item['bidmax'], $item['bidcnt'],
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
  <a class="page-link" href="mybids.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
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
  <a class="page-link" href="mybids.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
</li>');
            }

            if ($curr_page != $max_page) {
                echo('
<li class="page-item">
  <a class="page-link" href="mybids.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
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