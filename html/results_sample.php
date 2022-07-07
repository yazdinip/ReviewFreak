<?php
  // get database connection
  include_once './config/database.php';
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

    <?php
    if($_SERVER["REQUEST_METHOD"] == "GET"){
      if(!empty($_GET["searchBox"]) && !empty($_GET["Rating"])){
        $title = $_GET["searchBox"];
        $rating = (float)$_GET["Rating"];
        $search = "SELECT * FROM submissionform WHERE Title = '$title' AND Rating >= $rating ";
      }
      else if(!empty($_GET["searchBox"]) && empty($_GET["Rating"])){
        $title = $_GET["searchBox"];
        $search = "SELECT * FROM submissionform WHERE Title = '$title'";
      }
      else if(!empty($_GET["Rating"]) && empty($_GET["searchBox"])){
        $rating = (float)$_GET["Rating"];
        $search = "SELECT * FROM submissionform WHERE Rating >= $rating ";
      }
      else{
        $search = "SELECT * FROM submissionform";
      }
      //Create a database connection
      $database = new Database();
      $db = $database->getConnection();

      if($db['status'] == '0'){
        die("Connection failed while fetching data: ".$db['message']);
      } else {
        $conne = $db['connection'];

      //Search for the name and a rating greater than or equal the one inputted
        $result = $conne->query($search);
      }
    }?>


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
    <h3>Results:</h3>
    <div class="Results">
      <table style="width:80%; margin-top: 25px; margin: auto;">
        <tr>
          <th>Object Name</th>
          <th>Location (Coordinates)</th>
          <th>Rating</th>
        </tr>
        <?php
          if ($result->num_rows > 0){
            $rows = array();
            while($row = $result->fetch_assoc()) {
              array_push($rows, array($row["id"], $row["Title"], $row["Latitude"], $row["Longitude"],))
              ?>
                <tr>
                  <td><a <?php echo 'href="individual_sample.php?id='.$row["id"].'"'; ?>> <?php echo $row["Title"]; ?> </a></td>
                  <td> <?php echo "(".$row["Latitude"].", ".$row["Longitude"].")"; ?></td>
                  <td> <?php echo $row["Rating"]; ?></td>
                </tr>
      <?php }
          }
          else {
              echo "<td colspan='2'> No data avaiable</td>";
          }
        ?>
      </table>
      <br>
      <script>
      // Initialize and add the map
      function resultsMap() {
        var rows = <?php echo json_encode($rows); ?>;
        var points = [];
        for(var i = 0; i < rows.length; i++){
          var url = '<p>'+ rows[i][1] +'</p> <a href="individual_sample.php?id=' + rows[i][0] + "\">More Info</a>";
          var lat = parseFloat(rows[i][2]);
          var long = parseFloat(rows[i][3]);
          temp = [url, lat, long];
          points.push(temp);
        }

        // Constructing the map by passing a DOM location and options object
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 5,
          center: {lat: 43.25456028411473, lng: -79.92228956622391},
        });

        //Google Maps InfoWindow
        var infowindow = new google.maps.InfoWindow();

        // close the info window
        google.maps.event.addListener(map, 'click', function() {
          infoWindow.close();
        });

        var markers = [];
        for (var i = 0; i < points.length; i++) {
          // The marker
          markers[i] = new google.maps.Marker({
            position: {lat: points[i][1], lng: points[i][2]},
            map: map,
            details: points[i][0]
          });

          google.maps.event.addListener(markers[i], 'click', function(){
            var marker = this;
            infowindow.setContent( marker.details );
            infowindow.open(map, marker);
          });
        }
      }
    </script>

    <div id="map"></div>
    </div>
    <?php
    include 'footer.html';
   ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAm0ZHNBRqGaLQZmcToRBLz4fy_RnJeh_4&callback=resultsMap&libraries=&v=weekly" async></script>
  </body>
</html>