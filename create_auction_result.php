<?php include_once("header.php")?>

<div class="container my-5">

<?php

//establish the connection with the PostgreSQL database */

require_once 'database.php';

/* TODO-DONE #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'],
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */


// LIST OF VARIABLES

$itemName = $_POST['itemName'];
$itemDescription = $_POST['itemDescription'];//option
$auctionCategory = $_POST['category'];
$itemCondition = $_POST['itemCondition'];
$auctionStartPrice = $_POST['startingPrice'];
$auctionReservePrice = $_POST['reservePrice'];
$deliveryType = $_POST['deliveryType'];
$auctionEndDate = $_POST['endDate'];

// entries are correctly entered (entries are not null)

if(empty($itemName) == 1){
    $error = "Please enter a valid itemName";
    header('Location: create_auction.php?error=' . urlencode($error));
    exit();
}

if(empty($auctionCategory) == 1){
    $error = "Please enter a valid category";
    header('Location: create_auction.php?error=' . urlencode($error));
    exit();
}

if(empty($itemCondition) == 1){
    $error = "Please enter a valid itemCondition";
    header('Location: create_auction.php?error=' . urlencode($error));
    exit();
}

if(empty($auctionStartPrice) == 1){
    $error = "Please enter a valid reservePrice";
    header('Location: create_auction.php?error=' . urlencode($error));
    exit();
}

if(empty($deliveryType) == 1){
    $error = "Please enter a valid deliveryType";
    header('Location: create_auction.php?error=' . urlencode($error));
    exit();
}

if(empty($auctionReservePrice) == 1){
    $auctionReservePrice = $auctionStartPrice;
}

$txtGalleryName = date('Ymd');


// Uploads files locally to a directory "images/". Doesn't add to database yet.
// From https://stackoverflow.com/questions/24895170/multiple-image-upload-php-form-with-one-input
$error=array();
$extension=array("jpeg","jpg","png","gif");

$fileArr = [];

foreach($_FILES["itemImage"]["tmp_name"] as $key=>$tmp_name) {
      $file_name=$_FILES["itemImage"]["name"][$key];
      $file_tmp=$_FILES["itemImage"]["tmp_name"][$key];
      $ext=pathinfo($file_name,PATHINFO_EXTENSION);

      $cDir = "images/".$txtGalleryName;
      if (! is_dir ( $cDir )) {
          mkdir($cDir, '0777', true);
      }

      $fileName = explode('.', $file_name)[0];

      $file_name = md5($fileName.$_SESSION['uid']) . '.' . $ext;

      if(in_array($ext, $extension)) {
         if(!file_exists("images/".$txtGalleryName."/".$file_name)) {
            move_uploaded_file($file_tmp=$_FILES["itemImage"]["tmp_name"][$key],"images/".$txtGalleryName."/".$file_name);
            $fileArr[] = $file_name;
         }
         else {
            $filename=basename($file_name,$ext);
            $newFileName=$filename.time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["itemImage"]["tmp_name"][$key],"images/".$txtGalleryName."/".$newFileName);
            $fileArr[] = $newFileName;
         }
      }
      else {
         array_push($error,"$file_name, ");
      }
}

/* TODO-DONE #3: If everything looks good, make the appropriate call to insert
            data into the database. */

if ($deliveryType == 'none' || $deliveryType == 'free') {
    $deliveryPrice = 0;
} else {
    //todo set a default price
    $deliveryPrice = 10;
}


$r = pg_insert($connection, 'Items', [
    'userid' => $_SESSION['uid'],
    'itemname' => $itemName,
    'categoryname' => $auctionCategory,
    'itemimage' => implode(',', $fileArr),
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
select itemid from "Items" where userid = '{$_SESSION['uid']}' order by itemid desc limit 1
SQL;
$res = fetch_row($sql);

$itemId = $res['itemid'];

# TODO-DONE
// If all is successful, let user know.
echo('<div class="text-center">Auction successfully created! <a href="listing.php?item_id='.$itemId.'">View your new listing.</a></div>');

?>


</div>


<?php include_once("footer.php")?>
