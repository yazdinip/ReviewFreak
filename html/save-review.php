
<?php
  // get database connection
  include_once './config/database.php';

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
              $sql = "INSERT INTO reviewform (id, Review, Rating) VALUES ( '$id', '$review', '$rating' )";
              $conne->query($sql);

              if ($conne->query($sql) == TRUE){
                echo "Review submitted succesfuly";
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
