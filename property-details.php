<!DOCTYPE html>
<html lang="en">

<head>

  <?php require('includes/header.php');

  if (isset($_GET['id']) && !empty($_GET['id'])) {
    $propertyId = $_GET['id'];
    $property = $conn->prepare("SELECT * FROM props WHERE id = :id");
    $property->bindParam(':id', $propertyId);
    $property->execute();
    $propertyDetails = $property->fetch(PDO::FETCH_OBJ);

    if ($propertyDetails) {
      $relatedimages = $conn->prepare("SELECT * FROM related_images WHERE props_id = :id");
      $relatedimages->bindParam(':id', $propertyId);
      $relatedimages->execute();
      $relatedImages = $relatedimages->fetchAll(PDO::FETCH_OBJ);

      $relatedProps = $conn->prepare("SELECT * FROM props WHERE home_type = :home_type AND id != :id ORDER BY price ASC LIMIT 3");
      $relatedProps->bindParam(':home_type', $propertyDetails->home_type);
      $relatedProps->bindParam(':id', $propertyId);
      $relatedProps->execute();
      $relatedProperties = $relatedProps->fetchAll(PDO::FETCH_OBJ);
    } else {
      $relatedImages = [];
      $relatedProperties = [];
    }
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
  </div>
  </div>
  </div>

  <div class="site-blocks-cover overlay" style="background-image: url(images/<?php echo $propertyDetails->image; ?>);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-10">
          <span class="d-inline-block text-white px-3 mb-3 property-offer-type rounded">Property Details of</span>
          <h1 class="mb-2"><?php echo $propertyDetails->name; ?></h1>
          <p class="mb-5"><strong
              class="h2 text-success font-weight-bold"><?php echo $propertyDetails->price; ?></strong></p>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section site-section-sm">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div>
            <div class="slide-one-item home-slider owl-carousel">
              <?php foreach ($relatedImages as $image): ?>
                <div><img src="images/<?php echo $image->image; ?>" alt="Image" class="img-fluid"></div>
              <?php endforeach; ?>
            </div>

          </div>
          <div class="bg-white property-body border-bottom border-left border-right">
            <div class="row mb-5">
              <div class="col-md-6">
                <strong class="text-success h1 mb-3"><?php echo $propertyDetails->price; ?></strong>
              </div>
              <div class="col-md-6">
                <ul class="property-specs-wrap mb-3 mb-lg-0  float-lg-right">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number"><?php echo $propertyDetails->beds; ?> <sup>+</sup></span>

                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number"><?php echo $propertyDetails->bath; ?></span>

                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number"><?php echo $propertyDetails->sq_ft; ?></span>

                  </li>
                </ul>
              </div>
            </div>
            <div class="row mb-5">
              <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                <span class="d-inline-block text-black mb-0 caption-text">Home Type</span>
                <strong class="d-block"><?php echo $propertyDetails->home_type; ?></strong>
              </div>
              <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                <span class="d-inline-block text-black mb-0 caption-text">Year Built</span>
                <strong class="d-block"><?php echo $propertyDetails->year_built; ?></strong>
              </div>
              <div class="col-md-6 col-lg-4 text-center border-bottom border-top py-3">
                <span class="d-inline-block text-black mb-0 caption-text">Price/Sqft</span>
                <strong class="d-block"><?php echo $propertyDetails->{'pr/sq_ft'}; ?></strong>
              </div>
            </div>
            <h2 class="h4 text-black">More Info</h2>
            <p><?php echo $propertyDetails->description; ?></p>


            <div class="row no-gutters mt-5">
              <div class="col-12">
                <h2 class="h4 text-black mb-3">Gallery</h2>
              </div>
              <?php foreach ($relatedImages as $image): ?>
                <div class="col-sm-12 col-md-4 ">
                  <a href="images/<?php echo $image->image; ?>" class="image-popup gal-item"><img
                      src="images/<?php echo $image->image; ?>" alt="Image" class="img-fluid"></a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4">

          <div class="bg-white widget border rounded">

            <h3 class="h4 text-black widget-title mb-3">Contact Agent</h3>
            <form action="request/process-request.php" method="post" class="form-contact-agent" onsubmit="return preventMultipleSubmits(this);">
              <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="form-control">
              </div>
              <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" name="phone" id="phone" class="form-control">
              </div>
          <input type="hidden" name="prop_id" value="<?php echo isset($propertyDetails->id) ? htmlspecialchars($propertyDetails->id) : ''; ?>">
          <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">
          <input type="hidden" name="admin_name" value="<?php echo isset($propertyDetails->admin_name) ? htmlspecialchars($propertyDetails->admin_name) : ''; ?>">

              <div class="form-group">
          <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Send Request">
              </div>
            </form>
          </div>
          <script>
            function preventMultipleSubmits(form) {
              if (form.submitted) return false;
              form.submitted = true;
              form.querySelector('[type="submit"]').disabled = true;
              return true;
            }
          </script>



          <?php
          // Favorites Logic: This block checks if the user is logged in and determines whether the current property
          // is already in the user's favorites, enabling the UI to show the appropriate favorite button state.
          // Adjust session and authentication handling as needed for your application.
          // Check if user is logged in (adjust according to your auth system)
          $isLoggedIn = isset($_SESSION['user_id']);
          $isFavorited = false;

          if ($isLoggedIn && isset($propertyDetails) && isset($propertyDetails->id)) {
            // Check if this property is already in user's favorites
            $favStmt = $conn->prepare("SELECT EXISTS(SELECT 1 FROM favorites WHERE user_id = :user_id AND property_id = :property_id) AS is_favorited");
            $favStmt->bindParam(':user_id', $_SESSION['user_id']);
            $favStmt->bindParam(':property_id', $propertyDetails->id);
            $favStmt->execute();
            $isFavorited = $favStmt->fetchColumn() ? true : false;
          }
          ?>

            <div class="bg-white widget border rounded mb-4">
            <h3 class="h4 text-black widget-title mb-3">Favorites</h3>
            <?php if ($isLoggedIn): ?>
              <?php if ($isFavorited): ?>
              <form action="delete-favorite.php" method="post" class="favorite-form">
                <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($propertyDetails->id); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                <button type="submit" name="submit" class="btn btn-danger btn-block mb-2" style="font-size: 1.1rem;">
                <span class="icon-heart"></span> Remove from Favorites
                </button>
              </form>
              <?php else: ?>
              <form action="add-favorite.php" method="post" class="favorite-form">
                <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($propertyDetails->id); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                <button type="submit" name="submit" class="btn btn-outline-danger btn-block mb-2"
                style="font-size: 1.1rem;">
                <span class="icon-heart-o"></span> Add to Favorites
                </button>
              </form>
              <?php endif; ?>
            <?php else: ?>
              <div class="alert alert-info mb-0">
              <span class="icon-info-circle"></span> Please <a href="<?php echo APPURL; ?>login.php">log in</a> to add
              to favorites.
              </div>
            <?php endif; ?>
            <br>

            <center>
              <h3 class="h4 text-black widget-title mb-3 ml-0">Share</h3>
            </center>
            <!-- <div class="bg-white widget border rounded"> -->
            <div class="px-3" style="text-align: center;">
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo APPURL . urlencode('property-details.php?id=' . $propertyDetails->id); ?>&quote=<?php echo urlencode($propertyDetails->name); ?>"
                class="pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
              <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($propertyDetails->name); ?>&url=<?php echo APPURL . urlencode('property-details.php?id=' . $propertyDetails->id); ?>"
                class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
              <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo APPURL . urlencode('property-details.php?id=' . $propertyDetails->id); ?>"
                class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
            </div>
            <!-- </div> -->
          </div>


        </div>
      </div>
    </div>
  </div>

  <div class="site-section site-section-sm bg-light">
    <div class="container">

      <div class="row">
        <div class="col-12">
          <div class="site-section-title mb-5">
            <h2>Related Properties</h2>
          </div>
        </div>
      </div>

      <?php foreach ($relatedProperties as $relatedProperty): ?>


        <div class="row mb-5">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.php?id=<?php echo $relatedProperty->id; ?>" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span
                    class="offer-type bg-<?php echo $relatedProperty->type === 'Sale' ? 'danger' : 'success'; ?>"><?php echo $relatedProperty->type; ?></span>

                </div>
                <img src="images/<?php echo $relatedProperty->image; ?>" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <form action="add-favorite.php" method="post" style="display:inline;">
                  <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($relatedProperty->id); ?>">
                  <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">
                  <button type="submit" name="submit" class="property-favorite" style="background:none;border:none;padding:0;">
                    <span class="icon-heart-o"></span>
                  </button>
                </form>
                <h2 class="property-title"><a href="property-details.php?id=<?php echo $relatedProperty->id; ?>"><?php echo $relatedProperty->name; ?></a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span>
                  <?php echo $relatedProperty->location; ?></span>
                <strong
                  class="property-price text-primary mb-3 d-block text-success"><?php echo $relatedProperty->price; ?></strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number"><?php echo $relatedProperty->beds; ?><sup>+</sup></span>

                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number"><?php echo $relatedProperty->bath; ?></span>

                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number"><?php echo $relatedProperty->sq_ft; ?></span>

                  </li>
                </ul>

              </div>
            </div>
          </div>




        </div>
      <?php endforeach; ?>
      <?php if (empty($relatedProperties)): ?>
        <div class="col-12">
          <p class="text-center">No related properties found.</p>
        </div>
      <?php endif; ?>
    </div>


    <?php require('includes/footer.php');
    ?>
</body>

</html>