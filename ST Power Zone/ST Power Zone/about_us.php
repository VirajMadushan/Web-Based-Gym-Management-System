<?php
// Include database connection
include('db_connect.php');

// Fetch gallery images from the database
$query = "SELECT * FROM gallery_images ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Initialize an array for storing images
$images = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | ST Power Zone GYM</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link your existing CSS -->
    <style>
        .about-container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            text-align: center;
        }

        .about-title {
            font-size: 32px;
            color: crimson;
            margin-bottom: 20px;
        }

        .about-content {
            font-size: 18px;
            color: white;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-caption {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); // Include the navigation bar ?>

    <div class="about-container">
        <h1 class="about-title">About Us</h1>
        <p class="about-content">
            Welcome to <strong>ST Power Zone GYM</strong>, your ultimate destination for achieving fitness and wellness goals. 
            Established with a vision to create a positive and inspiring environment, we are dedicated to providing state-of-the-art equipment, 
            experienced trainers, and personalized programs for every individual.
        </p>
        <p class="about-content">
            Whether you are looking to lose weight, build muscle, or maintain a healthy lifestyle, 
            ST Power Zone GYM is here to support you every step of the way. Our community of fitness enthusiasts is ready to 
            motivate and inspire you on your journey.
        </p>
        <p class="about-content">
            Join us today and take the first step toward a stronger, healthier, and more confident version of yourself!
        </p>

        <h2 class="about-title">Our Gallery</h2>
        <div class="gallery-container">
            <?php foreach ($images as $image) { ?>
                <div class="gallery-item">
                    <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Gallery Image">
                    <div class="gallery-caption"><?php echo htmlspecialchars($image['caption']); ?></div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include('footer.php'); // Include the footer ?>
</body>
</html>
