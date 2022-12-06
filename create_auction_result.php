<?php

require_once 'utilities.php';
// establish the connection with the PostgreSQL database
require_once 'database.php';

session_start();
$userID = $_SESSION['uid'];
$_SESSION['error'] = array();

/* TODO-DONE #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'],
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */


// LIST OF VARIABLES

$itemName = pg_escape_string($connection, $_POST['itemName']);
$itemDescription = pg_escape_string($connection, $_POST['itemDescription']); // optional
$auctionCategory = pg_escape_string($connection, $_POST['category']);
$itemCondition = pg_escape_string($connection, $_POST['itemCondition']);
$auctionStartPrice = pg_escape_string($connection, $_POST['startingPrice']);
$auctionReservePrice = pg_escape_string($connection, $_POST['reservePrice']);
$deliveryType = pg_escape_string($connection, $_POST['deliveryType']);
$auctionEndDate = pg_escape_string($connection, $_POST['endDate']);

// entries are correctly entered (entries are not null)

if(empty($itemName) == 1){
    $_SESSION['error'][] = "Please enter a valid auction title";
}

// check category exists
$sql = <<<SQL
select * from "Category" where categoryname = '$auctionCategory'
SQL;
$res = fetch_row($sql);

if(!$res){
    $_SESSION['error'][] =  "Please enter a valid category";
}

if(!in_array($itemCondition, array('new', 'used', 'broken'))){
    $_SESSION['error'][] =  "Please enter a valid item condition";
}

if(empty($auctionStartPrice) == 1){
    $_SESSION['error'][] =  "Please enter a valid start price";
}

if(!in_array($deliveryType, array('none', 'paid', 'free'))){
    $_SESSION['error'][] =  "Please enter a valid delivery type";
}

if(empty($auctionEndDate) == 1){
    $_SESSION['error'][] =  "Please enter a valid end date";
} else if (strtotime($auctionEndDate) < time()) {
    $_SESSION['error'][] =  "End date must be in the future";
}

if(empty($auctionReservePrice) == 1){
    $auctionReservePrice = $auctionStartPrice;
} else if ($auctionReservePrice < $auctionStartPrice) {
    $_SESSION['error'][] = "Reserve price should be at least the start price";
}

// if there are errors, return user to create_auction.php and stop code below from executing
if ($_SESSION['error']) {
    header('Location: create_auction.php');
    exit();
}

// Uploads files locally to a directory "images/". Doesn't add to database yet.
// based from https://stackoverflow.com/questions/24895170/multiple-image-upload-php-form-with-one-input
$txtGalleryName = 'images/';
$extension = array("jpeg","jpg","png","gif");
$fileArr = [];

foreach($_FILES["itemImage"]["tmp_name"] as $key => $tmp_name) {
    $file_name = $_FILES["itemImage"]["name"][$key];
    $file_tmp = $_FILES["itemImage"]["tmp_name"][$key];
    $error = $_FILES["itemImage"]["error"][$key];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Error 4 is UPLOAD_ERR_NO_FILE (no file was uploaded)
    if ($error == 4) {
        $fileArr[] = NULL;
    // Error 0 is UPLOAD_ERR_OK (file uploaded fine)
    } else if ($error == 0) {
        if (! is_dir ( $txtGalleryName )) {
            mkdir($txtGalleryName, '0777', true);
        }
        
        // hash file name
        $file_name = md5($file_name . $userID) . '.' . $ext;

        if (in_array($ext, $extension)) {
            if (!file_exists($txtGalleryName . "/" . $file_name)) {
                move_uploaded_file($file_tmp = $_FILES["itemImage"]["tmp_name"][$key], $txtGalleryName . "/" . $file_name);
                $fileArr[] = $file_name;
            } else {
                $filename = basename($file_name, $ext);
                $newFileName = $filename.time() . "." . $ext;
                move_uploaded_file($file_tmp = $_FILES["itemImage"]["tmp_name"][$key], $txtGalleryName . "/" . $newFileName);
                $fileArr[] = $newFileName;
            }
        } else {
            $_SESSION['error'][] = "Invalid file format";
        }
    } else {
        $_SESSION['error'][] = "Something went wrong with file upload (error " . $error . ")";
    }
}

// do this again after file upload
if ($_SESSION['error']) {
    header('Location: create_auction.php');
    exit();
}

/* TODO-DONE #3: If everything looks good, make the appropriate call to insert
            data into the database. */

if ($deliveryType == 'none' ) {
    $deliveryPrice = NULL;
} else if ($deliveryType == 'free') {
    $deliveryPrice = 0;
} else {
    $deliveryPrice = 10;
}

$r = pg_insert($connection, 'Items', [
    'userid' => $_SESSION['uid'],
    'itemname' => $itemName,
    'categoryname' => $auctionCategory,
    'itemdescription' => $itemDescription,
    'itemcondition' => $itemCondition,
    'reservationprice' => $auctionReservePrice,
    'startingprice' => $auctionStartPrice,
    'currentprice' => $auctionStartPrice,
    'listingdate' => date('Y-m-d H:i:s'),
    'enddate' => date('Y-m-d H:i:s', strtotime($auctionEndDate)),
    'deliveryprice' => $deliveryPrice
]);

$sql = <<<SQL
select itemid from "Items" where userid = $userID order by itemid desc limit 1
SQL;
$res = fetch_row($sql);

// why php
global $itemID;
$itemID = $res['itemid'];

// insert images in the Image table
foreach ($fileArr as $image) {
    if (!is_null($image)) {
        pg_insert($connection, 'Image', [
            'itemid' => $itemID,
            'itemimage' => $image
        ]);
    }
}

# TODO-DONE
// If all is successful, let user know.
echo('<div class="text-center">Auction successfully created! <a href="listing.php?item_id='.$itemID.'">View your new listing.</a></div>');

?>