<?php
require_once 'database.php';
require_once 'utilities.php';

// TODO-DONE: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.

if (isset($_SESSION['username'])) {
    // the user is logged in already.
    header('Location:index.php');
}

$username = pg_escape_string($connection, $_POST['username']);
$password = pg_escape_string($connection, $_POST['password']);

if (empty($username)) {
    $error = "Please enter a valid username";
    echo "<script>alert('{$error}');history.go(-1);</script>";
    exit();
}

if (empty($password)) {
    $error = "Please enter a valid password";
    echo "<script>alert('{$error}');history.go(-1);</script>";
    exit();
}

$check_sql = <<<SQL
select userid, username, password from "User" where username = '$username'
SQL;

$userData = fetch_row($check_sql);
$passhash = $userData['password'];
$verify = password_verify($password, $passhash);

if (!$userData or !$verify) {
    $error = "Email or password is incorrect";
    echo "<script>alert('{$error}');history.go(-1);</script>";
    exit();
}

session_start();
$_SESSION['logged_in'] = true;
$_SESSION['username'] = $userData['username'];
$_SESSION['uid'] = $userData['userid'];

$buyerSql = <<<SQL
select * from "Buyer" where userid = {$userData['userid']}
SQL;

$buyerUser = fetch_row($buyerSql);

if ($buyerUser) {
    $_SESSION['account_buyer'] = True;
}


$sellerSql = <<<SQL
select * from "Seller" where userid = {$userData['userid']}
SQL;

$sellerUser = fetch_row($sellerSql);

if ($sellerUser) {
    $_SESSION['account_seller'] = True;
}


echo('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');

// Redirect to index after 5 seconds
header("refresh:5;url=index.php");

?>