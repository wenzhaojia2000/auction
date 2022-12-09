<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.
@session_start();
require_once 'database.php';
require_once 'utilities.php';

$bid = $_POST['bid'];
$itemId = $_POST['itemid'];
$_SESSION['error'] = array();

if (!is_numeric($bid) || $bid <= 0) {
    $_SESSION['error'][] = 'Invalid bid price';
}

// select seller 
$sql = <<<SQL
select userid from "User" where userID = (select userID from "Items" where itemid = {$itemId})
SQL;
$seller = fetch_row($sql)['userid'];

if ($_SESSION['uid'] == $seller) {
    $_SESSION['error'][] = 'Cannot bid on your own item';
}

$sql = <<<SQL
select * from "Items" where itemid = {$itemId} 
SQL;

$res = fetch_row($sql);

if (date('Y-m-d H:i:s') > $res['enddate']) {
    $_SESSION['error'][] = 'This auction has ended';
}

if ($bid <= $res['currentprice']) {
    $_SESSION['error'][] = 'Bid price is too low';
}

if ($bid >= 1000000000000) {
    $_SESSION['error'][] = 'Bid cannot exceed value of £1,000,000,000,000';
}

if ($_SESSION['error']) {
    header('Location: listing.php?item_id=' . $itemId);
    exit();
}

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

echo "<script>alert('Bid success');history.go('-1')</script>"; exit;
?>
