<?php
// Include database connection
include('db_connect.php');

// Fetch coaches details from the database
$query = "SELECT * FROM coaches ORDER BY id ASC";
$result = mysqli_query($conn, $query);

// Initialize an array to store coach data
$coaches = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $coaches[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaches | ST Power Zone GYM</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link your existing CSS -->
    <style>
        .coaches-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .coaches-title {
            font-size: 32px;
            color: crimson;
            text-align: center;
            margin-bottom: 30px;
        }

        .coach-card {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .coach-image {
            flex: 0 0 150px;
            height: 150px;
            margin-right: 20px;
            border-radius: 50%;
            overflow: hidden;
        }

        .coach-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .coach-details {
            flex: 1;
        }

        .coach-name {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .coach-description {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); // Include the navigation bar ?>

    <div class="coaches-container">
        <h1 class="coaches-title">Meet Our Coaches</h1>
        
        <?php if (!empty($coaches)) { ?>
            <?php foreach ($coaches as $coach) { ?>
                <div class="coach-card">
                    <div class="coach-image">
                        <img src="<?php echo htmlspecialchars($coach['image_path']); ?>" alt="Coach Image">
                    </div>
                    <div class="coach-details">
                        <h2 class="coach-name"><?php echo htmlspecialchars($coach['name']); ?></h2>
                        <p class="coach-description"><?php echo htmlspecialchars($coach['description']); ?></p>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No coaches available at the moment. Please check back later.</p>
        <?php } ?>
    </div>

    <?php include('footer.php'); // Include the footer ?>
</body>
</html>
