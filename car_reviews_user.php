<?php

@include 'config.php';

session_start();

// save car name  and admin name variables
$car_name = $_GET['car_name'];
$user = $_SESSION['user_name'];
//echo $car_name . " si " . $user;


if (isset($_POST['delete'])) {

    // users can delete only their own reviews
    $delete = "DELETE FROM reviews WHERE car_name='$car_name' && username='$user'";

    $result = mysqli_query($conn, $delete);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view cars user</title>

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
                    <a href="user_page.php"><span class="logo">CarRev</a></span></a>
                </li>
                <li><a href="view_cars_user.php">View Cars</a></li>
                <li><a href="logout.php" class="btn">logout</a></li>
                <li>
                    <span class="user"><?php echo $_SESSION['user_name'] ?></span>
                </li>

            </ul>
        </nav>
    </header>

    <main>
        <section class="about-car">
            <?php
            $sql_cars = "SELECT * FROM cars WHERE car_name='$car_name'";
            $cars_table = mysqli_query($conn, $sql_cars);
            $sql_reviews = "SELECT username FROM reviews WHERE username='$user' && car_name='$car_name'";
            $reviews_table = mysqli_query($conn, $sql_reviews);
            if (mysqli_num_rows($cars_table) > 0) {
                while ($cars_row = mysqli_fetch_assoc($cars_table)) { ?>
                    <div class="car-img">
                        <img src="uploads/<?= $cars_row['car_img'] ?>" alt="">
                    </div>
                    <div>
                        <div class="car-name"><?= $cars_row['car_name'] ?></div>
                        <div class="car-description"><?= $cars_row['car_description'] ?></div>
                    </div>
                    <?php
                    if (mysqli_num_rows($reviews_table) == 1) {
                        $review_row = mysqli_fetch_assoc($reviews_table);
                    ?>
                        <div class="review-added">Already added a review</div>
                    <?php } else {
                    ?>
                        <div class="review-added"><a href="add_review.php?car_name=<?= $cars_row['car_name'] ?>">Add a review!</a></div>
                    <?php } ?>
            <?php    }
            } ?>
        </section>
        <section class="review-container">
            <?php
            $sql = "SELECT * FROM reviews WHERE car_name='$car_name' ORDER BY review_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="review-content">
                        <div class="review-user">From: <?= $row['username'] ?></div>
                        <div class="review-description"><?= $row['review_content'] ?></div>
                        <?php
                        if ($row['username'] == $user) {
                        ?>
                            <div class="update-delete">
                                <a href="update_review.php?car_name=<?= $row['car_name'] ?>&review_content=<?= $row['review_content'] ?>" class="du">Update Review</a>
                                <form action="" method="POST">
                                    <input type="submit" name="delete" value="Delete Review" class="du">
                                </form>
                            </div>
                        <?php } ?>

                    </div>
            <?php }
            }
            ?>

        </section>
    </main>

    <br><br>

    <footer>
        <span>
            <i class='bx bxs-car logo'></i>
            <span class=" logo">CarRev</span>
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