<?php
session_start();
require_once('initialize.php');
if(isset($_SESSION['login'])) { // check if user logged in
  header("Location:display_all.php");
}
$page_title = 'Login';
include('includes/head.php');
include('includes/nav.php');
?>

<main>
  <div class="container">
    <div class="box box-detail mt-s">
			<h2 class="mt-s txt-center">Login</h2>
      <form method="post" action="login.php" enctype="multipart/form-data">
				<div class="mt-s form-flex">
					<label>Username</label>
					<input type="text" name="username" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s">
					<label>Password</label>
					<input type="password" name="password" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s txt-center">
            <button type="submit" name="submit" class="btn btn-simple">Login</button>
				</div>
  		</form>
    </div>
	</div>
</main>

<?php
include('includes/footer.php');
?>
