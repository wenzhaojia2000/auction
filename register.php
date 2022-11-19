<?php include_once("header.php")?>

<div class="container">
<h2 class="my-3">Register new account</h2>

<!-- Create auction form -->
<form method="POST" action="process_registration.php">
  <div class="form-group row">
    <label for="accountType" class="col-sm-2 col-form-label text-right">Registering as a:</label>
    <div class="col-sm-9" style="padding-top: 10px">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="accountType" id="accountBuyer" value="buyer" checked>
        <label class="form-check-label" for="accountBuyer">Buyer</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="accountType" id="accountSeller" value="seller">
        <label class="form-check-label" for="accountSeller">Seller</label>
      </div>
      <small id="accountTypeHelp" class="form-text-inline text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label for="username" class="col-sm-2 col-form-label text-right">Username</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="username" placeholder="Username">
      <small id="usernameHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
    <div class="col-sm-9">
      <input type="email" class="form-control" id="email" placeholder="Email">
      <small id="emailHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label text-right">Password</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" id="password" placeholder="Password">
      <small id="passwordHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label for="passwordConfirmation" class="col-sm-2 col-form-label text-right">Repeat password</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" id="passwordConfirmation" placeholder="Enter password again">
      <small id="passwordConfirmationHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <hr \>
  <div class="form-group row">
    <label for="firstName" class="col-sm-2 col-form-label text-right">First name</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="firstName" placeholder="First name">
      <small id="firstNameHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
    <label for="adressLine1" class="col-sm-1 col-form-label text-right">Address</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="addressLine1" placeholder="Address line 1">
      <small id="adressLine1Help" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label for="lastName" class="col-sm-2 col-form-label text-right">Last name</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="lastName" placeholder="Last name">
      <small id="lastNameHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
    <label for="adressLine2" class="col-sm-1 col-form-label text-right"></label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="addressLine2" placeholder="Address line 2">
    </div>
  </div>
  <div class="form-group row">
    <label for="phoneNo" class="col-sm-2 col-form-label text-right">Phone number</label>
    <div class="col-sm-4">
      <input type="tel" class="form-control" id="phoneNo" placeholder="Phone number">
      <small id="phoneNoHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
    <label for="city" class="col-sm-1 col-form-label text-right">City</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="city" placeholder="City">
      <small id="cityHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label text-right"></label>
    <div class="col-sm-4">
    </div>
    <label for="postcode" class="col-sm-1 col-form-label text-right">Postcode</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="postcode" placeholder="Postcode">
      <small id="postcodeHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <button type="submit" class="btn btn-primary form-control">Register</button>
  </div>
</form>

<div class="text-center">Already have an account? <a href="" data-toggle="modal" data-target="#loginModal">Login</a>
</div>

<?php include_once("footer.php")?>