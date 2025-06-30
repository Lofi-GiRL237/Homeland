<?php //session_start() echo "username: ".$_SESSION['username']; 
require "includes/header.php";
require "config/config.php"; ?>

<?php

$select = $conn->query("SELECT * FROM props");
$select->execute();

$props = $select->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST["submit"])) {
  $type = $_POST['types'];
  $offers = $_POST['offers'];
  $cities = $_POST['cities'];

  $search = $conn->prepare("SELECT * FROM props WHERE home_type LIKE '%$type%' OR type LIKE '%$offers%' 
  OR location LIKE '%$cities%' ORDER BY price DESC");
  $search->execute();
  $listings = $search->fetchAll(PDO::FETCH_OBJ);

} else {
  header("Location: index.php");
}

// // Prepare property list
// $props = [];

// // Filter via GET (by property type)
// if (isset($_GET['type'])) {
//     $filterType = $_GET['type'];

//     if ($filterType === 'all') {
//         $query = $conn->query("SELECT * FROM props ORDER BY price DESC");
//         $props = $query->fetchAll(PDO::FETCH_OBJ);
//     } else {
//         $stmt = $conn->prepare("SELECT * FROM props WHERE type = ? ORDER BY price DESC");
//         $stmt->execute([$filterType]);
//         $props = $stmt->fetchAll(PDO::FETCH_OBJ);
//     }
// }

// // Optional: redirect or show all if no filter
// else {
//     // Default: show all
//     $query = $conn->query("SELECT * FROM props ORDER BY price DESC");
//     $props = $query->fetchAll(PDO::FETCH_OBJ);
// }


?>
<!DOCTYPE html>
<html lang="en">

<head>



</head>

<body>

  <div class="site-loader"></div>

  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->

    <!-- <div class="site-navbar mt-4">
      <div class="container py-1">
        <div class="row align-items-center">
          <div class="col-8 col-md-8 col-lg-4">
            <h1 class="mb-0"><a href="index.php" class="text-white h2 mb-0"><strong>Homeland<span
                    class="text-danger">.</span></strong></a></h1>
          </div>
          <div class="col-4 col-md-4 col-lg-8">
            <nav class="site-navigation text-right text-md-right" role="navigation">

              <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#"
                  class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

              <ul class="site-menu js-clone-nav d-none d-lg-block">
                <li class="active">
                  <a href="index.php">Home</a>
                </li>
                <li><a href="sale.php">Buy</a></li>
                <li><a href="rent.php">Rent</a></li>
                <li class="has-children">
                  <a href="properties.php">Properties</a>
                  <ul class="dropdown arrow-top">
                    <li><a href="#">Condo</a></li>
                    <li><a href="#">Property Land</a></li>
                    <li><a href="#">Commercial Building</a></li>
                  </ul>
                </li> 
                <li><a href="<?php echo APPURL; ?>about.php">About</a></li>
                <li><a href="<?php echo APPURL; ?>Contact.php">Contact</a></li>

                <?php if (isset($_SESSION['username'])): ?>
                  <li class="has-children">
                    <a href="properties.php"><?php echo $_SESSION['username']; ?></a>
                    <ul class="dropdown arrow-top">
                      <li><a href="<?php echo APPURL; ?>auth/logout.php">Logout</a></li>
                    </ul>
                  </li>
                <?php else: ?>
                  <li><a href="auth/login.php">Login</a></li>
                  <li><a href="auth/register.php">Register</a></li>
                <?php endif; ?>
              </ul>
            </nav>
          </div>


        </div>
      </div>
    </div> -->
  </div>

  <div class="slide-one-item home-slider owl-carousel">
    <?php foreach ($props as $prop): ?>
      <div class="site-blocks-cover overlay" style="background-image: url(images/<?php echo $prop->image; ?>);"
        data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">

            <div class="col-md-10">
              <span class="d-inline-block bg-<?php if ($prop->type == "Rent") {
                echo "success";
              } else {
                echo "danger";
              } ?> text-white px-3 mb-3 property-offer-type rounded"><?php echo $prop->type; ?></span>
              <h1 class="mb-2"><?php echo $prop->name; ?></h1>
              <p class="mb-5"><strong class="h2 text-success font-weight-bold"><?php echo $prop->price; ?></strong></p>
              <p><a href="property-details.php?id=<?php echo $prop->id; ?>"
                  class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">See
                  Details</a></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>


  <div class="site-section site-section-sm pb-0">
    <div class="container">
      <div class="row">
        <form class="form-search col-md-12" method="post" action="search.php" style="margin-top: -100px;">
          <div class="row  align-items-end">
            <div class="col-md-3">
              <label for="list-types">Listing Types</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="types" id="list-types" class="form-control d-block rounded-0">
                  <?php foreach ($allcategories as $category): ?>
                    <option value="<?php echo $category->name; ?>"><?php echo $category->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <label for="offer-types">Offer Type</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="offers" id="offer-types" class="form-control d-block rounded-0">
                  <?php foreach ($alloffers as $offer): ?>
                    <option value="<?php echo $offer->type; ?>"><?php echo $offer->type; ?></option>
                  <?php endforeach; ?>
                  
                  
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <label for="select-city">Select City</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="cities" id="select-city" class="form-control d-block rounded-0">
                  <?php foreach ($allLocations as $location): ?>
                    <option value="<?php echo $location->Location; ?>"><?php echo $location->Location; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <input type="submit" name="submit" class="btn btn-success text-white btn-block rounded-0" value="Search">
            </div>
          </div>
        </form>
      </div>

      <!-- <div class="row">
        <div class="col-md-12">
          <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
            <div class="mr-auto">
              <a href="<?php echo APPURL; ?>index.php" class="icon-view view-module active"><span
                  class="icon-view_module"></span></a>
              <a href="view-list.html" class="icon-view view-list"><span class="icon-view_list"></span></a>

            </div>
            <div class="ml-auto d-flex align-items-center">
              <div>
                <a href="search.php?type=all" class="view-list px-3 border-right">All</a>
                <a href="search.php?type=rent" class="view-list px-3 border-right">Rent</a>
                <a href="search.php?type=sale" class="view-list px-3">Sale</a>
              </div>
            </div> -->



            <div class="select-wrap">
              <span class="icon icon-arrow_drop_down"></span>
              <select class="form-control form-control-sm d-block rounded-0">
                <option value="">Sort by</option>
                <option value="">Price Ascending</option>
                <option value="">Price Descending</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>

  <div class="site-section site-section-sm bg-light">
    <div class="container">

      <div class="row mb-5">
        <?php if (count($listings) > 0): ?>
          <?php foreach ($listings as $listing): ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="property-entry h-100">
                <a href="property-details.php?id=<?php echo $listing->id; ?>" class="property-thumbnail">
                  <div class="offer-type-wrap">
                    <span class="offer-type bg-<?php if ($listing->type == "Rent") {
                      echo "success";
                    } else {
                      echo "danger";
                    } ?>"><?php echo $listing->type; ?></span>
                  </div>
                  <img src="images/<?php echo $listing->image; ?>" alt="Image" class="img-fluid">
                </a>
                <div class="p-4 property-body">
                  <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                  <h2 class="property-title"><a href="property-details.php?id=<?php echo $listing->id; ?>">
                      <?php echo $listing->name; ?></a></h2>
                  <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span>
                    <?php echo $listing->location; ?></span>
                  <strong
                    class="property-price text-primary mb-3 d-block text-success"><?php echo $listing->price; ?></strong>
                  <ul class="property-specs-wrap mb-3 mb-lg-0">
                    <li>
                      <span class="property-specs">Beds</span>
                      <span class="property-specs-number"><?php echo $listing->beds; ?></span>

                    </li>
                    <li>
                      <span class="property-specs">Baths</span>
                      <span class="property-specs-number"><?php echo $listing->bath; ?></span>

                    </li>
                    <li>
                      <span class="property-specs">SQ FT</span>
                      <span class="property-specs-number"><?php echo $listing->sq_ft; ?></span>

                    </li>
                  </ul>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-md-12 text-center">
            <h2>No properties found.</h2>
          </div>
        <?php endif; ?>
      </div>
    </div>





    <?php require "includes/footer.php"; ?>

</body>

</html>