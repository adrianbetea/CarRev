<?php

@include 'config.php';

session_start();

// save car name  and admin name variables
$car_name = $_GET['car_name'];
$user = $_SESSION['user_name'];
//echo $car_name . " si " . $user;

if (isset($_POST['submit'])) {
    $review = $_POST['review'];
    if ($review != '') {
        $insert = "INSERT INTO reviews(car_name, review_content, username) VALUE('$car_name','$review', '$user')";
        mysqli_query($conn, $insert);
        header('location:car_reviews_user.php?car_name=' . $car_name);
    } else {
        //echo "please write something!!!";
    }
} else {
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css file link -->
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/add_car.css">
    <link rel="stylesheet" href="./style/add_review.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>add review</title>
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
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Add review for</h3>
                <h3><?= $car_name ?></h3>
                <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    };
                }
                ?>
                <?php if (isset($_GET['error'])) : ?>

                    <span class="error-msg">
                        <?php echo $_GET['error'] ?>
                    </span>
                <?php endif ?>
                <textarea name="review" rows="5" cols="45"></textarea>
                <input type="submit" name="submit" value="submit" class="form-btn">

            </form>

        </div>

    </main>

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