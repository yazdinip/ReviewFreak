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
      <p style = "font-size:80px"> You are already logged out. </p>
    </div>

    <?php } else { 

      unset($_SESSION['type']);
      unset($_SESSION['valid']);
      
      session_destroy();

    ?>

    <div class="reviewsite">
      <p style = "font-size:80px"> You are now logged out. </p>
    </div>

    <?php } ?>

    <div class="footer-custom">
      <footer>
          <div class="SocialMedia">
            <a href="#"><i class="icon ion-social-instagram"></i></a>
            <a href="#"><i class="icon ion-social-snapchat"></i></a>
            <a href="#"><i class="icon ion-social-twitter"></i></a>
            <a href="#"><i class="icon ion-social-facebook"></i></a>
          </div>
          <ul class="list-inline">
              <li class="list-inline-item"><a href="#">Home</a></li>
              <li class="list-inline-item"><a href="#">Services</a></li>
              <li class="list-inline-item"><a href="#">About</a></li>
              <li class="list-inline-item"><a href="#">Terms</a></li>
              <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
          </ul>
          <p class="copyright">Farzad & Pedram © 2021</p>
      </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
