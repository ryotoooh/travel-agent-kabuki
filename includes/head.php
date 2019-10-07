<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Mogra|Rubik:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <title>Kabuki Travel<?php if(isset($page_title)) { echo ' - ' . $page_title; } ?></title>
</head>
<body>
  <div class="page-wrap">
    <header>
      <h1><a href="index.php">Kabuki Travel</a></h1>
      <?php if(isset($_SESSION['login'])) {
        date_default_timezone_set('Australia/Melbourne');
        function welcome(){
          $time = date('H');
          $timezone = date('e');
           if($time < '12') {
             return "Ohayou";
           } elseif($time > '11' && $time < '18') {
             return "Konnichiwa";
           } elseif($time > '17') {
             return "Kombanwa";
           }
        }
      ?>
        <p class="txt-center my-xs" style="color: white; font-size: 1.25rem;">
          <?php echo welcome() . ', '; ?>
          <?php echo $_SESSION['login']['username'] . ' san.'; ?>
        </p>
      <?php } ?>
    </header>
