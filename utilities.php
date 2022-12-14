<!-- NO ACTION HERE  -->

<?php

// display_time_remaining:
// Helper function to help figure out what time to display
function display_time_remaining($interval) {

    if ($interval->days == 0 && $interval->h == 0) {
      // Less than one hour remaining: print mins + seconds:
      $time_remaining = $interval->format('%im %Ss');
    }
    else if ($interval->days == 0) {
      // Less than one day remaining: print hrs + mins:
      $time_remaining = $interval->format('%hh %im');
    }
    else {
      // At least one day remaining: print days + hrs:
      $time_remaining = $interval->format('%ad %hh');
    }

  return $time_remaining;

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

// print_listing_li:
// This function prints an HTML <li> element containing an auction listing
function print_listing_li($item_id, $image, $title, $desc, $price, $num_bids, $end_time)
{
  // Truncate long descriptions
  if (strlen(trim($desc)) > 400) {
    $desc_shortened = substr($desc, 0, 400) . '...';
  }
  else {
    $desc_shortened = $desc;
  }

  // Fix language of bid vs. bids
  if ($num_bids == 1) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }

  // Calculate time to auction end
  $now = new DateTime();
  if ($now > $end_time) {
    $time_remaining = 'This auction has ended';
  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }

  // Print HTML
  echo('
    <li class="list-group-item d-flex">
    <div style="min-width:200px; min-height:200px; height:200px; width:200px; display: flex; justify-content: center; align-items: center;"><img src="images/' . $image . '" style="max-width:100%; max-height:100%"></div>
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap" style="margin-left: auto;"><span style="font-size: 1.5em">??' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>
  </li>'
  );
}

?>
