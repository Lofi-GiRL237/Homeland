<?php require "../includes/header.php"; ?>
<?php
require "../config/config.php";


$error = "";
if(isset($_SESSION['username'])){
  header('location:../index.php');
}
if (isset($_POST["submit"])) {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);

  // Validate empty fields
  if (empty($email) || empty($password)) {
    $error = "Please fill in all the fields!";
  }
  $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
  $login->execute([':email' => $email]);

  if ($login->rowCount() > 0) {
    $user = $login->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if (password_verify($password, $user['password'])) {

      $_SESSION['username'] = $user['username'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['user_id'] = $user['id'];

     header("location:../index.php");
      
    } else {
      echo "<script>alert('Incorrect password!'); window.history.back();</script>";
    }
  } else {
    echo "<script>alert('Email not found!'); window.history.back();</script>";
  }
}


?>

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
                <li><a href="buy.html">Buy</a></li>
                <li><a href="rent.html">Rent</a></li>
                 <li class="has-children">
                  <a href="properties.html">Properties</a>
                  <ul class="dropdown arrow-top">
                    <li><a href="#">Condo</a></li>
                    <li><a href="#">Property Land</a></li>
                    <li><a href="#">Commercial Building</a></li>

                  </ul>
                </li> 
                 <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html">Register</a></li>
              </ul>
            </nav>
          </div> -->


        </div>
      </div>
    </div> 
  </div>

  <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(../images/hero_bg_2.jpg);"
    data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-10">
          <h1 class="mb-2">Log In</h1>
        </div>
      </div>
    </div>
  </div>


  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
          <h3 class="h4 text-black widget-title mb-3">Login</h3>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-contact-agent">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
              <input type="submit" name="submit" id="phone" class="btn btn-primary" value="Login">
            </div>
            <div class="form-group">
              Don't have an account? <a href="register.php">Click here</a>
            </div>
          </form>
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
      <div class="row pt-5 mt-5 text-center">
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
        </div>

      </div>
    </div>
  </footer>

  </div>
  <?php require "../includes/footer.php"; ?>


</body>

</html>