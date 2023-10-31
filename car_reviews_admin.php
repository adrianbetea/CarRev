<?php

@include 'config.php';

session_start();

// save car name  and admin name variables
$car_name = $_GET['car_name'];
$admin = $_SESSION['admin_name'];

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // first increment reviews_removed in users table where username = $username
    $user_select = "SELECT email,reviews_removed FROM users WHERE username='$username'";
    $user_result = mysqli_query($conn, $user_select);
    if (mysqli_num_rows($user_result) > 0) {
        $user_row = mysqli_fetch_assoc($user_result);
        $email = $user_row['email'];
        $removed_reviews = $user_row['reviews_removed'] + 1;
        // check if user had 3 reviews removed => if true then ban user and delete all it's reviews
        if ($removed_reviews == 3) {
            // insert email and username into banned users
            $insert_banned = mysqli_query($conn, "INSERT INTO `bannedusers`(`email`, `username`) VALUES ('$email', '$username')");
            // remove user from users
            // remove all reviews from that user
            $remove_reviews_from_user = mysqli_query($conn, "DELETE FROM reviews WHERE username='$username'");
            $remove_user = mysqli_query($conn, "DELETE FROM users WHERE username='$username'");
        } else {
            // increment removed reviews
            $user_update = mysqli_query($conn, "UPDATE users SET reviews_removed='$removed_reviews' WHERE username='$username'");
            // delete review 
            $review_delete = mysqli_query($conn, "DELETE FROM reviews WHERE username='$username' && car_name='$car_name'");
        }
    }
    //header('location:car_reviews_admin.php');
}

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
                <li><a href="view_users_admin.php">View Users</a></li>
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
                            <div class="update-delete">
                                <a class="du" href="car_reviews_admin.php?car_name=<?= $car_name ?>&username=<?= $row['username'] ?>">Delete Review</a>
                            </div>
                    </form>
                    </div>
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