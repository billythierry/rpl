<?php
    include 'components/connection.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '';
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: login.php');
    }

    // Menambahkan produk ke wishlist
    if (isset($_POST['add_to_wishlist'])) {
        $id = unique_id();
        $product_id = $_POST['product_id'];

        $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->execute([$user_id, $product_id]);

        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id= ? AND product_id =?");
        $cart_num->execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your wishlist';
        } else if ($cart_num->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your cart';
        } else {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$product_id]);
            $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

            if ($fetch_product) {
                $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES(?,?,?,?)");
                $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_product['price']]);
                $success_msg[] = 'Product added to wishlist successfully';
            } else {
                $warning_msg[] = 'Product not found';
            }
        }
    }

    // Menambahkan produk ke keranjang
    if (isset($_POST['add_to_cart'])) {
        $id = unique_id();
        $product_id = $_POST['product_id'];

        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $verify_cart->execute([$user_id, $product_id]);

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);

        if ($verify_cart->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your cart';
        } else if ($max_cart_items->rowCount() > 20) {
            $warning_msg[] = 'Cart is full';
        } else {
            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_product->execute([$product_id]);
            $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

            if ($fetch_product) {
                $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES(?,?,?,?,?)");
                $insert_cart->execute([$id, $user_id, $product_id, $fetch_product['price'], $qty]);
                $success_msg[] = 'Product added to cart successfully';
            } else {
                $warning_msg[] = 'Product not found';
            }
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
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Green Coffee - Shop Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Shop</h1>
        </div>  
        <div class="title2">
            <a href="contact.php">Home</a><span>/ Our Shop</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                            // Path gambar produk
                            $imgPath = 'image/' . $fetch_products['image'];
                            // Pastikan gambar ada di folder
                            if (file_exists($imgPath)) {
                                $imgSrc = $imgPath;
                            } else {
                                // Jika tidak, gunakan placeholder
                                $imgSrc = 'placeholder.jpg';
                            }
                ?>
                <form action="" method="post" class="box">
                    <!-- Tampilkan gambar produk -->
                    <img src="<?php echo $imgSrc; ?>" class="img">
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bxs-show"></a>
                    </div>
                    <h3 class="name"><?php echo $fetch_products['name']; ?></h3>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                    <div class="flex">
                        <p class="price">Harga: Rp.<?php echo $fetch_products['price']; ?>/-</p>
                        <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?php echo $fetch_products['id']; ?>" class="btn">Buy Now</a>
                </form>
                <?php
                        }
                    } else {
                        echo '<p class="empty">No products added yet!</p>';
                    }
                ?>    
            </div>
        </section>
        
        <?php include 'components/footer.php'; ?> 
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>