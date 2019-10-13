<?php
session_start();
require_once('initialize.php');
if(!isset($_SESSION['login'])) { // check if user logged in
  header("Location:login_form.php");
} elseif($_SESSION['login']['access_level'] == 'Guest') {
  header("Location:index.php");
}
$connection = new dbController(HOST,USER,PASS,DB);
if(isset($_POST['submit'])) {
  $id = $connection->cleanUp($_POST['id']);
  $city = $connection->cleanUp($_POST['city']);
  $image = $connection->cleanUp($_POST['image']);
  $page_title = 'Delete Result of ' . $city;
}
include('includes/head.php');
include('includes/nav.php');

$result = false; // used to change css color
$result_msg = ''; // result message to show user
if(!isset($_POST['submit'])) { // check if form is submitted
  $result_msg = "Unauthorised access.";
} else {
  $sql = "DELETE FROM products WHERE id = '$id' LIMIT 1";
  $delete_result = $connection->runQuery($sql); // store result array
  if($delete_result['result']) { // check if the record deleted successfully
    $result_msg = 'Destination successfully deleted.';
    if(file_exists($image)) { // check if a related image is in the images folder
      unlink($image); // remove the image if exist
      $result_msg .= '<br />Image successfully deleted.';
    }
    $result = true;
  } else {
    $result_msg = 'Destination not deleted.';
    $result_msg .= '<br />' . $delete_result['msg'];
  }
}
?>

<main class="content-center">
  <div class="container">
    <div class="box box-detail">
      <div class="result-msg mt-m <?php if($result){ echo 'result-green'; } else { echo 'result-red'; } ?>">
        <p class="my-s <?php if($result){ echo 'txt-green'; } else { echo 'txt-red'; } ?>"><?php echo $result_msg; ?></p>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>
