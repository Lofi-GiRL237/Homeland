<?php require "../includes/header.php"; ?>
<?php
require "../config/config.php";
$error = "";

if(isset($_SESSION['username'])){
  header('location:../index.php');
}
if (isset($_POST["submit"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate empty fields
    if (empty($username) || empty($password) || empty($email) || empty($confirm_password)) {
        $error = "Please fill in all the fields!";
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format. Please enter a correct email!";
    } elseif (strlen($password) < 6 || strlen($password) > 0) {
        $error = "Please enter a password of 6 characters atleast";
    }
    // Validate password mismatch
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    }

    // If there are no errors, insert data into database
    if (empty($error)) {
        $sql = "INSERT INTO users(username, email, password) VALUES (:username, :email, :password)";
        $insert = $conn->prepare($sql);
        $insert->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':email' => $email
        ]);

        // Redirect to login page after registration
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>

    <div class="site-loader"></div>
    <div class="site-wrap">

        <!-- <div class="site-navbar mt-4">
            <div class="container py-1">
                <div class="row align-items-center">
                    <div class="col-8 col-md-8 col-lg-4">
                        <h1 class="mb-0"><a href="<?php //echo APPURL; ?>index.php" class="text-white h2 mb-0">
                                <strong>Homeland<span class="text-danger">.</span></strong></a></h1>
                    </div>
                    <div class="col-4 col-md-4 col-lg-8">
                        <nav class="site-navigation text-right text-md-right" role="navigation">
                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                <li class="active"><a href="<?php //echo APPURL; ?>index.php">Home</a></li>
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
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    <div class="site-blocks-cover inner-page-cover overlay"
        style="background-image: url(<?php echo APPURL; ?>images/hero_bg_2.jpg);" data-aos="fade"
        data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10">
                    <h1 class="mb-2">Register</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="h4 text-black widget-title mb-3">Register</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"
                        onsubmit="return validateForm()" class="form-contact-agent">

                        <?php if (!empty($error)) { ?>
                            <div style="color: red; font-weight: bold;">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="email">Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Register">
                        </div>
                    </form>
                </div>
            </div>
            <p>Already have an account? <a href="login.php">login here</a></p>
        </div>
    </div>


    <?php require "../includes/footer.php"; ?>

</body>

</html>