<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}


if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    $sql = "SELECT * FROM cars WHERE car_id='$car_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (file_exists("./uploads/" . $row['car_img'])) {
                unlink("./uploads/" . $row['car_img']);
            }
        }
    }

    $car_select = "SELECT car_name FROM cars WHERE car_id='$car_id'";
    $car_result = mysqli_query($conn, $car_select);
    $car_row = mysqli_fetch_assoc($car_result);
    $car_name = $car_row['car_name'];


    // delete all reviews from deleted car
    $delete_reviews = mysqli_query($conn, "DELETE FROM `reviews` WHERE `car_name`='$car_name'");
    // delete the car itself
    $delete_result = mysqli_query($conn, "DELETE FROM `cars` WHERE `car_id` ='$car_id'");
    header('location:view_cars_admin.php');
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
        <section class="view-container">
            <?php
            $sql = "SELECT * FROM cars ORDER BY car_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="car-container">

                        <div class="car-img">
                            <img src="uploads/<?= $row['car_img'] ?>" alt="">
                        </div>
                        <div class="car-name" id="car_n"><?= $row['car_name'] ?></div>
                        <div class="car-description"><?= $row['car_description'] ?></div>
                        <div class="reviews">
                            <a class="review" href="car_reviews_admin.php?car_name=<?= $row['car_name'] ?>">View Reviews</a>
                            <a class="review" href="view_cars_admin.php?id=<?= $row['car_id'] ?>">Delete Car</a>
                        </div>

                    </div>
            <?php }
            } ?>

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