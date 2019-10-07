<?php
session_start();
require_once('initialize.php');
$connection = new dbController(HOST, USER, PASS, DB);

$input_value = $_GET['q'];
$search_value = $connection->cleanUp($input_value);

$sql = "SELECT id, city, description, cite, image, caption FROM products ";
$sql .= "WHERE description LIKE '%" . $search_value . "%' ";
$sql .= "OR city LIKE '%" . $search_value . "%' ";
$sql .= "OR region LIKE '%" . $search_value . "%' ";
$records = $connection->getAllRecords($sql);
$page_title = 'Search Result of ' . $search_value;
include('includes/head.php');
include('includes/nav.php');
?>

<main>
  <div class="txt-center container splash" style="background-image: url('./images/bg_img_3.jpg')">

    <div class="box">
      <h2 class="txt-shadow">Search Result of <?php echo $search_value; ?></h2>
      <form action="search.php" method="get">
        <input type="text" name="q" value="" class="search-txt" />
        <button type="submit" class="btn btn-simple">Search</button>
      </form>
    </div>

  </div>
    <div class="container">
      <div class="box">
        <?php
        if($records) {
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
        } else {
        ?>
        <p class="txt-center mt-m">
          Oops! We are sorry, we could not find any results. Please try other keywords.
        </p>
        <?php
        }
        ?>
    </div>
  </div>
</main>

<?php
include('includes/footer.php');
?>
