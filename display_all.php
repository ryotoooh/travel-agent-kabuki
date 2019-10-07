<?php
session_start();
require_once('initialize.php');
if(!isset($_SESSION['login'])) { // check if user logged in
  header("Location:login_form.php");
}
$connection = new dbController(HOST, USER, PASS, DB);
$sql = "SELECT id, city, description, cite, image, caption FROM products";
$records = $connection->getAllRecords($sql);
$page_title = 'Update Destinations';
include('includes/head.php');
include('includes/nav.php');
?>

<main>
  <div class="container">
    <div class="box">
      <h2 class="my-s txt-center">Update Destinations</h2>
      <?php
      if(!empty($records)) {
      ?><table>
          <thead>
            <tr class="table-head">
              <th class='id'>Id</th>
              <th>City</th>
              <th>Description</th>
              <th>Image</th>
              <th class='update'>Update</th>
              <th class='delete'>Delete</th>
            </tr>
          </thead>
          <tbody><?php
        foreach($records as $row){ // Loop through the array and display each record
          $desc = implode(' ',array_slice(explode(' ', $row['description']),0,20));
          ?><tr>
            <td class='id'><?php echo $row['id']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td><?php echo $desc; ?>...</td>
            <td class='table-img'><img src='<?php echo $row['image']; ?>' alt='<?php echo $row['caption']; ?>' class='img-s'></td>
            <td class='update'><a href='update_form.php?id=<?php echo $row['id']; ?>' class='detail-link'>Update</a></td>
            <td class='delete'><a href='delete_form.php?id=<?php echo $row['id']; ?>' class='detail-link'>Delete</a></td>
            </tr>
          <?php
        }

        ?></tbody>
      </table><?php
      } else {
      ?>
      <p class="txt-center mt-m">
        No destinations found.
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
