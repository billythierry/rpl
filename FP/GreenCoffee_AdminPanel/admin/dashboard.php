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
    <title>Green Coffee Admin Panel - Dashboard Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Dashboard</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Home</a><span> / Dashboard</span>
        </div>
        <section class="dashboard">
            <h1 class="heading">Dashboard</h1>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome!</h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="" class="btn">Profil</a>
                </div>
                <div class="box">
                    <?php
                        $select_product = $conn->prepare("SELECT * FROM `products`");
                        $select_product->execute();
                        $num_of_products = $select_product->rowCount();
                    ?>
                    <h3><?= $num_of_products; ?></h3>
                    <p>Produk ditambahkan</p>
                    <a href="add_product.php" class="btn">Tambahkan Produk Baru</a>
                </div>
                <div class="box">
                    <?php
                        $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_active_product->execute(['tersedia']);
                        $num_of_active_products = $select_active_product->rowCount();
                    ?>
                    <h3><?= $num_of_active_products; ?></h3>
                    <p>Total Produk Tersedia</p>
                    <a href="view_product.php" class="btn">Lihat Produk Tersedia</a>
                </div>
                <div class="box">
                    <?php
                        $select_deactive_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_deactive_product->execute(['kosong']);
                        $num_of_deactive_products = $select_deactive_product->rowCount();
                    ?>
                    <h3><?= $num_of_deactive_products; ?></h3>
                    <p>Total Produk Tidak Tersedia</p>
                    <a href="view_product.php" class="btn">Lihat Produk Tidak Tersedia</a>
                </div>
                <div class="box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $num_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $num_of_users; ?></h3>
                    <p>User Terdaftar</p>
                    <a href="user_account.php" class="btn">Lihat User</a>
                </div>
                <div class="box">
                    <?php
                        $select_admin = $conn->prepare("SELECT * FROM `admin`");
                        $select_admin->execute();
                        $num_of_admin = $select_admin->rowCount();
                    ?>
                    <h3><?= $num_of_admin; ?></h3>
                    <p>Admin Terdaftar</p>
                    <a href="admin_account.php" class="btn">Lihat Admin</a>
                </div>
                <div class="box">
                    <?php
                        $select_message = $conn->prepare("SELECT * FROM `message`");
                        $select_message->execute();
                        $num_of_message = $select_message->rowCount();
                    ?>
                    <h3><?= $num_of_message; ?></h3>
                    <p>Pesan yang Belum Dibaca</p>
                    <a href="admin_message.php" class="btn">Lihat Pesan</a>
                </div>
                <div class="box">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $num_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $num_of_orders; ?></h3>
                    <p>Total Pesanan</p>
                    <a href="orders.php" class="btn">Lihat Pesanan</a>
                </div>
                <div class="box">
                    <?php
                        $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                        $select_confirm_orders->execute(['in progress']);
                        $num_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $num_of_confirm_orders; ?></h3>
                    <p>Total Konfirmasi Pesanan</p>
                    <a href="orders.php" class="btn">Lihat Konfirmasi Pesanan</a>
                </div>
                <div class="box">
                    <?php
                        $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                        $select_canceled_orders->execute(['in progress']);
                        $num_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $num_of_canceled_orders; ?></h3>
                    <p>Total canceled orders</p>
                    <a href="orders.php" class="btn">View canceled orders</a>
                </div>
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