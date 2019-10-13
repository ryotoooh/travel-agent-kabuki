<?php
session_start();
require_once('initialize.php');
if(!isset($_SESSION['login'])) { // check if user logged in
  header("Location:login_form.php");
} elseif($_SESSION['login']['access_level'] == 'Guest') {
  header("Location:index.php");
}
$connection = new dbController(HOST, USER, PASS, DB);
if(isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = '1';
}
$sql = "SELECT * FROM products WHERE id=".$id;
$row = $connection->getOneRecord($sql);
if(!empty($row)) {
  $page_title = 'Update Destination of ' . $row['city'];
}
include('includes/head.php');
include('includes/nav.php');
?>

<main>
  <div class="container">
    <div class="box box-detail mt-s">
      <?php if(!empty($row)) { ?>
      <form action="update_form.php" method="get" class="txt-r mt-s">
        <div class="list-label">Choose another destination to update</div>
        <div class="selection">
          <select name="id" class="select-simple">
            <?php
            $sqlAll = "SELECT id, city FROM products";
            $records = $connection->getAllRecords($sqlAll);
            foreach($records as $record){
              echo "<option value='{$record['id']}'";
              if($id==$record['id']) { echo 'selected'; };
              echo ">{$record['city']}</option>";
            };
            ?>
          </select>
          <button type="submit" class="btn btn-simple">Go</button>
        </div>
      </form>

			<h2 class="mt-s txt-center">Update Destination of <?php echo $row['city'] ?></h2>
      <form method="post" action="update.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
				<div class="mt-s form-flex">
					<label>Region</label>
					<input type="text" name="region" value="<?php echo $row['region'] ?>" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
					<label>City (This input cannot be modified)</label>
					<input type="text" name="city" value="<?php echo $row['city'] ?>" class="input-txt mt-xs txt-gray" readonly />
				</div>
				<div class="mt-s">
					<label>Description</label>
					<textarea name="description" class="input-txtarea mt-xs"><?php echo $row['description'] ?></textarea>
				</div>
        <div class="mt-s">
					<label>Cite</label>
					<input type="text" name="cite" value="<?php echo $row['cite'] ?>" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
					<label>Price $ (Number Format Only)</label>
					<input type="text" name="price" value="<?php echo $row['price'] ?>" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
          <label>Image File (200KB Maximum)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="200000" />
          <p class="my-xs txt-gray">Current File <?php echo $row['image'] ?></p>
					<input type="file" name="image" class="btn input-file mt-xs" />
				</div>
				<div class="mt-s">
					<label>Image Caption</label>
					<input type="text" name="caption" value="<?php echo $row['caption'] ?>" class="input-txt mt-xs" />
				</div>
				<div class="mt-s txt-center">
            <button type="submit" name="submit" class="btn btn-simple">Update Destination</button>
				</div>
  		</form>
    <?php } else { ?>
        <div class="mt-s txt-center">
          There was a problem retrieving the destination data.
        </div>
    <?php } ?>
    </div>
	</div>
</main>

<?php
include('includes/footer.php');
?>
