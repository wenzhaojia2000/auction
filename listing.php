<!-- This is the page for one item listed. -->

<?php include_once("header.php")?>
<?php require("database.php")?>
<?php require("utilities.php")?>

<?php
  // Get info from the URL:
  $itemID = $_GET['item_id'];

  // TODO-DONE: Use item_id to make a query to the database.
    $sql = <<<SQL
select *,(select count(*) from "Bid" where "Bid".itemid = "Items".itemid) as bids from "Items" where itemid = {$itemID}
SQL;
    $item = fetch_row($sql);

  // item doesn't exist or has been deleted
  if (!$item){
    echo "<div class='alert alert-warning col-sm-12'><div class='card-body'>";
    echo "<span class='text-danger'> <b>Error 404:</b> Item not found, or has been deleted.</span>";
    echo "</div></div>";
    exit();
  }

  // select seller 
  $sql = <<<SQL
    select username from "User" where userID = (select userID from "Items" where itemid = {$itemID})
  SQL;
    $seller = fetch_row($sql)['username'];

  // get images
  $sql = <<<SQL
    select itemimage from "Image" where itemID = $itemID
  SQL;
  $image = fetch_all($sql);

  $title = trim($item['itemname']);
  $description = trim($item['itemdescription']);
  $condition = $item['itemcondition'];
  $delivery_price = $item['deliveryprice'];
  $current_price = $item['currentprice'];
  $num_bids = $item['bids'];
  $end_time = new DateTime(date('Y-m-dTH:i:s', strtotime($item['enddate'])));

  // TODO: Note: Auctions that have ended may pull a different set of data,
  //       like whether the auction ended in a sale or was cancelled due
  //       to lack of high-enough bids. Or maybe not.

  // Calculate time to auction end:
  $now = new DateTime();

  if ($now < $end_time) {
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = ' (in ' . display_time_remaining($time_to_end) . ')';
  }

  // TODO-DONE: If the user has a session, use it to make a query to the database
  //       to determine if the user is already watching this item.
  //       For now, this is hardcoded.
    if (isset($_SESSION['uid'])) {
        $sql = <<<SQL
    select * from "Watches" where userid = {$_SESSION['uid']} and itemid = {$itemID}
SQL;
    $res = fetch_row($sql);
        if ($res) {
            $has_session = true;
            $watching = true;
        } else {
            $has_session = true;
            $watching = false;
        }
    } else {
        $watching = false;
        $has_session = false;
    }
?>


<div class="container">

<div class="row"> <!-- Row #1 with auction title + watch button -->
  <div class="col-sm-8"> <!-- Left col -->
    <h2 class="my-3"><?php echo($title); ?></h2>
  </div>
  <div class="col-sm-4 align-self-center"> <!-- Right col -->
<?php
  /* The following watchlist functionality uses JavaScript, but could
     just as easily use PHP as in other places in the code */
  if ($now < $end_time):
?>
    <div id="watch_nowatch" <?php if ($has_session && $watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToWatchlist()">+ Add to watchlist</button>
    </div>
    <div id="watch_watching" <?php if (!$has_session || !$watching) echo('style="display: none"');?> >
      <button type="button" class="btn btn-success btn-sm" disabled>Watching</button>
      <button type="button" class="btn btn-danger btn-sm" onclick="removeFromWatchlist()">Remove watch</button>
    </div>
<?php endif /* Print nothing otherwise */ ?>
  </div>
</div>

<div class="row"> <!-- Row #2 with auction description + bidding info -->
  <div class="col-sm-8"> <!-- Left col with item info -->
    <!-- print author of item --->
    <div class="itemSeller"> Seller: <b> <?php echo($seller); ?></b></div><br>
    <div class="itemDescription" style="white-space: pre-wrap;"><?php echo($description); ?></div>

  </div>

  <div class="col-sm-4"> <!-- Right col with bidding info -->
    <!-- Image gallery -->
    <div id="itemImage" class="carousel slide" style="width:350px; height:400px;" data-ride="carousel">
      <div class="carousel-inner" style="width:100%; height:100%">
        <?php
        if (count($image) == 0){
          echo '<div class="carousel-item active" style="max-width:350px; max-height:400px"><img class="d-block" style="max-width:350px; max-height:400px;" src="images/noimage.png"></div>';
        } else {
          $first_image = array_slice($image, 0);
          $rest_image = array_slice($image, 1, count($image));
          echo '<div class="carousel-item active" style="max-width:350px; max-height:400px"><img class="d-block" style="max-width:350px; max-height:400px;" src="images/'. $first_image[0]['itemimage'] .'"></div>';
          foreach($rest_image as $i) {
            echo '<div class="carousel-item" style="max-width:350px; max-height:400px"><img class="d-block" style="max-width:350px; max-height:400px;" src="images/'. $i['itemimage'] .'"></div>';
          }
        }
        ?>
      </div>
      <a class="carousel-control-prev" href="#itemImage" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#itemImage" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <br>
    <ul><li>
      Condition: <b><?php echo(ucwords($condition));?></b>
    </li><li>
      <?php
        if (is_null($delivery_price)) {
          echo "<span style='color:grey'><i>No delivery</i></span>";
        } else if ($delivery_price == 0) {
          echo "<span style='color:green'><b>Free delivery</b></span>";
        } else {
          echo "Delivery: <b>£" . $delivery_price . "</b>";
        }
      ?>
    </li><li>
      <?php if ($now > $end_time): ?>
      <span style="color:red">This auction ended <b><?php echo(date_format($end_time, 'j M H:i')) ?></b></span>
      <!-- TODO: Print the result of the auction here? -->
      <?php else: ?>
      Auction ends <b><?php echo(date_format($end_time, 'j M H:i') . $time_remaining) ?></b>
  </li></ul>
    

    <p class="lead">Current bid: £<?php echo(number_format($current_price, 2)) ?></p>

    <!-- Bidding form -->
    <form method="POST" action="place_bid.php">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">£</span>
        </div>
	    <input type="number" class="form-control" id="bid" name="bid">
	    <input type="hidden" class="form-control" id="itemid" name="itemid" value="<?php echo $itemID ?>">
      </div>
      <button type="submit" class="btn btn-primary form-control">Place bid</button>
    </form>
<?php endif ?>


  </div> <!-- End of right col with bidding info -->

</div> <!-- End of row #2 -->
<br/>
</div>

<?php include_once("footer.php")?>


<script>
// JavaScript functions: addToWatchlist and removeFromWatchlist.

function addToWatchlist(button) {
  console.log("These print statements are helpful for debugging btw");

  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'add_to_watchlist', arguments: [<?php echo($itemID);?>]},

    success:
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
          // console.log(obj.res)
        var objT = obj.res.trim();

        if (objT == "success") {
          $("#watch_nowatch").hide();
          $("#watch_watching").show();
        }
        else {
          var mydiv = document.getElementById("watch_nowatch");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Add to watch failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func

function removeFromWatchlist(button) {
  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'remove_from_watchlist', arguments: [<?php echo($itemID);?>]},

    success:
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
          var objT = obj.res.trim();

        if (objT == "success") {
          $("#watch_watching").hide();
          $("#watch_nowatch").show();
        }
        else {
          var mydiv = document.getElementById("watch_watching");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Watch removal failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func
</script>
