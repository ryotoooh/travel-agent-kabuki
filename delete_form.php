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
  $page_title = 'Delete Destination of ' . $row['city'];
}
include('includes/head.php');
include('includes/nav.php');
?>

<main>
  <div class="container">
    <div class="box box-detail mt-s">
      <?php if(!empty($row)) { ?>
      <form action="delete_form.php" method="get" class="txt-r mt-s">
        <div class="list-label">Choose another destination to delete</div>
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

			<h2 class="mt-s txt-center">Delete Destination of <?php echo $row['city'] ?></h2>
      <div class="result-msg mt-s result-red">
        <p class="my-s txt-red">Please carefully choose destination to delete. This operation cannot be reverted.</p>
      </div>
      <form method="post" action="delete.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
				<div class="mt-s form-flex">
					<label>Region</label>
					<input type="text" name="region" value="<?php echo $row['region'] ?>" class="input-txt mt-xs txt-gray" readonly />
				</div>
				<div class="mt-s">
					<label>City</label>
					<input type="text" name="city" value="<?php echo $row['city'] ?>" class="input-txt mt-xs txt-gray" readonly />
				</div>
				<div class="mt-s">
					<label>Description</label>
					<textarea name="description" class="input-txtarea mt-xs txt-gray" readonly><?php echo $row['description'] ?></textarea>
				</div>
        <div class="mt-s">
					<label>Cite</label>
					<input type="text" name="cite" value="<?php echo $row['cite'] ?>" class="input-txt mt-xs txt-gray" readonly />
				</div>
				<div class="mt-s">
					<label>Price $</label>
					<input type="text" name="price" value="<?php echo $row['price'] ?>" class="input-txt mt-xs txt-gray" readonly />
				</div>
				<div class="mt-s">
          <label>Image File</label>
          <input type="hidden" name="image" value="<?php echo $row['image'] ?>" />
          <p class="my-xs txt-gray"><?php echo $row['image'] ?></p>
				</div>
				<div class="mt-s">
					<label>Image Caption</label>
					<input type="text" name="caption" value="<?php echo $row['caption'] ?>" class="input-txt mt-xs txt-gray" readonly />
				</div>
				<div class="mt-s txt-center">
            <a href="display_all.php"><input type="button" class="btn btn-simple" value="Cancel" /></a>
            <button type="submit" name="submit" class="btn btn-simple btn-danger">Delete Destination</button>
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
