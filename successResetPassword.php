<?php
session_start(); ob_start();

include("cdb.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Passsword</title>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/icon/logo.png" width="100" height="100" alt="">
              </a>
      </div>
</nav>


<div class="background">
    <div class="darkOverlay">
        <div class="container">
                     <form action="resetPassword.php" class="myForm p-4 resetPassword" method="post">
                        <h1>PASSWORD RESET</h1>
                        <p>Your password has been reset! We also sent you an email with your account updated,
                        Thank you! </p>
                        <a class="btn btn-myOutline-logIn-con ml-auto my-1 " href="index.php">Log In</a>
                    </form>
        </div>
    </div>
</div>

<footer>
    <div class="text-center myFooter">
      <p>&copy; L4Food 2017</p>
    </div>
  </footer>
  </body>
  </html>
