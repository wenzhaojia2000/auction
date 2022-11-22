<?php include_once("header.php")?>

<div class="container my-5">

<?php

//establish the connection with the PostgreSQL database */

require_once 'database.php';

/* TODO #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'], 
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */

// LIST OF VARIABLES
itemName
auctionCategory
   - all category options
itemCondition 
   - 3 options
image
auctionStartPrice
auctionReservePrice

// entries are correctly entered (entries are not null)





// Uploads files locally to a directory "images/". Doesn't add to database yet.
// From https://stackoverflow.com/questions/24895170/multiple-image-upload-php-form-with-one-input
$error=array();
$extension=array("jpeg","jpg","png","gif");
foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
      $file_name=$_FILES["files"]["name"][$key];
      $file_tmp=$_FILES["files"]["tmp_name"][$key];
      $ext=pathinfo($file_name,PATHINFO_EXTENSION);

      if(in_array($ext,$extension)) {
         if(!file_exists("images/".$txtGalleryName."/".$file_name)) {
            move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"images/".$txtGalleryName."/".$file_name);
         }
         else {
            $filename=basename($file_name,$ext);
            $newFileName=$filename.time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"images/".$txtGalleryName."/".$newFileName);
         }
      }
      else {
         array_push($error,"$file_name, ");
      }
}

/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
            

// If all is successful, let user know.
echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');


?>

</div>


<?php include_once("footer.php")?>