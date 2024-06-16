<?php
    include 'components/connection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else{
        $user_id = '';
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: login.php');
        exit();
    }

    //register user
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header('location: home.php');
            exit();
        }else{
            $message [] = 'incorrect username or passward';
        }   
    }
?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>green tea - login now</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png" alt="Logo">
                <h1>login Now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto dolorum deserunt minus veniam tenetur.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50"
                    oninput ="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Your Password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Enter your password" maxlength="50"
                    oninput ="this.value = this.value.replace(/\s/g, '')">
                </div>

                <input type="submit" name="submit" value="Login Now" class="btn">
                <p>do have an account? <a href="register.php">register now</a></p>
            </form>
        </section>
    </div>
    <script src="components/sweetalery.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>