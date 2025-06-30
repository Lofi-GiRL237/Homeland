<?php //session_start() echo "username: ".$_SESSION['username']; 
require "includes/header.php";
require "config/config.php"; ?>

<?php

$select = $conn->query("SELECT * FROM props ORDER By name  DESC");

$select->execute();
$props = $select->fetchAll(PDO::FETCH_OBJ);

$alllistings = [];

if(isset($_GET['type'])) {
    $type = $_GET['type'];
    $query = $conn->prepare("SELECT * FROM props WHERE type = :type");
    $query->bindParam(':type', $type, PDO::PARAM_STR);
    $query->execute();
    $alllistings = $query->fetchAll(PDO::FETCH_OBJ);
}



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
                <li><a href="sale.php?type=sale">Buy</a></li>
                <li><a href="rent.php?type=rent">Rent</a></li>
                 <li class="has-children">
                  <a href="properties.php">Properties</a>
                  <ul class="dropdown arrow-top">
                    <li><a href="#">Condo</a></li>
                    <li><a href="#">Property Land</a></li>
                    <li><a href="#">Commercial Building</a></li>
                  </ul>
                </li> 
                <li><a href="<?php echo APPURL; ?>about.php">About</a></li>
                <li><a href="<?php echo APPURL; ?>contact.php">Contact</a></li>

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

      <div class="row">
        <div class="col-md-12">
          <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
            <div class="mr-auto">
              <a href="<?php echo APPURL; ?>index.php" class="icon-view view-module active"><span
                  class="icon-view_module"></span></a>
              <a href="view-list.html" class="icon-view view-list"><span class="icon-view_list"></span></a>

            </div>
            <div class="ml-auto d-flex align-items-center">
              <div>
                <a href="<?php echo APPURL; ?>index.php" class="view-list px-3 border-right active">All</a>
                <a href="<?php echo APPURL; ?>rent.php?type=rent" class="view-list px-3 border-right">Rent</a>
                <a href="<?php echo APPURL; ?>sale.php?type=sale" class="view-list px-3">Sale</a>
                <a href="price.php?price=DESC" class="view-list px-3">Price Descending</a>
                <a href="price.php?price=ASC" class="view-list px-3">Price Ascending</a>

              </div>


              <!-- <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select class="form-control form-control-sm d-block rounded-0">
                  <option value="">Sort by</option>
                  <option value="">Price Ascending</option>
                  <option value="">Price Descending</option>
                </select>
              </div> -->
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="site-section site-section-sm bg-light">
    <div class="container">

      <div class="row mb-5">
        <?php foreach ($alllistings as $alllisting): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.php?id=<?php echo $alllisting->id; ?>" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-<?php if ($alllisting->type == "Rent") {
                    echo "success";
                  } else {
                    echo "danger";
                  } ?>"><?php echo $alllisting->type; ?></span>
                </div>
                <img src="images/<?php echo $alllisting->image; ?>" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
                <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                <h2 class="property-title"><a href="property-details.php?id=<?php echo $alllisting->id; ?>">
                    <?php echo $alllisting->name; ?></a></h2>
                <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span>
                  <?php echo $alllisting->location; ?></span>
                <strong class="property-price text-primary mb-3 d-block text-success"><?php echo $alllisting->price; ?></strong>
                <ul class="property-specs-wrap mb-3 mb-lg-0">
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number"><?php echo $alllisting->beds; ?></span>

                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number"><?php echo $alllisting->bath; ?></span>

                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number"><?php echo $alllisting->sq_ft; ?></span>

                  </li>
                </ul>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>


    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 text-center">
          <div class="site-section-title">
            <h2>Why Choose Us?</h2>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error
            corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate
            officia.</p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 col-lg-4">
          <a href="#" class="service text-center">
            <span class="icon flaticon-house"></span>
            <h2 class="service-heading">Research Subburbs</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iure qui natus perspiciatis ex odio
              molestia.</p>
            <p><span class="read-more">Read More</span></p>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <a href="#" class="service text-center">
            <span class="icon flaticon-sold"></span>
            <h2 class="service-heading">Sold Houses</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iure qui natus perspiciatis ex odio
              molestia.</p>
            <p><span class="read-more">Read More</span></p>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <a href="#" class="service text-center">
            <span class="icon flaticon-camera"></span>
            <h2 class="service-heading">Security Priority</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iure qui natus perspiciatis ex odio
              molestia.</p>
            <p><span class="read-more">Read More</span></p>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center">
            <div class="site-section-title">
              <h2>Recent Blog</h2>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate officia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
            <a href="#"><img src="images/img_4.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
            <a href="#"><img src="images/img_2.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="300">
            <a href="#"><img src="images/img_3.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>

        </div>

      </div>
    </div> -->


  <div class="site-section bg-light">
    <div class="container">
      <div class="row mb-5 justify-content-center">
        <div class="col-md-7">
          <div class="site-section-title text-center">
            <h2>Our Agents</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero magnam officiis ipsa eum pariatur labore
              fugit amet eaque iure vitae, repellendus laborum in modi reiciendis quis! Optio minima quibusdam,
              laboriosam.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
          <div class="team-member">

            <img src="images/person_1.jpg" alt="Image" class="img-fluid rounded mb-4">

            <div class="text">

              <h2 class="mb-2 font-weight-light text-black h4">Megan Smith</h2>
              <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi dolorem totam non quis facere blanditiis
                praesentium est. Totam atque corporis nisi, veniam non. Tempore cupiditate, vitae minus obcaecati
                provident beatae!</p>
              <p>
                <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
              </p>
            </div>

          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
          <div class="team-member">

            <img src="images/person_2.jpg" alt="Image" class="img-fluid rounded mb-4">

            <div class="text">

              <h2 class="mb-2 font-weight-light text-black h4">Brooke Cagle</h2>
              <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, cumque vitae voluptates culpa earum
                similique corrupti itaque veniam doloribus amet perspiciatis recusandae sequi nihil tenetur ad, modi
                quos id magni!</p>
              <p>
                <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
              </p>
            </div>

          </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
          <div class="team-member">

            <img src="images/person_3.jpg" alt="Image" class="img-fluid rounded mb-4">

            <div class="text">

              <h2 class="mb-2 font-weight-light text-black h4">Philip Martin</h2>
              <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores illo iusto, inventore, iure dolorum
                officiis modi repellat nobis, praesentium perspiciatis, explicabo. Atque cupiditate, voluptates pariatur
                odit officia libero veniam quo.</p>
              <p>
                <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
              </p>
            </div>

          </div>
        </div>



      </div>
    </div>
  </div>


  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="mb-5">
            <h3 class="footer-heading mb-4">About Homeland</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe pariatur reprehenderit vero atque,
              consequatur id ratione, et non dignissimos culpa? Ut veritatis, quos illum totam quis blanditiis, minima
              minus odio!</p>
          </div>



        </div>
        <div class="col-lg-4 mb-5 mb-lg-0">
          <div class="row mb-5">
            <div class="col-md-12">
              <h3 class="footer-heading mb-4">Navigations</h3>
            </div>
            <div class="col-md-6 col-lg-6">
              <ul class="list-unstyled">
                <li><a href="#">Home</a></li>
                <li><a href="#">Buy</a></li>
                <li><a href="#">Rent</a></li>
                <li><a href="#">Properties</a></li>
              </ul>
            </div>
            <div class="col-md-6 col-lg-6">
              <ul class="list-unstyled">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Terms</a></li>
              </ul>
            </div>
          </div>


        </div>

        <div class="col-lg-4 mb-5 mb-lg-0">
          <h3 class="footer-heading mb-4">Follow Us</h3>

          <div>
            <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
            <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
            <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
            <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
          </div>



        </div>

      </div>
      <!-- <div class="row pt-5 mt-5 text-center">
        <div class="col-md-12">
          <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;
            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with
            <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com"
              target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div> -->

      </div>
    </div>
  </footer>

  </div>

  <?php require "includes/footer.php"; ?>

</body>

</html>