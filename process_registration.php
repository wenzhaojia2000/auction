<?php

// TODO—DONE: Extract $_POST variables, check they're OK, and attempt to create an 
// account. Notify user of success/failure and redirect/give navigation 
// options.
require_once 'database.php';

// start a session. this allows variables to be passed over to other php
// files without using POST. in particular, if the process is unsuccessful,
// we need to send the error message(s) back to register.php.
session_start();
$_SESSION['error'] = array();

$username = pg_escape_string($connection, $_POST['username']);
$password = pg_escape_string($connection, $_POST['password']);
$passwordConfirmation = pg_escape_string($connection, $_POST['passwordConfirmation']);
$email = pg_escape_string($connection, $_POST['email']);
$firstName = pg_escape_string($connection, $_POST['firstName']);
$lastName = pg_escape_string($connection, $_POST['lastName']);
$addressLine1 = pg_escape_string($connection, $_POST['addressLine1']);
$addressLine2 = pg_escape_string($connection, $_POST['addressLine2']);
$city = pg_escape_string($connection, $_POST['city']);
$postcode = pg_escape_string($connection, $_POST['postcode']);
$phoneNo = pg_escape_string($connection, $_POST['phoneNo']);

// check that at least one of the account checkboxes are checked
if (!isset($_POST['accountBuyer']) && !isset($_POST['accountSeller'])) {
    $_SESSION['error'][] = "You cannot be neither a buyer or seller";
}

// check entries are correctly entered (entries are not empty)
if (empty($username) == 1) {
    $_SESSION['error'][] = "Please enter a valid username";
} else {
    // check username has not been taken 
    $query = "SELECT COUNT(username) FROM \"User\" WHERE username = '$username'";
    $res = pg_query($connection, $query);

    if (pg_fetch_result($res, 0) > 0) {
        $_SESSION['error'][] = "Username is taken. Try again!";
    }
}

if (empty($email) == 1) {
    $_SESSION['error'][] = "Please enter a valid email";
}

// we just want to return one of these errors.
if (empty($password) == 1) {
    $_SESSION['error'][] = "Please enter a valid password";
} else if ($password !== $passwordConfirmation) {
    $_SESSION['error'][] = "Passwords do not match";
}

if (empty($firstName) == 1) {
    $_SESSION['error'][] = "Please enter a first name";
}
if (empty($lastName) == 1) {
    $_SESSION['error'][] = "Please enter a last name";
}
if (empty($phoneNo) == 1) {
    $_SESSION['error'][] = "Please enter a valid phone number";
}
if (empty($addressLine1) == 1) {
    $_SESSION['error'][] = "Please enter a valid address";
}
if (empty($city) == 1) {
    $_SESSION['error'][] = "Please enter a valid city";
}
if (empty($postcode) == 1) {
    $_SESSION['error'][] = "Please enter a valid postcode";
}

// if there are errors, return user to register.php and stop code below from executing
if ($_SESSION['error']) {
    header('Location: register.php');
    exit();
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

// no errors, so we unset the variable.
unset($_SESSION['error']);

//redirect to browse.php after 5 seconds
header("refresh:5; url=browse.php");
?>