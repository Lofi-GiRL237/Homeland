<?php 
session_start();
define('APPURL', 'http://localhost/homeland/');

require dirname(dirname(__FILE__)) . '/config/config.php';

$categories = $conn->prepare("SELECT * FROM categories");
$categories->execute();
$allcategories = $categories->fetchAll(PDO::FETCH_OBJ);

$offers = $conn->prepare("SELECT * FROM props");
$offers->execute();
$alloffers = $offers->fetchAll(PDO::FETCH_OBJ);

$Locations = $conn->prepare("SELECT * FROM locations");
$Locations->execute();
$allLocations = $Locations->fetchAll(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Homeland &mdash; Colorlib Website Template</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="<?php echo APPURL; ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/magnific-popup.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/mediaelementplayer.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/animate.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="<?php echo APPURL; ?>css/fl-bigmug-line.css">


  <link rel="stylesheet" href="<?php echo APPURL; ?>css/aos.css">

  <link rel="stylesheet" href="<?php echo APPURL; ?>css/style.css">

</head>

<body>
  <div class="site-navbar mt-4">
    <div class="container py-1">
      <div class="row align-items-center">
        <div class="col-8 col-md-8 col-lg-4">
          <h1 class="mb-0"><a href="<?php echo APPURL; ?>index.php" class="text-white h2 mb-0"><strong>Homeland<span
                  class="text-danger">.</span></strong></a></h1>
        </div>
        <div class="col-4 col-md-4 col-lg-8">
          <nav class="site-navigation text-right text-md-right" role="navigation">

            <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#"
                class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

            <ul class="site-menu js-clone-nav d-none d-lg-block">
              <li class="active">
                <a href="<?php echo APPURL; ?>index.php">Home</a>
              </li>
              <li><a href="<?php echo APPURL; ?>sale.php?type=sale">Buy</a></li>
              <li><a href="<?php echo APPURL; ?>rent.php?type=rent">Rent</a></li>
              <li class="has-children">
                <a href="<?php echo APPURL; ?>properties.php">Properties</a>
                <ul class="dropdown arrow-top">
                  <?php foreach ($allcategories as $category): ?>
                    <li><a
                        href="<?php echo APPURL; ?>properties.php?home_type=<?php echo $category->name; ?>"><?php echo $category->name; ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </li>
              <li><a href="<?php echo APPURL; ?>about.php">About</a></li>
              <li><a href="<?php echo APPURL; ?>Contact.php">Contact</a></li>

              <?php if (isset($_SESSION['username'])): ?>
                <li class="has-children">
                  <a href="properties.php"><?php echo $_SESSION['username']; ?></a>
                  <ul class="dropdown arrow-top">
                    <a href="<?php echo APPURL; ?>auth/logout.php">Logout</a>
                    <li><a href="<?php echo APPURL; ?>user/request.php">Request</a></li>
                    <li><a href="<?php echo APPURL; ?>user/favourites.php">Favorites</a></li>
                  </ul>
                </li>
              <?php else: ?>
                <li><a href="<?php echo APPURL; ?>auth/login.php">Login</a></li>
                <li><a href="<?php echo APPURL; ?>auth/register.php">Register</a></li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>


      </div>
    </div>
  </div>

</body>