<?php
require_once 'database.php';

// TODO-DONE: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.

if (isset($_SESSION['username'])) {
    header('Location:index.php');
}


$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email)) {
    $error = "Please enter a valid email";
    echo "<script>alert('{$error}');history.go(-1);</script>";exit;
    exit();
}

if (empty($password)) {
    $error = "Please enter a valid password";
    echo "<script>alert('{$error}');history.go(-1);</script>";exit;
    exit();
}

$password = md5($password);

$check_sql = <<<SQL
select userid,username from "User" where email ='{$email}' and password = '{$password}'
SQL;

$userData = fetch_row($check_sql);

if (!$userData) {
    $error = "Please enter a valid account";
    echo "<script>alert('{$error}');history.go(-1);</script>";exit;
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
    $_SESSION['account_type'] = "buyer";
}


$sellerSql = <<<SQL
select * from "Seller" where userid = {$userData['userid']}
SQL;

$sellerUser = fetch_row($sellerSql);

if ($sellerUser) {
    $_SESSION['account_type'] = "seller";
}


echo('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');

// Redirect to index after 5 seconds
header("refresh:5;url=index.php");

?>
