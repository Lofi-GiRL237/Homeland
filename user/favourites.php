<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/header.php';
include '../config/config.php'; // Make sure this connects $conn (PDO) to your DB

// Get current user ID from session
$user_id = $_SESSION['user_id'] ?? null;

// Prepare and execute the JOIN query
// $favourites = [];
// if ($user_id) {
//     $stmt = $conn->prepare("
//         SELECT 
//             props.id AS id,
//             props.name AS name,
//             props.location AS location,
//             props.image AS image,
//             props.price AS price,
//             props.beds AS beds,
//             props.bath AS bath,
//             props.sq_ft AS sq_ft,
//             props.type AS type
//         FROM props
//         INNER JOIN favorites ON props.id = favorites.property_id
//         WHERE favorites.user_id = ?
//     ");
//     $stmt->execute([$user_id]);
//     $favourites = $stmt->fetchAll(PDO::FETCH_ASSOC);
// }
// ?>

// <div class="container mt-5">
//     <h2>Your Favourites</h2>
//     <?php if (count($favourites) > 0): ?>
//         <div class="row">
//             <?php foreach ($favourites as $property): ?>
//                 <div class="col-md-4 mb-4">
//                     <div class="card">
//                         <img src="../images/<?php echo htmlspecialchars($property['image']); ?>" class="card-img-top" alt="Property Image">
//                         <div class="card-body">
//                             <h5 class="card-title"><?php echo htmlspecialchars($property['name']); ?></h5>
//                             <p class="card-text">
//                                 Location: <?php echo htmlspecialchars($property['location']); ?><br>
//                                 Type: <?php echo htmlspecialchars($property['type']); ?><br>
//                                 Beds: <?php echo htmlspecialchars($property['beds']); ?> |
//                                 Baths: <?php echo htmlspecialchars($property['bath']); ?> |
//                                 Sq Ft: <?php echo htmlspecialchars($property['sq_ft']); ?><br>
//                                 <strong>Price: $<?php echo number_format((float)preg_replace('/[^\d.]/', '', $property['price'])); ?></strong>
//                             </p>
//                         </div>
//                     </div>
//                 </div>
//             <?php endforeach; ?>
//         </div>
//     <?php else: ?>
//         <div class="alert alert-success mt-3">
//             You did not add any properties to favorites just yet.
//         </div>
//     <?php endif; ?>
// </div>

<?php include '../includes/footer.php'; ?>