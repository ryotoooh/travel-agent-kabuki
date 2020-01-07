<?php
session_start();
require_once('initialize.php');
$page_title = 'Destinations';
include('includes/head.php');
include('includes/nav.php');

$connection = new dbController(HOST, USER, PASS, DB);
$sql = "SELECT id, city, description, cite, image, caption FROM products";
$records = $connection->getAllRecords($sql);
?>

<main>
  <div class="txt-center container splash"  style="background-image: url('./images/bg_img_4.jpg')">
    <div class="box">
      <h2>Our freshly picked destinations</h2>
    </div>
  </div>

  <div class="container">
    <div class="box">
      <?php
      if ($records) {
        foreach($records as $row){
          $id = $row['id'];
          $city = $row['city'];
          $desc = $row['description'];
          $cite = $row['cite'];
          $img_url = $row['image'];
          $cap = $row['caption'];
          ?><div class="col-3 mt-m">
            <div class="product-box">
              <h2 class="pop-txt">
                <a href="details.php?id=<?php echo $id; ?>"><?php echo $city; ?></a>
              </h2>
              <div class="bg-black">
                <a href="details.php?id=<?php echo $id; ?>">
                  <img class="product-img" src="<?php echo $img_url; ?>" alt="<?php echo $cap; ?>" >
                </a>
              </div>
            </div>
            <p class="desc mt-xs"><?php echo implode(' ',array_slice(explode(' ',$desc),0,30)); ?>...
              <a href="details.php?id=<?php echo $id; ?>" class="detail-link">Go to detail page</a>
            </p>
          </div><?php
          } 
      } else { ?>
        <div class="result-msg mt-m result-red">
          <p class="my-s txt-red">No destinations found.</p>
        </div>
      <?php } ?>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>
