<header class="header">
<link rel="stylesheet" href="admin_style.css">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="../img/SWEETIE CUPCAKE.png"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_product.php">Tambah Produk</a>
            <a href="view_product.php">Lihat Produk</a>
            <!-- <a href="user_account.php">Akun</a> -->
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn"></i>
        </div>
        <div class="profile-detail">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
                $select_profile->execute([$admin_id]);
                
                if($select_profile->rowCount() > 0){
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                
            ?>
            <div class="profile">
                <img src="../image/<?= $fetch_profile['profile']; ?>" class="logo-img">
                <p><?= $fetch_profile['name']; ?></p>
            </div>
            <div class="flex-btn">
            <a href="profile.php" class="btn">Profile</a>
            <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?')" class="btn">logout</a>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</header>