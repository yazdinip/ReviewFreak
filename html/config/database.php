
<?php
class Database{
  private $servername = "localhost";
  private $username = "root";
  private $password = "password";
  private $dbname = "phpmyadmin";
  public $conne;
  
  //Comments
  public function getConnection(){
    $this->conne = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    if ($this->conne -> connect_error){
        $response['status'] = '0';
        $response['message'] = "Error";
        return $response;
    }
    else{
      $response['status'] = '1';
      $response['connection'] = $this->conne;
      return $response;
    }
  }
}
?>
