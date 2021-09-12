<?php
session_start();
require("./config/db.php");
$conn = connectToDB();

if (isset($_SESSION['authenticated'])) {
  header("Location: /agora/pages/dashboard.php");
}
function valid_pass($candidate)
{
  $r1 = '/[A-Z]/';  //Uppercase
  $r2 = '/[a-z]/';  //lowercase
  $r3 = '/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
  $r4 = '/[0-9]/';  //numbers

  if (preg_match_all($r1, $candidate, $o) < 2) return false;

  if (preg_match_all($r2, $candidate, $o) < 2) return false;

  if (preg_match_all($r3, $candidate, $o) < 2) return false;

  if (preg_match_all($r4, $candidate, $o) < 2) return false;

  if (strlen($candidate) < 8) return false;

  return true;
}
if (isset($_POST['register'])) {


  $email  = $_POST['email'];
  $pass = $_POST['password'];
  $username = $_POST['username'];
  if ($email == "" || $pass == "" || $username == "") {
    echo "<script>alert('Fields should not be empty');window.location.href='register.php'</script> ";

    exit();
  }

  //   if(!valid_pass($pass)){
  //     echo "<script>alert('Password doesnt meet the requirement contain at least (1) upper case letter ,contain at least (1) lower case letter ,contain at least (1) number or special character,contain at least (8) characters in length');window.location.href='register.php'</script> ";
  //     exit();

  //   }

  $password = password_hash("$pass", PASSWORD_DEFAULT);

  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
  mysqli_real_escape_string($conn, $email);
  $query = "INSERT INTO `users`(`id`, `username`, `email`, `password`, `role`) VALUES (DEFAULT,'$username','$email','$password','student')";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  if (mysqli_affected_rows($conn) > 0) {
    echo "<script>alert('SUCCESSFULLY REGISTERED');
    window.location.href='register.php';</script>";
  } else {
    echo "<script>alert('Error Occured');</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="./static/style.css" />
  <title>Agora - Register Yourself</title>
</head>

<body class="registration">

  <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
      <div class="row d-flex">
        <div class="col-lg-6">
          <div class="card1 pb-5">
            <div class="row">
              <img src="./static/images/signin.svg" class="logo" />
            </div>
            <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
              <img src="./static/images/signin.svg" class="image" />
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card2 card border-0 px-4 py-5">
            <div class="row mb-4 px-3">
              <h6 class="mb-0 mr-4 mt-2">Sign Up </h6>

            </div>
            <div class="row px-3 mb-4">
              <div class="line"></div>
              <!-- <small class="or text-center">Login</small> -->
              <div class="line"></div>
            </div>
            <form action="register.php" method="POST">
              <div class="row px-3">
                <label class="mb-1">
                  <h6 class="mb-0 text-sm">Username</h6>
                </label>
                <input class="mb-4" type="text" name="username" placeholder="Enter a valid email address" />
              </div>
              <div class="row px-3">
                <label class="mb-1">
                  <h6 class="mb-0 text-sm">First name</h6>
                </label>
                <input class="mb-4" type="text" name="fname" placeholder="Enter ar first name" />
              </div>
              <div class="row px-3">
                <label class="mb-1">
                  <h6 class="mb-0 text-sm">Last name</h6>
                </label>
                <input class="mb-4" type="text" name="lname" placeholder="Enter a last name" />
              </div>
              <div class="row px-3">
                <label class="mb-1">
                  <h6 class="mb-0 text-sm">Email Address</h6>
                </label>
                <input class="mb-4" type="text" name="email" placeholder="Enter a valid email address" />
              </div>
              <div class="row px-3">
                <label class="mb-1">
                  <h6 class="mb-0 text-sm">Password</h6>
                </label>
                <input type="password" name="password" placeholder="Enter password" />
              </div>
              <div class="row px-3 mb-4">

              </div>
              <div class="row mb-3 px-3">
                <button type="submit" class="btn btn-blue text-center" name="register">
                  Register
                </button>
              </div>
            </form>
            <div class="row mb-4 px-3">
              <small class="font-weight-bold">Already have an account?
                <a class="text-danger" href="/qna/">Login</a></small>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-blue py-4">
        <div class="row px-3">
          <small class="ml-4 ml-sm-5 mb-2">Agora Team © 2021 . All rights reserved</small>
          <div class="social-contact ml-4 ml-sm-auto">
            <span class="fa fa-facebook mr-4 text-sm"></span>
            <span class="fa fa-google-plus mr-4 text-sm"></span>
            <span class="fa fa-linkedin mr-4 text-sm"></span>
            <span class="fa fa-twitter mr-4 mr-sm-5 text-sm"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>