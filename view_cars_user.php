<?php

@include 'config.php';

session_start();

$user = $_SESSION['user_name'];

if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
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
        <section class="view-container">
            <?php
            $sql_cars = "SELECT * FROM cars ORDER BY car_id";
            $cars_table = mysqli_query($conn, $sql_cars);


            if (mysqli_num_rows($cars_table) > 0) {
                while ($cars_row = mysqli_fetch_assoc($cars_table)) { ?>
                    <div class="car-container">
                        <div class="car-img">
                            <img src="uploads/<?= $cars_row['car_img'] ?>" alt="">
                        </div>
                        <div class="car-name"><?= $cars_row['car_name'] ?></div>
                        <div class="car-description"><?= $cars_row['car_description'] ?></div>
                        <div class="reviews"><a class="review" href="car_reviews_user.php?car_name=<?= $cars_row['car_name'] ?>">View Reviews</a></div>
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