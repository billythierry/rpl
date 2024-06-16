<?php
    session_start();
    include '../components/connection.php';

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location: login.php');
    }

    //Update Product
    if (isset($_POST['update'])){
        $post_id = $_GET['id'];

        $name = $_POST['name'] ?? '';  // Check if 'name' is set in $_POST
        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $price = $_POST['price'] ?? '';  // Check if 'price' is set in $_POST
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);  // Use appropriate filter for numbers

        $content = $_POST['content'] ?? '';  // Check if 'content' is set in $_POST
        $content = filter_var($content, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $status = $_POST['status'] ?? '';
        $status = filter_var($status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?, status = ? WHERE id = ?");
        $update_product->execute([$name, $price, $content, $status, $post_id]);

        $success_msg[] = 'Product Updated';

        $old_image = $_POST['old_image'];
        $image = $_FILES['image']['name'] ?? '';
        $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_size = $_FILES['image']['size'] ?? 0;
        $image_tmp_name = $_FILES['image']['tmp_name'] ?? '';
        $image_folder = '../image/' . $image;

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);

        if(!empty($image)){
            if($image_size > 2000000){
                $warning_msg[] = 'Image size is too large.';
            }
            elseif($select_image->rowCount() > 0 AND $image != ''){
                $warning_msg[] = 'Please rename your image.';
            }
            else{
                $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $post_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if($old_image != $image AND $old_image != ''){
                    unlink('../image/'.$old_image);
                }
                $success_msg[] = 'Image updated.';
            }
        }
    }

    //Delete Product
    if(isset($_POST['delete'])){
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $delete_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
        $delete_image->execute(['$p_id']);

        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

        if($fetch_delete_image['image'] != ''){
            unlink('../image/'.$fetch_delete_image['image']);
        }

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$p_id]);

        header('location:view_product.php');
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
    <title>Green Coffee Admin Panel - Edit Products Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Edit Products</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Edit Products</span>
        </div>
        <section class="edit-post">
            <h1 class="heading">Edit Products</h1>
            <?php
                $post_id = $_GET['id'];

                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$post_id]);

                if ($select_product->rowCount() > 0){
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){

            ?>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                    <div class="input-field">
                        <label>Update Status</label>
                        <select name="status">
                            <option selected disabled value="<?= $fetch_product['status'] ?>"><?= $fetch_product['status'] ?></option>
                            <option value="active">Active</option>
                            <option value="deactive">Deactive</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>Product Name</label>
                        <input type="text" name="name" value="<?= $fetch_product['name'] ?>">
                    </div>
                    <div class="input-field">
                        <label>Product Price</label>
                        <input type="number" name="price" value="<?= $fetch_product['price'] ?>">
                    </div>
                    <div class="input-field">
                        <label>Product Description</label>
                          <textarea name="content"><?= $fetch_product['product_detail']; ?></textarea>
                    </div>
                    <div class="input-field">
                        <label>Product Image</label>    
                        <input type="file" name="image" accept="image/*">
                        <img src="../image/<?= $fetch_product['image']; ?>">
                    </div>
                    <div class="flex-btn">
                        <button type="submit" name="update" class="btn">Update Product</button>
                        <a href="view_product.php" class="btn">Go Back</a>
                        <button type="submit" name="delete" class="btn">Delete Product</button>
                    </div>
                </form>
            </div>
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