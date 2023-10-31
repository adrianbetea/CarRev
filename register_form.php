<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    $select = " SELECT * FROM users WHERE email = '$email' && password = '$password' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = 'user already exist!';
    } else {

        $banned_result = mysqli_query($conn, "SELECT * FROM bannedusers ORDER BY banneduser_id");
        $banned_emails = array();
        // create array with banned emails and add emails from database(banneduser email)
        if (mysqli_num_rows($banned_result) > 0) {

            while (($banned_row = mysqli_fetch_assoc($banned_result))) {
                array_push($banned_emails, $banned_row['email']);
            }
        }


        if (in_array($email, $banned_emails)) {
            $error[] = 'user banned!';
        } else {
            if ($password != $cpassword) {
                $error[] = 'password not matched!';
            } else {
                $insert = "INSERT INTO users(username, email, password, user_type, reviews_removed) VALUE('$username', '$email', '$password', '$user_type', '0')";
                mysqli_query($conn, $insert);
                header('location:login_form.php');
            }
        }
    }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <!-- css file link -->
    <link rel="stylesheet" href="./style/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

    <div class="form-container">
        <form action="" method="post">
            <h3>register now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '<span>';
                };
            }

            ?>
            <input type="text" name="username" placeholder="enter your username" required>
            <input type="email" name="email" placeholder="enter your email" required>
            <input type="password" name="password" placeholder="enter your password" required>
            <input type="password" name="cpassword" placeholder="confirm your password" required>
            <select name="user_type">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>already have an account? <a href="login_form.php">login now</a></p>
        </form>
    </div>

</body>

</html>