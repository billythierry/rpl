<?php
    session_start();
    include '../components/connection.php';

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location: login.php');
    }

    //Delete Order
    if(isset($_POST['delete_order'])){
        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
        $verify_delete->execute([$order_id]);

        if($verify_delete->rowCount() > 0){
            $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
            $delete_order->execute([$order_id]);
            $success_msg[] = 'Pesanan berhasil dihapus.';
        }
        else{
            $warning_msg[] = 'Pesanan tidak ditemukan.';
        }
    }

    //Update Order
    if(isset($_POST['update_order'])){
        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $update_payment = filter_var($_POST['update_payment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
        $update_pay->execute([$update_payment, $order_id]);

        $success_msg[] = 'Pesanan berhasil diupdate.';
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
    <title>Green Coffee Admin Panel - Orders Placed Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Pesanan</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Pesanan</span>
        </div>
        <section class="order-container">
            <h1 class="heading">Total Pesanan</h1>
            <div class="box-container">
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();

                    if ($select_orders->rowCount() > 0){
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                            $order_id = $fetch_orders['id'];

                ?>
                <div class="box">
                    <div class="status" style="color: <?php if($fetch_orders['status'] == 'in progress'){echo "green";}else{echo "red";} ?>"><?= $fetch_orders['status']; ?></div>
                    <div class="detail">
                        <p>Username : <span><?= $fetch_orders['name'] ?></span></p>
                        <p>User Id: <span><?= $fetch_orders['id'] ?></span></p>
                        <p>Placed on : <span><?= $fetch_orders['date'] ?></span></p>
                        <p>User Number : <span><?= $fetch_orders['number'] ?></span></p>
                        <p>User Email : <span><?= $fetch_orders['email'] ?></span></p>
                        <p>Total Price : <span><?= $fetch_orders['price'] ?></span></p>
                        <p>Method : <span><?= $fetch_orders['method'] ?></span></p>
                        <p>Address : <span><?= $fetch_orders['address'] ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="update_payment">
                            <option disabled selected><?= $fetch_orders['payment_status']; ?></option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                        <div class="flex-btn">
                            <button type="submit" name="update_order" class="btn">Update Pembayaran</button>
                            <button type="submit" name="delete_order" class="btn" onclick="return confirm('Hapus pesanan ini?');">Hapus Pesanan</button>
                        </div>
                    </form>
                </div>
                <?php
                        }
                    
                    }
                    else{
                        echo'
                            <div class="empty">
                                <p>Belum ada pesanan.</p>
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