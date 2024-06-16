<?php
    session_start();
    include '../components/connection.php';

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location: login.php');
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
    <title>Green Coffee Admin Panel - Register User's Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Admin</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Admin</span>
        </div>
        <section class="accounts">
            <h1 class="heading">Admin yang Terdaftar</h1>
            <div class="box-container">
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `admin`");
                    $select_users->execute();

                    if ($select_users->rowCount() > 0) {
                        while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                            $user_id = $fetch_users['id'];
                        
                ?>
                <div class="box">
                    <p>User Id : <span><?= $user_id ?></span></p>
                    <p>Username : <span><?= $fetch_users['name']; ?></span></p>
                    <p>User Email : <span><?= $fetch_users['email']; ?></span></p>
                </div>
                <?php
                        }
                    
                    }
                    else{
                        echo'
                            <div class="empty">
                                <p>No users registered yet.</p>
                            </div>
                        ';
                    }
                ?>
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