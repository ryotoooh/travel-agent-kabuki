<?php
session_start();
require_once('initialize.php');
if(!isset($_SESSION['login'])) { // check if user logged in
  header("Location:login_form.php");
}
$connection = new dbController(HOST,USER,PASS,DB);
if(isset($_POST['submit'])) {
  $id = $_POST['id'];
  $region = $connection->cleanUp($_POST['region']);
  $city = $connection->cleanUp($_POST['city']);
  $description = $connection->cleanUp($_POST['description']);
  $cite = $connection->cleanUp($_POST['cite']);
  $price = (double)$connection->cleanUp($_POST['price']);
  $image = 'images/' . $_FILES['image']['name'];
  $temp = $_FILES['image']['tmp_name'];
  $error = $_FILES['image']['error'];
  $caption = $connection->cleanUp($_POST['caption']);
  $page_title = 'Update Result of ' . $city;
}
include('includes/head.php');
include('includes/nav.php');

$result = false; // used to change css color
$result_msg = ''; // result message to show user
if(!isset($_POST['submit'])) { // check if form is submitted
  $result_msg = "Unauthorised access.";
} elseif(
  empty($region) ||
  empty($description) ||
  empty($cite) ||
  empty($price) ||
  empty($caption) ||
  !is_float($price)
) {
  $result_msg = 'Please fill in all form fields with valid format.';
  if($error != 0 && $error != 4) { $result_msg .= '<br />' . $connection->check_image($error)['msg']; }
} else {
  if($_FILES['image']['error'] == 4) { // check if the image is attached
    $sql = "UPDATE products SET
            region = '$region',
            description = '$description',
            cite = '$cite',
            price = '$price',
            caption = '$caption'
            WHERE id = '$id' LIMIT 1";
  } else {
    $sql = "UPDATE products SET
            region = '$region',
            description = '$description',
            cite = '$cite',
            price = '$price',
            image = '$image',
            caption = '$caption'
            WHERE id = '$id' LIMIT 1";
    $image_result = $connection->uploadImage($temp, $image); // store result array
  }
  $update_result = $connection->runQuery($sql); // store result array
  if($update_result['result']) { // check if the record inserted successfully
    $result_msg = 'Destination successfully updated.';
    if(isset($image_result['result'])) { // check if uploadImage method executed
      $result_msg .= '<br />' . $image_result['msg'];
    }
    $result = true;
  } else {
    $result_msg = 'Destination not updated.';
    $result_msg .= '<br />' . $update_result['msg'];
  }
}
?>

<main class="content-center">
  <div class="container">
    <div class="box">
      <div class="result-msg mt-m <?php if($result){ echo 'result-green'; } else { echo 'result-red'; } ?>">
        <p class="my-s <?php if($result){ echo 'txt-green'; } else { echo 'txt-red'; } ?>"><?php echo $result_msg; ?></p>
      </div>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>
