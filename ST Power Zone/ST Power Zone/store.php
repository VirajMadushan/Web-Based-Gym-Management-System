<?php
// Include the database connection
include('db_connect.php');

// Fetch store items from the database
$query = "SELECT * FROM store_items";
$result = mysqli_query($conn, $query);

// Check if items exist
$items = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store | ST Power Zone</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link your existing CSS -->
</head>
<body>
    <?php include('navbar.php'); // Include the navigation bar ?>

    <div class="container">
        <h1 class="page-title">Store</h1>
        <div class="store-items">
            <?php if (!empty($items)) { ?>
                <?php foreach ($items as $item) { ?>
                    <div class="store-item">
                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-image">
                        <h2 class="item-name"><?php echo htmlspecialchars($item['name']); ?></h2>
                        <p class="item-price">Price: $<?php echo htmlspecialchars($item['price']); ?></p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No items available in the store right now.</p>
            <?php } ?>
        </div>
    </div>

    <?php include('footer.php'); // Include the footer ?>
</body>
</html>
