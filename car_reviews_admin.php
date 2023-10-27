<?php

@include 'config.php';

session_start();

// save car name  and admin name variables
$car_name = $_GET['car_name'];
$admin = $_SESSION['admin_name'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view cars admin</title>

    <!-- css file link -->
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/view_cars.css">
    <link rel="stylesheet" href="./style/car_reviews.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

    <header>
        <nav class="top-nav">
            <ul>
                <li>
                    <i class='bx bxs-car logo'></i>
                    <a href="admin_page.php"><span class="logo">CarRev</a></span></a>
                </li>
                <li><a href="view_cars_admin.php">View Cars</a></li>
                <li><a href="add_car.php">Add Car</a></li>
                <li><a href="logout.php" class="btn">logout</a></li>
                <li>
                    <span class="user"><?php echo $_SESSION['admin_name'] ?></span>
                </li>

            </ul>
        </nav>
    </header>

    <main>
        <section class="about-car">
            <?php
            $sql = "SELECT * FROM cars WHERE car_name='$car_name'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="car-img">
                        <img src="uploads/<?= $row['car_img'] ?>" alt="">
                    </div>
                    <div>
                        <div class="car-name"><?= $row['car_name'] ?></div>
                        <div class="car-description"><?= $row['car_description'] ?></div>

                    </div>
            <?php

                }
            } ?>
        </section>
        <section class="review-container">


            <?php
            $sql = "SELECT * FROM reviews WHERE car_name='$car_name' ORDER BY review_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <form action="" method="POST">
                        <div class="review-content">
                            <div class="review-user">FROM:&nbsp;<span class="review-user"><?= $row['username'] ?></span></div>
                            <div class="review-description"><?= $row['review_content'] ?></div>
                        </div>
                    </form>
            <?php
                }
            }
            ?>

        </section>
    </main>

    <br><br>

    <footer>
        <span>
            <i class='bx bxs-car logo'></i>
            <span class="logo">CarRev</span>
        </span>
        <span>
            <p>email: </p>
            <a href="mailto:carrev@support.com">carrev@support.com</a>
            <i class='bx bxs-contact contact'></i>
        </span>

        <span>
            <p>phone: </p>
            <a href="tel:+4025 2552">+4025 2552</a>
        </span>

    </footer>

</body>

</html>