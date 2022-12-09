<?php

require_once dirname(dirname(__FILE__)) . '../database.php';
require_once dirname(dirname(__FILE__)) . '../utilities.php';
require_once 'func.php';

$now = date('Y-m-d H:i:s');
$sql = <<<SQL
    select "User".username, "User".email, "Items".* from "Items" 
    inner join "User" on "Items".userid = "User".userid
    where enddate < '{$now}' and itemid not in (
    select itemid from "Sold"
    ) and currentprice >= 0
SQL;
$res = fetch_all($sql);

foreach ($res as $item) {
    $bid_sql = <<<SQL
        select "User".username, "User".email, "Bid".* from "Bid"
        inner join "User" on "Bid".userid = "User".userid
        where itemid = {$item['itemid']} order by bidprice desc limit 1
    SQL;
    $bid_res = fetch_row($bid_sql);

    if (!$bid_res) { // no bids were made
        $sell_user = $item['email'];

        postmail($sell_user,
            'eBay Deluxe: No one bidded on your item "' . $item['itemname'] . '"',
            'Your item was not sold as it had no bidders. (Name: ' . $item['itemname'] . ', Item ID: ' . $item['itemid'] . ')'
        );
        pg_insert($connection, 'Sold', [
            'itemid' => $item['itemid'],
            'userid' => NULL
        ]);
    } else if ($bid_res['currentprice'] < $bid_res['reservationprice']) { // reservation price not met
        $sell_user = $item['email'];
        $bid_user = $bid_res['email'];

        postmail($sell_user,
            'eBay Deluxe: Reserve price not met on your item "' . $item['itemname'] . '"',
            'Your item was not sold as it did not meet your reservation price. (Name: ' . $item['itemname'] . ', Item ID: ' . $item['itemid'] . ')'
        );
        postmail($bid_user,
            'eBay Deluxe: Reserve price not met on item "' . $item['itemname'] . '"',
            'You won the auction on item: (Name: ' . $item['itemname'] . ', Item ID: ' . $item['itemid'] . '), but did not meet the seller\'s reserve price.'
        );
        pg_insert($connection, 'Sold', [
            'itemid' => $item['itemid'],
            'userid' => NULL
        ]);
    } else { // item sold
        $sell_user = $item['email'];
        $bid_user = $bid_res['email'];

        postmail($sell_user,
            'eBay Deluxe: Your item "' . $item['itemname'] . '" has been sold',
            'Your item has been auctioned out to ' . $bid_res['username'] . '. Please contact them at ' . $bid_user . ' to arrange delivery. (Name: ' . $item['itemname'] . ', Item ID: ' . $item['itemid'] . ')'
        );
        postmail($bid_user,
            'eBay Deluxe: Your bid on item "' . $item['itemname'] . '" has won',
            'You won the auction on item: (Name: ' . $item['itemname'] . ', Item ID: ' . $item['itemid'] . '.) Please contact the seller ' . $item['username'] . ' using their email ' . $sell_user . ' to arrange delivery.'
        );
        pg_insert($connection, 'Sold', [
            'itemid' => $item['itemid'],
            'userid' => $bid_res['userid']
        ]);
    }
}

?>