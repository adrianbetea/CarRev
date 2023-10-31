<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login_form.php');
}


if (isset($_GET['id'])) {

    // Gasim userul in tabela USERS dupa ID si retinem username intr-o variabila
    $user_id = $_GET['id'];
    $u_select = "SELECT username FROM users WHERE user_id='$user_id'";
    $u_result = mysqli_query($conn, $u_select);
    $u_row = mysqli_fetch_assoc($u_result);
    $username = $u_row['username'];

    // DELETE USER DUPA USERNAME
    $r_delete = "DELETE FROM reviews WHERE username='$username'";
    $r_result = mysqli_query($conn, $r_delete);

    // DELETE USER DUPA ID
    $u_delete = "DELETE FROM users WHERE user_id='$user_id'";
    $u_delete_result = mysqli_query($conn, $u_delete);
    header('location:view_users_admin.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view users admin</title>

    <!-- css file link -->
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/view_cars.css">
    <link rel="stylesheet" href="./style/car_reviews.css">
    <link rel="stylesheet" href="./style/view_users_admin.css">
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
        <section class="view-container" id="users">
            <p>
                USERS
            </p>
            <table>

                <thead>
                    <tr>
                        <th>username</th>
                        <th>email</th>
                        <th>Number of reviews</th>
                        <th>Reviews removed</th>
                        <th>remove user</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_select = "SELECT * FROM users ORDER BY user_id";
                    $user_result = mysqli_query($conn, $user_select);



                    if (mysqli_num_rows($user_result) > 0) {
                        while ($user_row = mysqli_fetch_assoc($user_result)) {
                            if ($user_row['user_type'] == 'user') { ?>

                                <tr>
                                    <td>
                                        <div class="username"><?= $user_row['username'] ?></div>
                                    </td>

                                    <td>
                                        <div class="email"><?= $user_row['email'] ?></div>
                                    </td>
                                    <?php
                                    // numarul de review-uri pe user!
                                    $username = $user_row['username'];
                                    $review_select = "SELECT count(*) FROM reviews WHERE username ='$username'";
                                    $review_result = mysqli_query($conn, $review_select);
                                    $review_row = mysqli_fetch_row($review_result);
                                    echo "<td><div>Numer of Reviews: " . $review_row[0] . "</div></td>";
                                    ?>
                                    <td>
                                        <div><?= $user_row['reviews_removed'] ?></div>
                                    </td>
                                    <td>
                                        <a href="view_users_admin.php?id=<?= $user_row['user_id'] ?>">Remove</a>
                                    </td>
                                </tr>


                    <?php }
                        }
                    } ?>

                </tbody>
            </table>

        </section>

        <section class="view-container" id="banned">
            <p>
                BANNED USERS
            </p>
            <table>

                <thead>
                    <tr>
                        <th>username</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $banned_select = "SELECT * FROM bannedusers ORDER BY banneduser_id";
                    $banned_result = mysqli_query($conn, $banned_select);



                    if (mysqli_num_rows($banned_result) > 0) {
                        while ($banned_row = mysqli_fetch_assoc($banned_result)) { ?>

                            <tr>
                                <td>
                                    <div class="username"><?= $banned_row['username'] ?></div>
                                </td>

                                <td>
                                    <div class="email"><?= $banned_row['email'] ?></div>
                                </td>

                            </tr>

                    <?php }
                    } ?>

                </tbody>
            </table>
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