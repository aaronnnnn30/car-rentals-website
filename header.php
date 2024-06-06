<?php
session_start();
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>The Drive Car Rentals</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicons -->
  <link href="img/car_icon.png" rel="icon">
  <link href="img/car_icon.png" rel="car_icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: NewBiz
    Theme URL: https://bootstrapmade.com/newbiz-bootstrap-business-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <h1 class="text-light"><a href="#header"><span>NewBiz</span></a></h1> -->
        <a href="./index.php" class="scrollto"><img src="img/logo-new.png" alt="" class="img-fluid"></a>
      </div>

      <nav class="main-nav float-right d-none d-lg-block">

        <?php

        if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) :

        ?>
          <ul style="color: white;">
            <li class="active"><a href="./index.php">Home</a></li>
            <li><a href="./cars.php">Explore cars</a></li>
            <li><a href="./contact.php">Contact Us</a></li>

          </ul>
          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="./profile.php">Profile</a>
                <a class="dropdown-item" href="./my-bookings.php">My Bookings</a>
                <a class="dropdown-item" href="./logout.php">Logout</a>
              </div>
            </li>
          </ul>
        <?php else : ?>
          <ul>
            <li class="active"><a href="./index.php">Home</a></li>
            <li><a href="./cars.php">Explore cars</a></li>
            <li><a href="./contact.php">Contact Us</a></li>
            <li><a href="./login.php">Login</a></li>
            <li><a href="./register.php">Register</a></li>

          </ul>
        <?php endif ?>


      </nav><!-- .main-nav -->

    </div>
  </header><!-- #header -->