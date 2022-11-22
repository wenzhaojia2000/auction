<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation 
// options.
require_once 'index.php';
// entries are correctly entered (entries are not null)
if(is_null($_POST['username'])){
    $error = "Please enter a valid username"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['password'])){
    $error = "Please enter a valid password"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['email'])){
    $error = "Please enter a valid email"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['firstName'])){
    $error = "Please enter a first name"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['lastName'])){
    $error = "Please enter a last name"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['addressLine1'])){
    $error = "Please enter a valid address"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['phoneNo'])){
    $error = "Please enter a valid phone number"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['city'])){
    $error = "Please enter a valid city"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if(is_null($_POST['postcode'])){
    $error = "Please enter a valid postcode"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}
if($_POST['password']!==$_POST['passwordConfirmation']){
    $error = "Passwords do not match"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
}

// check username has not been taken 

$query = "SELECT COUNT(username) IN 'User' WHERE username = $_POST['username']"
pg_query($query)

if(pg_query($query)>0){
    $error = "Username is taken. Try again!"
    header('Location: register.php?error=' . urlencode($error));
	 exit();
  } else {
}


// message saying you have registered successfully 
echo('<div class="text-center">You are now registered. You will be redirected shortly.</div>');

// sending all of the data if successful to the database 

$query = "INSERT INTO 'User' (username, password, email, addressLine1, addressLine2, city, postcode, phoneNo, firstName, lastName)
VALUES ($_POST['username'], $_POST['password'], $_POST['email'], $_POST['addressLine1'], $_POST['addressLine2'], $_POST['city'],
$_POST['postcode'], $_POST['phoneNo'], $_POST['firstName'], $_POST['lastName'])"
pg_query($query)

//redirect to browse.php after 5 second
header("refresh:5;url=browse.php");
?>