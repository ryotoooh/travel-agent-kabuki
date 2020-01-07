<?php
ini_set('display_errors', 0);

class dbController {
  private $conn;

  public function __construct($host, $user, $pass, $db)
  {
    $this->conn = new mysqli(
      $this->host = $host,
      $this->user = $user,
      $this->pass = $pass,
      $this->db = $db
    );
    mysqli_set_charset($this->conn,"utf8");
    mysqli_set_charset($this->conn,"utf8");
    // database conection error handling
    if(mysqli_connect_error()) {
      exit('Unable to connect to the database: ' . mysqli_connect_error());
    } else {
      return $this->conn;
    }
    // end error handling
  }

  public function getOneRecord($sql){
    // Receive an SQL query statement ($sql)
    // Run the SQL query on the database specified in the mysqli object - $conn
    $result = $this->conn->query($sql);
    if($this->conn->error) {
      $this->logErrors($this->conn->error, $sql);
      return false;
    } else {
      // Get the results and store in an array
      $row = $result->fetch_assoc();
    }
    if(!empty($row)){
      // Return the results array to the calling program
      return $row;
    }
  }

  public function getAllRecords($sql){
    // Write the PHP to run the SQL query, storing the results in a variable $result
    $result = $this->conn->query($sql);
    // sql query error handling
    if($this->conn->error) {
      $this->logErrors($this->conn->error, $sql);
      return false;
    } else {
      while($row = $result->fetch_assoc()){
        $resultset[] = $row;
      }
    }
    // end error handling
    if(!empty($resultset)){
      return $resultset;
    }
  }

  function logErrors($error, $sql) {
    $message = '<p>Error: ' . $error . '</p>';
    $message .= '<p>Query: ' . $sql . '</p>';

    echo $message;
  }

  public function runQuery($sql) {
    $this->conn->query($sql);
    if($this->conn->error) {
      $result['msg'] = 'Error in SQL query.';
      $result['msg'] .= '<br />' . $this->conn->error;
      $result['result'] = 0;
      return $result;
    } else {
      $result['msg'] = '';
      $result['result'] = 1;
      return $result;
    }
  } // end of run query funciton

  public function uploadImage($temp, $dest) {
    if(move_uploaded_file($temp, $dest)) {
      $result['msg'] = 'Image successfully uploaded.';
      $result['result'] = 1;
      return $result;
    } else {
      $result['msg'] = 'Image not uploaded.';
      $result['result'] = 0;
      return $result;
    }
  } // end of upload image function

  public function cleanUp($value) {
    $value = trim(htmlentities($value));
    $value = $this->conn->real_escape_string($value);
    return $value;
  } // end of clean up function

  public function prepareQuery($sql,$region,$city,$description,$cite,$price,$image,$caption) {
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssssdss",$region,$city,$description,$cite,$price,$image,$caption);
    $stmt->execute();
    if($stmt->affected_rows) {
      return true;
    } else {
      return false;
    }
  } // end of prepare query function

  public function checkImage($error) {
    switch($error) {
      case 2:
        $result['msg'] = 'The maximum size of image upload exceeded. An image must be less than 200KB.';
        $result['result'] = 0;
        return $result;
      case 4:
        $result['msg'] = 'Please select an image to upload.';
        $result['result'] = 0;
        return $result;
      case 0:
        $result['msg'] = '';
        $result['result'] = 1;
        return $result;
      default:
        $result['msg'] = 'Unknown error. Please try again later or tomorrow or the next century.';
        $result['result'] = 0;
        return $result;
    }
  } // end of check image function

  public function checkUser($username, $password) {
    $sql = "SELECT id FROM users WHERE BINARY username = '$username' AND BINARY password = '$password'";
    $queryResult = $this->conn->query($sql);
    if($this->conn->error) {
      $result['msg'] = 'Error in SQL query.';
      $result['msg'] .= '<br />' . $this->conn->error;
      $result['result'] = 0;
      return $result;
    } else {
      $result = $queryResult->fetch_assoc();
      return $result; // return the results array
    }
  } // end of check user function

  public function checkLogin($username, $password) {
    // Sanitize all input from the form
    $username = $this->cleanUp($username);
    $password = $this->cleanUp($password);         
    // Run an SQL query to check that the username and password exist 
    // in the database table (and return a message if they are incorrect)
    $sql= "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1"; 
    $result = $this->conn->query($sql);        
    $row = $result->fetch_assoc();
    // use the count() function to ensure there is only 1 record
    $count = $result->num_rows;          
    if ($count > 0) {
      // If the username and password are correct
      // Get the user details from the table and place in an array
      $user = array(
        'firstname' => $row['firstname'],
        'lastname' => $row['lastname'],
        'access_level' => $row['access_level']
      );
      // Start a new session for the user
      session_start(); 
      // Place the user details (stored in the array) into the session
      $_SESSION['login'] = $user;
      return true; 
    } else {
      return false; 
    }
  } // end of check login function

  public function logOut() {
    if (isset($_SESSION['login'])) { 
      $_SESSION = array();
      session_unset();
      session_destroy(); 
    }
  } // end of log out function

} // end of class

?>
