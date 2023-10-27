<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>

    <!-- css file link -->
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/about.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

    <header>
        <nav class="top-nav">
            <ul>
                <li>
                    <i class='bx bxs-car logo'></i>
                    <a href="user_page.php"><span class="logo">CarRev</span></a>
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
        <div class="about-container">
            <div class="welcome abt">
                <p>
                    Welcome to <span>CarRev</span>, your ultimate destination for all things automotive.
                    We are passionate car enthusiasts dedicated to bringing you the latest and greatest in the world of automobiles.
                </p>
            </div>

            <br>
            <div class="our-mission abt">
                <p>
                    Our mission is simple: to provide you with expert, unbiased, and in-depth car reviews that help you make informed decisions.
                    Whether you're in the market for a new ride or just love to stay updated on the automotive industry, we've got you covered.
                </p>
            </div>

            <br>
            <div class="journey-start abt">
                <p>
                    At <span>CarRev</span>, we believe that a well-informed car buyer is a happy car owner.
                    Join us on this exciting ride as we explore the world of automobiles, one review at a time.
                    Your journey to finding the perfect car starts here.
                </p>
            </div>


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