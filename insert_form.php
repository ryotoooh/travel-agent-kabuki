<?php
session_start();
require_once('initialize.php');
if(!isset($_SESSION['login'])) { // check if user logged in
  header("Location:login_form.php");
}
$page_title = 'Add Destination';
include('includes/head.php');
include('includes/nav.php');
?>
<main>
  <div class="container">
    <div class="box box-detail mt-s">
			<h2 class="txt-center">Add Destination</h2>

      <form method="post" action="insert.php" enctype="multipart/form-data">
				<div class="mt-s form-flex">
					<label>Region</label>
					<input type="text" name="region" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
					<label>City</label>
					<input type="text" name="city" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
					<label>Description</label>
					<textarea name="description" class="input-txtarea mt-xs"></textarea>
				</div>
        <div class="mt-s">
					<label>Cite</label>
					<input type="text" name="cite" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
					<label>Price $ (Number Format Only)</label>
					<input type="text" name="price" class="input-txt mt-xs" />
				</div>
				<div class="mt-s">
          <label>Image File (200KB Maximum)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="200000" />
					<input type="file" name="image" class="btn input-file  mt-xs" />
				</div>
				<div class="mt-s">
					<label>Image Caption</label>
					<input type="text" name="caption" class="input-txt mt-xs" />
				</div>
				<div class="mt-s txt-center">
            <button type="submit" name="submit" class="btn btn-simple">Add Destination</button>
				</div>
  		</form>

    </div>
	</div>
</main>
<?php
include('includes/footer.php');
?>
