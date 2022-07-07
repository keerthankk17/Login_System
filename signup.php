<?php

$alert=false;     //success alert
$error=false;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
  include 'partials/_dbconnect.php';
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];

  //Check whether a username already exists
  $existSql = "SELECT * from user where uname='$username'";
  $result = mysqli_query($conn, $existSql);
  $numRows = mysqli_num_rows($result);
  if($numRows > 0)            //condition true ---> username already exists
  {
    $error = "Username already exists";
  }
  else {
    if($password == $cpassword)
    {
      $hash = password_hash($password, PASSWORD_DEFAULT);     //to encrypt passwords
      $sql = "INSERT INTO `user` (`uname`, `passwd`, `date`) VALUES ('$username', '$hash', current_timestamp())";
      $result = mysqli_query($conn, $sql);

      if($result){
        $alert=true;
      }
    }
    else{                         //password and cpassword do not match
      $error = "Password do not match";
    }
  }
}    


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css" integrity="sha384-dc2NSrAXbAkjrdm9IYrX10fQq9SDG6Vjz7nQVKdKcJl3pC+k37e7qJR5MVSCS+wR" crossorigin="anonymous">

    <title>Signup</title>
  </head>
  <body>
    <?php
        require 'partials/_nav.php'     //reference to navbar in file partials/_nav.php
    ?>
    <?php
      if($alert){
        echo '<div class="alert alert-success" role="alert">
        <strong>Success!!</strong>Login to continue
        </div>';
      }
      if($error){
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error!!</strong>'. $error .'</div>';
      }
    ?>
    <div class="container">
        <h2 class="text-center">Signup to our website</h2>

        <form action="/login_system/signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Email address</label>
                <input type="text" maxlength="25" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" name="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    -->
  </body>
</html>