<?php
    session_start();
    include '../components/connection.php';

    if (isset($_POST['login'])) {
        // Sanitize and filter input data
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Use FILTER_SANITIZE_EMAIL for email
        $pass = filter_var(sha1($_POST['password']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            // Prepare and execute select statement
            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password = ?");
            $select_admin->execute([$email, $pass]);

            if ($select_admin->rowCount() > 0) {
                $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
                $_SESSION['admin_id'] = $fetch_admin_id['id'];
                header('location:dashboard.php');
            } 
            else {
                $warning_msg[] = 'Incorrect username or password.';
            }
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon cdn link -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin Panel - Login Page</title>
</head>

<body>

    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h3>Login</h3>
                    
                    <div class="input-field">
                        <label>user email<sup>*</sup></label>
                        <input type="email" name="email" maxlength="20" required placeholder="Enter your email" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input-field">
                        <label>user password<sup>*</sup></label>
                        <input type="password" name="password" maxlength="20" required placeholder="Enter your password" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <button type="submit" name="login" class="btn">Login</button>
                    <p>Don't have an account? <a href="register.php">Register Now</a></p>
                </form>
            </div>
        </section>
    </div>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>

    <!-- alert -->
    <?php include '../components/alert.php'; ?>
</body>
</html>