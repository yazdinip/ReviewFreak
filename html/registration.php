<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Review Freak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/css/main.css" rel="stylesheet" />
    <script src="assets/js/helperFunctions.js"></script>
  </head>
  <body>
    <?php
      include 'nav_bar.html';
    ?>
    <!--It's not a good approch to deal directly with body So, create a wrapper container and make it a full-window height.-->
    <div style="background: url(assets/images/ReviewTimeTransparent.png)" class="min-height bckground-cover"> 
      <div class="container py-5">
          <header class="text-center text-dark py-5">
              <h1 class="display-4 font-weight-bold mb-4">If It Exists, We Have Reviews For It</h1>
              <p style="font-size:1.25rem;font-weight:700">Join and start helping the community</p>
          </header>
      </div>
    </div>
    <br>
    <?php 
      $is_session_valid = 0;

      if (isset($_SESSION['valid'])){
        if (!empty($_SESSION['valid'])){
          if ($_SESSION['valid'] == '1'){
            $is_session_valid = 1;
          }
        }
      }

      if ($is_session_valid == 0){
      
    ?>
    <div class="reviewsite">
      <form method="post" action="https://localhost/onRegistration.php" id = "registerForm" name = "registerForm">
        <fieldset>
          <legend>Go ahead! Register.</legend>
        </fieldset>
        <div class="signupform">
          <div class="dataform databox">
            <input id="Name" type="text" name = "nameBox" placeholder="Your Full Name" required minlength="3"/>
          </div>
          <div class="dataform infobox">
            <input id="email" type="email" name = "emailBox" placeholder="Your Email" required/> 
          </div>
          <div class="dataform infobox">
            <input id="username" type="text" name = "usernameBox" placeholder="Enter Username" autocomplete="off" required minlength="4" maxlength="12"/> 
          </div>
          <div class="dataform infobox">
            <input id="password" type="password" name = "passwordBox" placeholder="Enter Password" autocomplete="off" minlength="5" maxlength="16" required />
          </div>
          <div class="dataform infobox">
            <input id="passwordconfirm" type="password" name = "passwordConfirmBox" autocomplete="off" placeholder="Confirm Password" minlength="5" maxlength="16" required/>
          </div>
          <div class="dataform searchbtnbox">
            <input type ="hidden" name = "registerToken" value = "QnyP&ZtwYUk6MP7awp_^=D63B*$qPbY5" />
            <button class="searchbtn" type="button" onclick="return validateForm();">Signup</button>
          </div>
        </div>
      </form>
    </div>

    <?php } else { ?>

      <div class="reviewsite">
        <p style = "font-size:80px"> Please logout to view the signup form. </p>
      </div>

    <?php } ?>

    <?php
    include 'footer.html';
   ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
