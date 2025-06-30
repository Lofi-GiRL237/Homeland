<?php

require('includes/header.php'); // adjust path as needed

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

// Validate POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['property_id'])) {
  $userId = $_SESSION['user_id'];
  $propertyId = intval($_POST['property_id']);
  
  // Optional: Check if already favorited
  $stmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = :user_id AND property_id = :property_id");
  $stmt->execute([':user_id' => $userId, ':property_id' => $propertyId]);
  if ($stmt->fetch()) {
    // Already favorited
    header('Location: property-details.php?id=' . $propertyId . '&fav=exists');
    exit;
  }
  
  // Insert into favorites
  $stmt = $conn->prepare("INSERT INTO favorites (user_id, property_id, created_at) VALUES (:user_id, :property_id, NOW())");
  $stmt->execute([
    ':user_id' => $userId,
    ':property_id' => $propertyId
  ]);

  header('Location: property-details.php?id=' . $propertyId . '&fav=added');
  exit;
} else {
  // Invalid request
  header('Location: index.php');
  exit;
}