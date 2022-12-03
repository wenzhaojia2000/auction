<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.
@session_start();
require_once 'database.php';

$bid = $_POST['bid'];
$itemId = $_POST['itemid'];

if (!is_numeric($bid) || $bid <= 0) {
    echo "<script>alert('failure;your price is invalid');history.go('-1')</script>"; exit;
}

$sql = <<<SQL
select * from "Items" where itemid = {$itemId} 
SQL;

$res = fetch_row($sql);

if (date('Y-m-d H:i:s') > $res['enddate']) {
    echo "<script>alert('failure;this bid has ended');history.go('-1')</script>"; exit;
}

if ($bid <= $res['currentprice']) {
    echo "<script>alert('failure;your price is too low');history.go('-1')</script>"; exit;
} else {
    pg_insert($connection, 'Bid', [
        'userid' => $_SESSION['uid'],
        'itemid' => $itemId,
        'bidprice' => $bid,
        'biddate' => date('Y-m-d')
    ]);

    pg_update($connection, 'Items', [
       'currentprice' => $bid,
    ], [
        'itemid' => $itemId
    ]);

    require_once './service/func.php';

    noticeToBidder($itemId);

    echo "<script>alert('bid success');history.go('-1')</script>"; exit;
}



?>
