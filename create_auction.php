<?php 
include_once("header.php");
require_once 'database.php';
?>

<div class="container">

<!-- Create auction form -->
<div style="max-width: 800px; margin: 10px auto">
  <h2 class="my-3">Create new auction</h2>
  <div class="card">
    <div class="card-body">
      <form method="post" action="create_auction_result.php">
        <div class="form-group row">
          <label for="auctionTitle" class="col-sm-2 col-form-label text-right">Title of auction</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="auctionTitle" name="itemName" placeholder="e.g. Black mountain bike">
            <small id="titleHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> A short description of the item you're selling, which will display in listings.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionDetails" class="col-sm-2 col-form-label text-right">Description</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="auctionDetails" name="itemDescription" rows="4"></textarea>
            <small id="detailsHelp" class="form-text text-muted">Full details of the listing to help bidders decide if it's what they're looking for.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionCategory" class="col-sm-2 col-form-label text-right">Category</label>
          <div class="col-sm-10">
            <select class="form-control" id="auctionCategory" name="category">
              <option selected>Choose...</option>
                <?php
                  //this is a loop to auto insert the categories into the drop down
                  $query = "SELECT * FROM \"Category\"";
                  $categories = pg_query($connection, $query);
                  while ($row = pg_fetch_assoc($categories)) {
                    $categoryName = $row['categoryname'];
                    echo "<option value='$categoryName'> $categoryName </option>";
                  }
                ?>
                // the loop ends here
            </select>
            <small id="categoryHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Select a category for this item.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="itemCondition" class="col-sm-2 col-form-label text-right">Condition</label>
          <div class="col-sm-10">
            <select class="form-control" id="itemCondition" name="itemCondition">
              <option selected>Choose...</option>
              <option value="new">New</option>
              <option value="used">Used</option>
              <option value="broken">Broken</option>
            </select>
            <small id="conditionHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Select the item condition.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionCategory" class="col-sm-2 col-form-label text-right">Image(s)</label>
          <div class="col-sm-10">
            <input class="form-control" id="itemImage" type="file" name="itemImage[]" multiple/>
            <small id="imageImageHelp" class="form-text text-muted">Choose one or more images of the item. Supported image formats: .jpeg, .jpg, .png, .gif</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionStartPrice" class="col-sm-2 col-form-label text-right">Starting price</label>
          <div class="col-sm-10">
	        <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">£</span>
              </div>
              <input type="number" class="form-control" id="auctionStartPrice" name="startingPrice">
            </div>
            <small id="startBidHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Initial bid amount.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionReservePrice" class="col-sm-2 col-form-label text-right">Reserve price</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">£</span>
              </div>
              <input type="number" class="form-control" id="auctionReservePrice" name="reservePrice">
            </div>
            <small id="reservePriceHelp" class="form-text text-muted">Optional. Auctions that end below this price will not go through. This value is not displayed in the auction listing.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="deliveryPrice" class="col-sm-2 col-form-label text-right">Delivery</label>
          <div class="col-sm-10">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="deliveryType" id="deliveryNone" value="none" checked>
              <label class="form-check-label" for="deliveryNone">No delivery</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="deliveryType" id="deliveryPaid" value="paid">
              <label class="form-check-label" for="deliveryPaid">Paid delivery</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="deliveryType" id="deliveryFree" value="free">
              <label class="form-check-label" for="deliveryPaid">Free delivery</label>
            </div>
            <small id="deliveryPriceHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Choose whether the buyer picks up the item themselves (no delivery), whether the item should be delivered by mail (paid delivery), or whether the price of delivery is already included in the price (free delivery).</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionEndDate" class="col-sm-2 col-form-label text-right">End date</label>
          <div class="col-sm-10">
            <input type="datetime-local" class="form-control" id="auctionEndDate" name="endDate">
            <small id="endDateHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Day for the auction to end.</small>
          </div>
        </div>
        <button type="submit" class="btn btn-primary form-control">Create Auction</button>
      </form>
    </div>
  </div>
</div>

</div>


<?php include_once("footer.php")?>