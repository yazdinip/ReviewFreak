
<?php
  // get database connection
  include_once './config/database.php';
  $message = "";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if ( (isset($_POST['reviewBox'])) && (isset($_POST['ratingBox'])) && (isset($_POST['idBox'])) ){
        if ( (!empty($_POST['reviewBox'])) && (!empty($_POST['ratingBox'])) && (!empty($_POST['idBox'])) ){
            $review = $_POST['reviewBox'];
            $rating = $_POST['ratingBox'];
            $id = $_POST['idBox'];
          
            $database = new Database();
            $db = $database->getConnection();

            if($db['status'] == '0'){
              die("Connection failed while fetching data: ".$db['message']);
            } else {
              $conne = $db['connection'];

              //Inserting review to database
              $sql = "INSERT INTO reviewform (id, review, Rating) VALUES ( '$id', '$review', '$rating' )";
              $result = $conne->query($sql);

              if ($result == TRUE){
                $message = 'You have submitted a new review successfully. Thanks!';
              } else {
                echo "Error: ".$sql."<br>".$conne->error;
              }
              $conne->close();
            }
        }
        else {
          echo "Empty data";
        }
  } else {
      echo "Data not set";
    }
}
?>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    //anonymous (function without name) self-invoking function to wrap our code and create an enclosed scope around it
      objectClass = function(){
        let params = new URLSearchParams(location.search);
        var id = params.get('id');
        return {id: id};
      }();
      var object;
      if (objectClass.id != ""){
        $.ajax({
          type: "POST",
          url:"fetch-data.php",
          data: JSON.stringify({'id': objectClass.id}),

          success:function(response){
            var data = JSON.parse(response);
            object = data.response_objData;
            var reviews = data.response_reviews;
            console.log(reviews);
            //Populating information about the objects using the response from database
            var elementsArray = document.getElementsByClassName("Individual");
            elementsArray[0].innerHTML = 
            "<div> " +
              "<h1>" +  object.Title + "<i>" + " (" + object.Lat + "," + object.Long + ")" + "</i>" + "</h1>" +
              "<p>" + object.Description + "</p>" +
              "<div " + "id=" + "map" + ">" + "</div>";
            "</div>";

            //Populating reviews using the response from database
            var elementsArray = document.getElementsByClassName("Reviews");
            if (reviews.length == 0){
              elementsArray[0].innerHTML += 
              "<p style=\"font-size: 30px\"> No reviews are avaiable, be the first to submit!</p>";
            }
            for(var i=0 ; i < reviews.length; i++){
              console.log(reviews[i].Review);
              elementsArray[0].innerHTML += 
              "<p>" + reviews[i].Rating + "/10. " +  reviews[i].Review + "</p>";
            }
            //Adding google map scripts at the end of document dynamically
            var my_awesome_script = document.createElement('script');
            my_awesome_script.setAttribute('src','https://maps.googleapis.com/maps/api/js?key=AIzaSyAm0ZHNBRqGaLQZmcToRBLz4fy_RnJeh_4&callback=individualMap&libraries=&v=weekly');
            document.body.appendChild(my_awesome_script);

            //Populate a hidden input field 
            document.getElementById('id').value = objectClass.id;
          }
        });
      }
       </script>

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

    <div class="Individual"></div>
    <br>
    <div class="Reviews">
      <!--<p>Andy's Review: 7/10. Love the location, really close to the subway and friendly people.</p>
      <p>Pam's Review: 8/10. Beautiful neighbourhood with multiple tourist attractions around.</p> 
      <p>Jim's Review: 3/10. Have not had a good expereince at my time in the neighbourhood.</p> -->
    </div>
    <br><br>
    <?php 
      $is_session_valid = 0;

      if (isset($_SESSION['valid'])){
        if (!empty($_SESSION['valid'])){
          if ($_SESSION['valid'] == '1'){
            $is_session_valid = 1;
          }
        }
      }

      if ($is_session_valid == 1){
      
    ?>
    <div class="reviewsite">
      <form method="post" action="" id = "submitForm" name = "submitForm">
        <fieldset>
          <legend>Go ahead! Submit a review.</legend>
        </fieldset>
        <div class="submitform">
          <div class="dataform databox" style="width:30%">
            <input id="Review" type="text" name = "reviewBox" placeholder="Review" required minlength="6" maxlength="50"/>
          </div>
          <div class="dataform databox">
            <input id="Rating" type="number" step = "any" name = "ratingBox" placeholder="Rating" required min="0" max="10"/>
          </div>
          <div class="dataform searchbtnbox01">
            <input id='id' type ="hidden" name = "idBox" value = "" />
            <button class="searchbtn01" type="submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
    <?php } else { ?>
      <div class="reviewsite">
        <p style = "font-size:80px"> Please login to submit a review. </p>
      </div>
    <?php } ?>

    <?php
    include 'footer.html';
   ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
      function individualMap(){
        // Constructing the map by passing a DOM location and options object
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 12,
          center: {lat: parseFloat(object.Lat), lng: parseFloat(object.Long)},
        });

        //default value for individual object page for grades
        var position = {lat: parseFloat(object.Lat), lng:parseFloat(object.Long)};

        var marker = new google.maps.Marker({
            position: position,
            map: map,
          });
      }
    </script>
    <script>
      var message = <?php echo json_encode($message); ?>;
      if(message != ""){
        alert(message);
      }
    </script>
  </body>
</html>