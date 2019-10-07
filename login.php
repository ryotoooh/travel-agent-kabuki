<?php
session_start();
require_once('initialize.php');

$result = false; // used to change css color
$result_msg = ''; // result message to show user

if(!isset($_POST['submit'])) { // check if form is submitted
  $result_msg = "Unauthorised access.";
} else {
  $connection = new dbController(HOST, USER, PASS, DB);
  $username = $connection->cleanUp($_POST['username']);
  $password = $connection->cleanUp($_POST['password']);
  $array = array(
    'username' => $username,
  );
  $queryResult = $connection->checkUser($username, $password);
  if(!isset($queryResult)) { // username and password not exist or match
    $result_msg = 'Username and Password are not valid.';
  } else {
    if(isset($queryResult['result'])) { // check if any query excecution error
      $result_msg = $queryResult['msg'];
    } else { // username and password are correct
      $result = true;
      $result_msg = 'Welcome back, ' . $username;
      $result_msg .= '<br />You will be redirected to Update Destinations page in 5 seconds.';
      $_SESSION['login'] = $array; // assign session
      header("Refresh:5; url=display_all.php"); // redirect to Update Destinations page
    }
  }
}

$page_title = 'Login';
include('includes/head.php');
include('includes/nav.php');
?>

<main class="content-center">
  <div class="container">
    <div class="box">
      <div class="result-msg mt-m <?php if($result){ echo 'result-green'; } else { echo 'result-red'; } ?>">
        <p class="my-s <?php if($result){ echo 'txt-green'; } else { echo 'txt-red'; } ?>"><?php echo $result_msg; ?>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>
