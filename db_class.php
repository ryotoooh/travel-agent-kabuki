<?php
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
    return $this->conn;
  }

  public function getOneRecord($sql){
    // Receive an SQL query statement ($sql)
    // Run the SQL query on the database specified in the mysqli object - $conn
    $result = $this->conn->query($sql);
    // Get the results and store in an array
    $row = $result->fetch_assoc();
    // Return the results array to the calling program
    return $row;
  }

  public function getAllRecords($sql){
    // Write the PHP to run the SQL query, storing the results in a variable $result
    $result = $this->conn->query($sql);
    // We want this code to be repeated so that all results are put in the array. ...while there are still records in the results table , copy the record to $row.
    if($result->{'num_rows'} !== 0) {
      while($row = $result->fetch_assoc()){
        // Each time fetch_assoc() puts a record in the $row array, we need to move it to a multidimensional array which can store all the records
        $resultset[] = $row;
      }
      // When the loop finishes, all the query results have been put in $resultset We can now return the results to the calling program
      return $resultset;
    } else {
      return false;
    }
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
  } // end of runQuery

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
  } // end of uploadImage

  public function cleanUp($value) {
    $value = trim(htmlentities($value));
    $value = $this->conn->real_escape_string($value);
    return $value;
  }

  public function prepareQuery($sql,$region,$city,$description,$cite,$price,$image,$caption) {
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssssdss",$region,$city,$description,$cite,$price,$image,$caption);
    $stmt->execute();
    if($stmt->affected_rows) {
      return true;
    } else {
      return false;
    }
  }

  public function check_image($error) {
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
  }

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
  }
} // end of class

?>
