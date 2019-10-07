
<nav>
  <div class="topnav" id="myTopnav">
    <div class="topnav-first-row">
      <a href="./index.php">Top</a><a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
    </div>
    <a href="./display.php">Destinations</a>
    <?php if(isset($_SESSION['login'])) { ?>
      <a href="./display_all.php">Update Destinations</a>
      <a href="./insert_form.php">Add Destination</a>
      <a href="./logout.php">Logout</a>
    <?php } else { ?>
      <a href="./login.php">Login</a>
    <?php } ?>
  </div>
</nav>

<script type="text/javascript">
/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
