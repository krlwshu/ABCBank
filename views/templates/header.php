<?php require("../server/session.php");?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to ABC</title>
  <!-- <meta http-equiv="refresh" content="5"> -->
  <link rel="apple-touch-icon" sizes="57x57" href="../assets/img/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="../assets/img/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="../assets/img/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="../assets/img/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="../assets/img/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="../assets/img/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="../assets/img/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css">
  
</head>

<body>


  <nav class="navbar navbar-expand-lg  top-nav">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
        aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-menu">
        <a href="#">Personal</a>
        <ul class="navbar-nav ms-md-auto gap-2">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">English</a>
          </li>
          <li class="nav-item">
            <?php
            if(isset($_SESSION['logged_in'])){

              echo '<a class="nav-link  item-red" href="../server/logout.php" tabindex="-1" aria-disabled="true">Log Out</a>';
            } else {
              
              echo '<a class="nav-link  item-red" href="../views/login.php" tabindex="-1" aria-disabled="true">Log On</a>';
            }

          ?>


          </li>
        </ul>
      </div>
    </div>
  </nav>


    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <img class="logo" src="../assets/img/logo-text-abc.svg" alt="">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" >


        <?php 
        if(isset($_SESSION['logged_in'])){?>
        
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="manageRegistrations.php"><i class="bi bi-gear"></i> Manage Applications</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-handbag"></i> Manage Products</a>
            </li>            
            <li class="nav-item">
              <a class="nav-link" href="report.php" tabindex="-1"><i class="bi bi-cloud-download"></i> Report</a>
            </li>
          </ul>
          <?php }
          else{
          ?>
          
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item border-right">
              <a class="nav-link active"  href="index.php">Register</a>
            </li>
            <li class="nav-item border-right">
              <a class="nav-link active"  href="updateApplication.php"><i class="bi bi-pencil-square"></i>Update Application</a>
            </li>
          </ul>

          <?php }?>
          
        </div>
      </div>
      
    <?php 
    
    if(isset($_SESSION['username'])){
      echo '<div class=" pr-3" ><small>Logged in as: <b>' . $_SESSION['username']. '</b></small></div>'; 
    }

    
    ?>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
