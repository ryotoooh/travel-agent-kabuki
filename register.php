<?php 
require_once('initialize.php');
$connection = new dbController(HOST, USER, PASS, DB);
$page_title = 'Sign Up';
include('includes/head.php'); 
include('includes/nav.php'); 

$result = false; // used to change css color
$result_msg = ''; // result message to show user

if(isset($_POST['register'])) {
	$username = $connection->cleanUp($_POST['username']);
	$password = $connection->cleanUp($_POST['password']); 
	$firstname = $connection->cleanUp($_POST['firstname']); 
	$lastname = $connection->cleanUp($_POST['lastname']); 
	$access_level = $connection->cleanUp($_POST['access_level']); 
	// Check that all form fields are not left blank.
	if(!empty($username) || !empty($password) || !empty($firstname) || !empty($lastname)) { 
		$sql = "INSERT INTO users ";
		$sql .= "(username, password, firstname, lastname, access_level) VALUES ";
		$sql .= "('$username', '$password', '$firstname', '$lastname', '$access_level')";
		$queryResult = $connection->runQuery($sql);
		if ($queryResult['result'] == 1) { // check if the sql statement run through the server
			$result = true;
			$result_msg = 'Glad to meet you, ' . $firstname;
			$result_msg .= '<br />You will be redirected to Login page in 5 seconds.';
			// Re-direct the user to the login page
			header("Refresh:5; url=login.php"); 
		} else {
			$result_msg = $queryResult['msg'];
		}
	}
}
?>

<main class="content-center">
	<div class="container">

	<?php if(isset($_POST['register'])){ ?>
		<div class="box box-detail">
			<div class="result-msg mt-m <?php if($result){ echo 'result-green'; } else { echo 'result-red'; } ?>">
				<p class="my-s <?php if($result){ echo 'txt-green'; } else { echo 'txt-red'; } ?>"><?php echo $result_msg; ?>
			</div>
		</div>
	<?php } ?>

	<?php if(!$result) { ?>
		<div class="box box-detail mt-s">
			<h2 class="mt-s txt-center">Sign Up</h2>
			<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
				<div class="mt-s">
					<label>Username:</label>
					<input type="text" name="username" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s">
					<label>Password:</label>
					<input type="password" name="password" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s">
					<label>First Name:</label>
					<input type="text" name="firstname" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s">
					<label>Last Name:</label>
					<input type="text" name="lastname" class="input-txt mt-xs" required />
				</div>
				<div class="mt-s">
					<label>Access Level:</label>
					<select name="access_level" class="select-simple">
						<option value ="Guest">Guest</option>
						<option value ="Administrator">Administrator</option>
					</select>
				</div>
				<div class="mt-s txt-center">
					<button type="submit" name="register" class="btn btn-simple">Sign Up</button>
				</div>
			</form>
		</div>
	<?php } ?>
	</div>
</main>

<?php 
include('includes/footer.php');
?>