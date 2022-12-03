<!-- NO ACTION HERE  -->

<?php
  // TODO-DONE FIXME: At the moment, I've allowed these values to be set manually.
  // But eventually, with a database, these should be set automatically
  // ONLY after the user's login credentials have been verified via a
  // database query.
  session_start();
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap and FontAwesome CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom CSS file -->
  <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,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">
  <title>eBay Deluxe</title>

</head>


<body>

<!-- Navbars -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php"><img src="images/banner.png" alt="eBay Deluxe" style="height:50px"></a>
  <ul class="navbar-nav ml-auto">

<?php
  // Displays either login or logout on the right, depending on user's
  // current status (session).
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    echo '<li class="nav-item nav-link"><span>Logged in as <b>' . $_SESSION['username'] . '</b></span></li>';
    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
  }
  // don't display login if on register page (there's a seperate button for that)
  // also because the names of the password and email on the login form are the same possibly causing errors.
  else if (basename($_SERVER['PHP_SELF']) !== "register.php") {
    echo '<li class="nav-item"><button type="button" class="btn nav-link" data-toggle="modal" data-target="#loginModal">Login</button></li>';
  }
?>

  </ul>
</nav>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <ul class="navbar-nav align-middle">
	<li class="nav-item mx-1">
      <a class="nav-link" href="browse.php">Browse</a>
    </li>
<?php
  if (isset($_SESSION['account_buyer']) && $_SESSION['account_buyer'] == True) {
  echo('
	<li class="nav-item mx-1">
      <a class="nav-link" href="recommendations.php">Recommended</a>
    </li>
	<li class="nav-item mx-1">
      <a class="nav-link" href="mybids.php">My Bids</a>
    </li>');
  }
  if (isset($_SESSION['account_seller']) && $_SESSION['account_seller'] == True) {
  echo('
	<li class="nav-item mx-1">
      <a class="nav-link" href="mylistings.php">My Listings</a>
    </li>
	<li class="nav-item ml-3">
      <a class="nav-link btn border-light" href="create_auction.php">+ Create auction</a>
    </li>');
  }
?>
  </ul>
</nav>

<!-- Login modal -->
<div class="modal fade" id="loginModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Login</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="POST" action="login_result.php">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Email" name="email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
          </div>
          <button type="submit" class="btn btn-primary form-control">Sign in</button>
        </form>
        <div class="text-center" style="padding-top: 10px;">or <a href="register.php">create an account</a></div>
      </div>

    </div>
  </div>
</div> <!-- End modal -->
