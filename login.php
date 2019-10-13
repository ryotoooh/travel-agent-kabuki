<?php
require_once('initialize.php');
$connection = new dbController(HOST, USER, PASS, DB);
$page_title = 'Login';
include('includes/head.php');
include('includes/nav.php');

$result = false; // used to change css color
$result_msg = ''; // result message to show user

if(isset($_POST['login'])) { // check if form is submitted
	$connection = new dbController(HOST, USER, PASS, DB);
	$username = $connection->cleanUp($_POST['username']);
	$password = $connection->cleanUp($_POST['password']);
	// Check that the username and password form fields are not left blank.
	if(!empty($username) || !empty($password)) {
		if($connection->checkLogin($username, $password)){
			if($_SESSION['login']['access_level'] == 'Administrator') {
				$result = true;
				$result_msg = 'Welcome back, ' . $_SESSION['login']['firstname'];
				$result_msg .= '<br />You will be redirected to Update Destinations page in 5 seconds.';
				// Re-direct the user to the home/landing page
				header("Refresh:5; url=display_all.php");
			} elseif($_SESSION['login']['access_level'] == 'Guest') {
				$result = true;
				$result_msg = 'Welcome back, ' . $_SESSION['login']['firstname'];
				$result_msg .= '<br />You will be redirected to Add Destinations page in 5 seconds.';
				// Re-direct the user to the home/landing page
				header("Refresh:5; url=insert_form.php");
			}
 
		} else {
			$result_msg = 'Username and Password are not valid.';
		}
	}
}
?>

<main class="content-center">
	<div class="container">

	<?php if(isset($_POST['login'])){ ?>
		<div class="box box-detail">
			<div class="result-msg mt-m <?php if($result){ echo 'result-green'; } else { echo 'result-red'; } ?>">
				<p class="my-s <?php if($result){ echo 'txt-green'; } else { echo 'txt-red'; } ?>"><?php echo $result_msg; ?>
			</div>
		</div>
	<?php } ?>

	<?php if(!$result) { ?>
    <div class="box box-detail mt-s">
			<h2 class="mt-s txt-center">Login</h2>
			<p class="txt-center">Don't you have an account yet? Please <a href="register.php" class="detail-link">sign up</a>.</p>
      <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
				<div class="mt-s">
					<label>Username</label>
					<input type="text" name="username" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s">
					<label>Password</label>
					<input type="password" name="password" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s txt-center">
            <button type="submit" name="login" class="btn btn-simple">Login</button>
				</div>
  		</form>
		</div>
	<?php } ?>
	</div>
</main>

<?php
include('includes/footer.php');
?>
