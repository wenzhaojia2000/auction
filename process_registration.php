<?php

// Extract $_POST variables, check they're OK, and attempt to create an 
// account. Notify user of success/failure and redirect/give navigation 
// options.
require_once 'database.php';

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

// check that at least one of the account checkboxes are checked
if (!isset($_POST['accountBuyer']) && !isset($_POST['accountSeller'])) {
    $error = "You cannot be neither a buyer or seller";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}

// check entries are correctly entered (entries are not empty)
if (empty($username) == 1){
    $error = "Please enter a valid username";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($email) == 1){
    $error = "Please enter a valid email";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($password) == 1){
    $error = "Please enter a valid password";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if ($password !== $passwordConfirmation){
    $error = "Passwords do not match";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($firstName) == 1){
    $error = "Please enter a first name";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($lastName) == 1){
    $error = "Please enter a last name";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($phoneNo) == 1){
    $error = "Please enter a valid phone number";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($addressLine1) == 1){
    $error = "Please enter a valid address";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($city) == 1){
    $error = "Please enter a valid city";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}
if (empty($postcode) == 1){
    $error = "Please enter a valid postcode";
    header('Location: register.php?error=' . urlencode($error));
    exit();
}

// check username has not been taken 
$query = "SELECT COUNT(username) FROM \"User\" WHERE username = '$username'";
$res = pg_query($connection, $query);

if (pg_fetch_result($res, 0) > 0) {
    $error = "Username is taken. Try again!";
    // echo (pg_fetch_result($res, 0) > 0);
    header('Location: register.php?error=' . urlencode($error));
    exit();
  } else {
}

// hash password
$passhash = password_hash($password, PASSWORD_DEFAULT);

// message saying you have registered successfully 
echo('<div class="text-center">You are now registered. You will be redirected shortly.</div>');

// sending all of the data if successful to the database. return the user id of the resulting query.
$query = "INSERT INTO \"User\" (username, password, email, addressLine1, addressLine2, city, postcode, phoneNo, firstName, lastName)
VALUES ('$username', '$passhash', '$email', '$addressLine1', '$addressLine2', '$city',
'$postcode', '$phoneNo', '$firstName', '$lastName') RETURNING userID";
$res = pg_query($connection, $query);
$userID = pg_fetch_result($res, 0);

// adding userid to buyers and sellers table
if (isset($_POST['accountBuyer'])) {
    pg_query("INSERT INTO \"Buyer\" VALUES ($userID)");
}
if (isset($_POST['accountSeller'])) {
    pg_query("INSERT INTO \"Seller\" VALUES ($userID)");
}

//redirect to browse.php after 5 second
// header("refresh:5;url=browse.php");
?>