<?php
include_once './config/database.php';
session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if ( (isset($_POST['submitToken'])) && (isset($_POST['titleBox'])) ){
            if ( (!empty($_POST['submitToken'])) && (!empty($_POST['titleBox'])) ){
                if ($_POST['submitToken'] == 'QnyP&ZtwYUk6MP7awp_^=D63B*$qPbY5' ){
                
                    $titleName = $_POST['titleBox'];
                    $LatitudeText = $_POST['LatitudeBox'];
                    $LongitudeText = $_POST['LongitudeBox'];
                    $descriptionText = $_POST['DescriptionBox'];

                    $database = new Database();
                    $db = $database->getConnection();

                    $file_name = $_FILES['img']['name'];   
		            $temp_file_location = $_FILES['img']['tmp_name']; 

                
                    require 'vendor/autoload.php';
                    
                    $s3 = new Aws\S3\S3Client([
                        'region'  => 'us-east-2',
                        'version' => 'latest',
                        'credentials' => [
                            'key'    => 'AKIA6FNOZOIERVC3CIDY',
                            'secret' => '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',
                        ]
                    ]);		
                    
                    
                    $s3->putObject([
                        'Bucket' => 'myecommerceproject',
                        'Key'    => $file_name,
                        'SourceFile' => $temp_file_location 
                    ]);

                    $url = $s3->getObjectUrl('myecommerceproject', $file_name);
                  
                    if($db['status'] == '0'){
                      die("Connection failed while fetching data: ".$db['message']);
                    } else {
                        $conne = $db['connection'];
                        $sql = "INSERT INTO submissionform (Title, 
                                                            Latitude, 
                                                            Longitude, 
                                                            Description,
                                                            ImgAddress) 
                                                            VALUES 
                                                            ('$titleName',
                                                            '$LatitudeText',
                                                            '$LongitudeText',
                                                            '$descriptionText',
                                                            '$url'
                                                            )";

                        if ($conne -> query($sql) == TRUE){
                            $message = 'You have submitted a new record successfully. Thanks!';
                            echo "<SCRIPT> 
                                    alert('$message')
                                    window.location.replace('http://13.59.153.66/search.php');
                                </SCRIPT>";
                            die();
                        } else {
                            echo "Error: " . $sql . "<br>" . $conne -> error;
                        }
                        $conne -> close();
                    }

            } else {
                echo "Invalid access";
            }
        } else {
            echo "Empty data";
        }
    } else {
        echo "Data not set";

    } 
}
?>