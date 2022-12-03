<?php

// TODO—DONE: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation
// options.
require_once 'database.php';


$accountType = $_POST['accountType'];

$username = $_POST['username'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['passwordConfirmation'];
$email = $_POST['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$addressLine1 = $_POST['addressLine1'];
$addressLine2 = $_POST['addressLine2'];
$city = $_POST['city'];
$postcode = $_POST['postcode'];
$phoneNo = $_POST['phoneNo'];


// entries are correctly entered (entries are not null)
if(empty($username) == 1){
    $error = "Please enter a valid username";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($email) == 1){
    $error = "Please enter a valid email";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($password) == 1){
    $error = "Please enter a valid password";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if($password !== $passwordConfirmation){
    $error = "Passwords do not match";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($firstName) == 1){
    $error = "Please enter a first name";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($lastName) == 1){
    $error = "Please enter a last name";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($phoneNo) == 1){
    $error = "Please enter a valid phone number";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($addressLine1) == 1){
    $error = "Please enter a valid address";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}
if(empty($city) == 1){
    $error = "Please enter a valid city";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if(empty($postcode) == 1){
    $error = "Please enter a valid postcode";
    header('Location: register.php?error=' . urlencode($error));
	exit();
}

// check username has not been taken

$query = "SELECT COUNT(username) FROM \"User\" WHERE username = '$username'";
$res = pg_query($connection, $query);


if (pg_fetch_result($res, 0) > 0) {
    $error = "Username is taken. Try again!";
    echo (pg_fetch_result($res, 0) > 0);
    header('Location: register.php?error=' . urlencode($error));
	exit();
  } else {
}

$query_email = "SELECT COUNT(email) FROM \"User\" WHERE email = '$email'";
$res_email = pg_query($connection, $query_email);

if (pg_fetch_result($res_email, 0) > 0) {
    $error = "Email is taken. Try again!";
    echo (pg_fetch_result($res_email, 0) > 0);
    header('Location: register.php?error=' . urlencode($error));
    exit();
} else {
}


// message saying you have registered successfully
echo('<div class="text-center">You are now registered. You will be redirected shortly.</div>');

// sending all of the data if successful to the database

$password = md5($password);

$query = "INSERT INTO \"User\" (username, password, email, addressLine1, addressLine2, city, postcode, phoneNo, firstName, lastName)
VALUES ('$username', '$password', '$email', '$addressLine1', '$addressLine2', '$city',
'$postcode', '$phoneNo', '$firstName', '$lastName') RETURNING userid;";
$r = pg_query($connection, $query);

$row = pg_fetch_assoc($r);

$userId = $row['userid'];

if ($accountType == 'seller') {
    pg_insert($connection,'Seller', [
        'userid' => $userId
    ]);
}

if ($accountType == 'buyer') {
    pg_insert($connection,'Buyer', [
        'userid' => $userId
    ]);
}

//redirect to browse.php after 5 second
 header("refresh:5;url=browse.php");
?>
