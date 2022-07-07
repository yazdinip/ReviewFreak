<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if ( (isset($_POST['registerToken'])) && (isset($_POST['nameBox'])) && (isset($_POST['emailBox'])) && (isset($_POST['usernameBox'])) && (isset($_POST['passwordBox'])) && (isset($_POST['passwordConfirmBox'])) ){
            if ( (!empty($_POST['registerToken'])) && (!empty($_POST['nameBox'])) && (!empty($_POST['emailBox'])) && (!empty($_POST['usernameBox'])) && (!empty($_POST['passwordBox'])) && (!empty($_POST['passwordConfirmBox'])) ){
                if ($_POST['registerToken'] == 'QnyP&ZtwYUk6MP7awp_^=D63B*$qPbY5' ){
                    if ( $_POST['passwordBox'] == $_POST['passwordConfirmBox']){
                
                        $nameText = $_POST['nameBox'];
                        $emailText = $_POST['emailBox'];
                        $usernameText = $_POST['usernameBox'];
                        $passwordText = $_POST['passwordBox'];
                        $passwordConfirmText = $_POST['passwordConfirmBox'];

                        $database = new Database();
                        $db = $database->getConnection();
            
                        if($db['status'] == '0'){
                          die("Connection failed while fetching data: ".$db['message']);
                        } else {
                            $conne = $db['connection'];
                            $sql = "INSERT INTO registrationform (fullname,  
                                                                email, 
                                                                username,
                                                                password) 
                                                                VALUES 
                                                                ('$nameText',
                                                                '$emailText',
                                                                '$usernameText',
                                                                '$passwordText'
                                                                )";

                            if ($conne -> query($sql) == TRUE){
                                $message = 'You have signed up successfully. Enjoy!';
                                echo "<SCRIPT> 
                                    alert('$message')
                                    window.location.replace('http://localhost/index.html');
                                </SCRIPT>";
                                
                                die();
                            } else {
                                echo "Error: " . $sql . "<br>" . $conne -> error;
                            }
                            $conne -> close();
                        }
                    } else {
                        echo "Passwords must match!";
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