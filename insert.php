<?php
session_start();
require_once('initialize.php');
if(!isset($_SESSION['login'])) { // check if user logged in
  header("Location:login_form.php");
}
$connection = new dbController(HOST, USER, PASS, DB);
if(isset($_POST['submit'])) {
  $region = $connection->cleanUp($_POST['region']);
  $city = $connection->cleanUp($_POST['city']);
  $description = $connection->cleanUp($_POST['description']);
  $cite = $connection->cleanUp($_POST['cite']);
  $price = (double)$connection->cleanUp($_POST['price']);
  $image = 'images/' . $_FILES['image']['name'];
  $temp = $_FILES['image']['tmp_name'];
  $error = $_FILES['image']['error'];
  $caption = $connection->cleanUp($_POST['caption']);
  $page_title = 'Add Result of ' . $city;
}
include('includes/head.php');
include('includes/nav.php');

$result = false; // used to change css color
$result_msg = ''; // result message to show user
if(!isset($_POST['submit'])) { // check if form is submitted
  $result_msg = "Unauthorised access.";
} elseif(
  $connection->check_image($error)['result'] == 0 ||
  empty($region) ||
  empty($city) ||
  empty($description) ||
  empty($cite) ||
  empty($price) ||
  empty($caption) ||
  !is_float($price)
) {
  $result_msg = 'Please fill in all form fields with valid format.';
  $result_msg .= '<br />' . $connection->check_image($error)['msg'];
} else {
  $sql = "INSERT INTO products(region, city, description, cite, price, image, caption) VALUES (?,?,?,?,?,?,?)";
  if($connection->prepareQuery($sql, $region, $city, $description, $cite, $price, $image, $caption)) {
    $result_msg = 'New destination successfully added.';
    $result_msg .= '<br />' . $connection->uploadImage($temp, $image)['msg'];
    $result = true;
  } else {
    $result_msg = 'New destination not added.';
    $result_msg .= '<br />' . $connection->check_image($error)['msg'];
  }
}
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
