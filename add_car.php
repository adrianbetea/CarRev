<?php

// include mysql connection
@include 'config.php';

session_start();

// if submit button is pressed and a car file si selected 
if (isset($_POST['submit']) && isset($_FILES['car_img'])) {
    // print image details
    echo "<pre>";
    print_r($_FILES['car_img']);
    echo "</pre>";

    // car_name and car_description to variables
    $car_name = mysqli_real_escape_string($conn, $_POST['car_name']);
    $car_description = mysqli_real_escape_string($conn, $_POST['car_description']);

    // image variables
    $car_img = $_FILES['car_img']['name'];
    $car_img_size = $_FILES['car_img']['size'];
    $tmp_name = $_FILES['car_img']['tmp_name'];
    $err = $_FILES['car_img']['error'];

    if ($err === 0) {
        // file must be smaller than 1.28MB
        if ($car_img_size > 1280000) {
            $em = "file is too large";
            header("Location:add_car.php?error=$em");
        } else {
            //check file extension
            $img_ex = pathinfo($car_img, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            // only images allowed
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_car_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = 'uploads/' . $new_car_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                // Insert into database
                $insert = "INSERT INTO cars(car_name, car_description, car_img) VALUE('$car_name', '$car_description', '$new_car_img_name')";
                mysqli_query($conn, $insert);
                header('location:view_cars_admin.php');
            } else {
                $em = "incorrect file type";
                header("Location:add_car.php?error=$em");
            }
        }
    } else {
        $em = "unknow error";
        header("Location:add_car.php?error=$em");
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
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <title>add car</title>
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
                <li><a href="view_users_admin.php">View Users</a>
                <li><a href="logout.php" class="btn">logout</a></li>
                <li>
                    <span class="user"><?php echo $_SESSION['admin_name'] ?></span>
                </li>

            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Add new car</h3>
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

                <input type="text" name="car_name" placeholder="car name">
                <input type="text" name="car_description" placeholder="car description">
                <input type="file" name="car_img">
                <input type="submit" name="submit" value="Add car">

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