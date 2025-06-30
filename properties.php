<!DOCTYPE html>
<html lang="en">

<head>
  <?php require('includes/header.php');

  if (isset($_GET['home_type'])) {
    $propertyName = $_GET['home_type'];

    $property = $conn->prepare("SELECT * FROM props WHERE home_type = '$propertyName'");
    $property->execute();
    $propertyData = $property->fetchAll(PDO::FETCH_OBJ);

    // if (!$propertyData) {
    //   // Property not found, show a message or redirect
    //   echo "<script>alert('Property not found.'); window.location.href='properties.php';</script>";
    //   exit };
    }
  
  ?>
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


  </div>

  <div class="slide-one-item home-slider owl-carousel">

    <div class="site-blocks-cover overlay" style="background-image: url(images/hero_bg_1.jpg);" data-aos="fade"
      data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-10">
            <span class="d-inline-block bg-success text-white px-3 mb-3 property-offer-type rounded">For Rent</span>
            <h1 class="mb-2">871 Crenshaw Blvd</h1>
            <p class="mb-5"><strong class="h2 text-success font-weight-bold">$2,250,500</strong></p>
            <p><a href="#" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">See Details</a></p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-blocks-cover overlay" style="background-image: url(images/hero_bg_2.jpg);" data-aos="fade"
      data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-10">
            <span class="d-inline-block bg-danger text-white px-3 mb-3 property-offer-type rounded">For Sale</span>
            <h1 class="mb-2">625 S. Berendo St</h1>
            <p class="mb-5"><strong class="h2 text-success font-weight-bold">$1,000,500</strong></p>
            <p><a href="#" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">See Details</a></p>
          </div>
        </div>
      </div>
    </div>

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

      <div class="row">
        <div class="col-md-12">
          <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
            <div class="mr-auto">
              <a href="index.php" class="icon-view view-module active"><span class="icon-view_module"></span></a>
              <a href="view-list.html" class="icon-view view-list"><span class="icon-view_list"></span></a>

            </div>
            <div class="ml-auto d-flex align-items-center">
              <div>
                <a href="#" class="view-list px-3 border-right active">All</a>
                <a href="#" class="view-list px-3 border-right">Rent</a>
                <a href="#" class="view-list px-3">Sale</a>
              </div>


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
        <?php foreach ($propertyData as $propdata): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.php?id=<?php echo $propdata->id; ?>" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-<?php if ($propdata->type == "Rent") {
                    echo "success";
                  } else {
                    echo "danger";
                  } ?>"><?php echo $propdata->type; ?></span>
                </div>
                <img src="images/<?php echo $propdata->image; ?>" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.php?id=<?php echo $propdata->id; ?>">
                    <?php echo $propdata->name; ?></a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span>
                  <?php echo $propdata->location; ?></span>
                <strong
                  class="property-price text-primary mb-3 d-block text-success"><?php echo $propdata->price; ?></strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number"><?php echo $propdata->beds; ?></span>

                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number"><?php echo $propdata->bath; ?></span>

                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number"><?php echo $propdata->sq_ft; ?></span>

                  </li>
                </ul>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if (empty($propertyData)): ?>
          <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
              No properties found for this category.
            </div>
          </div>
        <?php endif; ?>
      </div>

      <?php require('includes/footer.php'); ?>

</body>

</html>