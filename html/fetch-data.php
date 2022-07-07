
<?php
  // get database connection
  include_once './config/database.php';

  $request_data = json_decode(file_get_contents("php://input"));

  if($request_data){
    if( (isset($request_data->id)) && !empty($request_data->id) ){
      $id = $request_data->id;
    }
  }
  $database = new Database();
  $db = $database->getConnection();

  if($db['status'] == '0'){
    die("Connection failed while fetching data: ".$db['message']);
  } else {
    $conne = $db['connection'];

    //Searching database for the id given
    $search1 = "SELECT * FROM submissionform WHERE id = '$id'";
    $result1 = $conne->query($search1);

    if ($result1->num_rows > 0){
      $row = $result1->fetch_assoc();
      $response_objData = array("Title"=>$row["Title"], "Lat"=>$row["Latitude"], 
                            "Long"=>$row["Longitude"], "Description"=>$row["Description"]);
    }

    $search2 = "SELECT * FROM reviewform WHERE id = '$id'";
    $result2 = $conne->query($search2);

    $response_reviews = array();
    if($result2->num_rows > 0){
      while($row = $result2->fetch_assoc()){
        array_push($response_reviews, array("Review"=>$row["review"], "Rating"=>$row["Rating"]));
      }
    }

    $conne->close();
  }
  //$response['response_status'] = $response_status;
  //$response['response_code'] = $response_code;
  $response['response_objData'] = $response_objData;
  $response['response_reviews'] = $response_reviews;

  echo json_encode($response);
?>
