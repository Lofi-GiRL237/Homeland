<?php
try {
    //host
    if (!defined("HOSTNAME")) define("HOSTNAME", "localhost");

    //user
    if (!defined("DB_USER")) define("DB_USER", "root");

    //database passsword
    if (!defined("Password")) define("Password", "");



    //database name
    if (!defined("DB_NAME")) define("DB_NAME", "homeland");

    $conn = new PDO("mysql:host=" . HOSTNAME . ";dbname=" . DB_NAME . ";", DB_USER, Password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
// if($conn==false) {
//     die("error could not connect".$conn->connect_error);
// }
// echo"connection successful";