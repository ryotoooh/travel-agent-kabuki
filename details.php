<?php
session_start();
require_once('initialize.php');
$connection = new dbController(HOST, USER, PASS, DB);
if(isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = '1';
}
// $id = $_GET['id'] ?? '1';
$sql = "SELECT region, city, description, cite, price, image, caption FROM products ";
$sql .= "WHERE id='" . $id . "'";
$record = $connection->getOneRecord($sql);
$page_title = $record['city'];
include('includes/head.php');
include('includes/nav.php');

$reg = $record['region'];
$city = $record['city'];
$desc = $record['description'];
$cite = $record['cite'];
$price = $record['price'];
$img_url = $record['image'];
$cap = $record['caption'];

if($record) {
?>

<main>
  <div class="container">
    <div class="box box-detail">
      <h2 class="pop-heading"><?php echo $city; ?></h2>
      <h3><?php echo $reg; ?> area</h3>
      <div class="bg-img" style="background-image: url('<?php echo $img_url; ?>')">
        <div class="bg-gray">
          <img class="product-img mt-s img-center" src="<?php echo $img_url; ?>" alt="<?php echo $cap; ?>">
        </div>
      </div>
      <div class="mt-s">
        <p class="mt-s txt-r">From <span class="price">$<?php echo number_format($price,2); ?></span></p>
        <p class="mt-s"><?php echo nl2br($desc); ?></p>
        <p class="cite mt-xs"><?php echo $cite; ?></p>
      </div>
    </div>
  </div>
</main>

<?php } else { ?>
<main class="content-center">
  <div class="container">
    <div class="box">
      <div class="result-msg mt-m result-red">
        <p class="my-s txt-red">No destination found.</p>
      </div>
    </div>
  </div>
</main>
<?php }
include('includes/footer.php');
?>
