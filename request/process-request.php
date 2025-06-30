<?php
//session_start();
require('../includes/header.php'); // adjust path as needed

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location:'.APPURL.'/auth/login.php');
  exit;
}

// Validate POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $property_id = isset($_POST['prop_id']) ? intval($_POST['prop_id']) : 0;
  $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
  $admin_name = isset($_POST['admin_name']) ? trim($_POST['admin_name']) : '';

  if (empty($name) || empty($email) || empty($phone) || $property_id <= 0 || $user_id <= 0 || empty($admin_name)) {
    echo "<script>alert('Please fill in all the fields!'); window.history.back();</script>";
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO request (name, email, phone, prop_id, user_id, admin_name) VALUES (:name, :email, :phone, :prop_id, :user_id, :admin_name)");
  $stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':phone' => $phone,
    ':prop_id' => $property_id,
    ':user_id' => $user_id,
    ':admin_name' => $admin_name
  ]);
}

echo "<script>alert('Request sent successfully!');</script>";
echo "<script>window.history.back();</script>";
exit;


//   if ($stmt->fetch()) {
//     // Already favorited
//     header('Location: property-details.php?id=' . $propertyId . '&fav=exists');
//     exit;
//   }
  
//   // Insert into favorites
//   $stmt = $conn->prepare("INSERT INTO favorites (user_id, property_id, created_at) VALUES (:user_id, :property_id, NOW())");
//   $stmt->execute([
//     ':user_id' => $userId,
//     ':property_id' => $propertyId
//   ]);

//   
// } else {
//   // Invalid request
//   header('Location: index.php');
//   exit;
// }