<?php
    session_start();
    include '../components/connection.php';

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location: login.php');
    }

    //Delete Product
    if(isset($_POST['delete'])){
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$p_id]);
        $success_msg[] = 'Product deleted successfully.';
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
    <title>Green Coffee Admin Panel - All Products Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Lihat Produk</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Lihat Produk</span>
        </div>
        <section class="show-post">
            <h1 class="heading">Semua Produk</h1>
            <div class="box-container">
                <?php
                    $select_product = $conn->prepare("SELECT * FROM `products`");
                    $select_product->execute();
                    
                    if($select_product->rowCount() > 0){
                        while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC))
                            {
                            
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <?php if ($fetch_product['image'] != '') { ?>
                        <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                    <?php } ?>
                    <div class="status" style="color: <?php if($fetch_product['status']=='tersedia'){echo "Green";}else{echo "Red";} ?>;"><?= $fetch_product['status']; ?></div>
                    <div class="price">Rp<?= number_format($fetch_product['price'],0,',','.'); ?>,-</div>
                    <div class="title"><?= $fetch_product['name']; ?></div>
                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">Edit</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                        <a href="read_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">View</a>
                    </div>
                </form>
                <?php
                        }
                    }
                    else{
                        echo'
                            <div class="empty">
                                <p>No Product Added Yet! <br> <a href="add_product.php" style="margin-top:1.5rem:" class="btn">Add Product</a></p>
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