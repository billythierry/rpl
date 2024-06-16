<?php
    session_start();
    include '../components/connection.php';

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location: login.php');
    }

    //Add product in database
    if(isset($_POST['publish'])){
        $id = unique_id();

        $name = $_POST['name'] ?? '';  // Check if 'name' is set in $_POST
        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $price = $_POST['price'] ?? '';  // Check if 'price' is set in $_POST
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);  // Use appropriate filter for numbers

        $content = $_POST['content'] ?? '';  // Check if 'content' is set in $_POST
        $content = filter_var($content, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $status = 'active';

        $image = $_FILES['image']['name'] ?? '';
        $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_size = $_FILES['image']['size'] ?? 0;
        $image_tmp_name = $_FILES['image']['tmp_name'] ?? '';
        $image_folder = '../image/' . $image;

        // Tentukan folder tujuan untuk menyimpan file yang diunggah
        $image_folder = '../image/' . $image;

        // Pindahkan file yang diunggah ke folder tujuan
        move_uploaded_file($image_tmp_name, $image_folder);

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);

        if(isset($image)){
            if($select_image->rowCount() > 0){
                $warning_msg[] = 'Image name repeated';
            }
            elseif ($image_size > 2000000) {
                $warning_msg[] = 'Image size is too large.';
            }
            else {
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }
        else {
            $image = '';
        }

        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'Please rename your image.';
        }
        else{
            $insert_product = $conn->prepare("INSERT INTO `products`(id, name, price, image, product_detail, status) VALUES(?, ?, ?, ?, ?, ?)");
            $insert_product->execute([$id, (string)$name, (float)$price, $image, (string)$content, $status]);
            $success_msg[] = 'Product inserted successfully.';
        }
    }

    //Save product as draft in database
    if(isset($_POST['draft'])){
        $id = unique_id();

        $name = $_POST['name'] ?? '';  // Check if 'name' is set in $_POST
        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $price = $_POST['price'] ?? '';  // Check if 'price' is set in $_POST
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);  // Use appropriate filter for numbers

        $content = $_POST['content'] ?? '';  // Check if 'content' is set in $_POST
        $content = filter_var($content, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $status = 'deactive';

        $image = $_FILES['image']['name'] ?? '';
        $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_size = $_FILES['image']['size'] ?? 0;
        $image_tmp_name = $_FILES['image']['tmp_name'] ?? '';
        $image_folder = '../image/' . $image;

        // Tentukan folder tujuan untuk menyimpan file yang diunggah
        $image_folder = '../image/' . $image;

        // Pindahkan file yang diunggah ke folder tujuan
        move_uploaded_file($image_tmp_name, $image_folder);

        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);

        if(isset($image)){
            if($select_image->rowCount() > 0){
                $warning_msg[] = 'Image name repeated';
            }
            elseif ($image_size > 2000000) {
                $warning_msg[] = 'Image size is too large.';
            }
            else {
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        }
        else {
            $image = '';
        }

        if($select_image->rowCount() > 0 AND $image != ''){
            $warning_msg[] = 'Please rename your image.';
        }
        else{
            $insert_product = $conn->prepare("INSERT INTO `products`(id, name, price, image, product_detail, status) VALUES(?, ?, ?, ?, ?, ?)");
            $insert_product->execute([$id, (string)$name, (float)$price, $image, (string)$content, $status]);
            $success_msg[] = 'Product saved as draft successfully.';
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
    <title>Green Coffee Admin Panel - Add Products Page</title>
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>Tambah Produk</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">Dashboard</a><span> / Tambah Produk</span>
        </div>
        <section class="form-container">
            <h1 class="heading">Tambah Produk</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <label>Nama Produk <sup>*</sup></label>
                    <input type="text" name="name" maxlength="100" required placeholder="Nama produk" style="opacity: 0.6;">
                </div>
                <div class="input-field">
                    <label>Harga Produk <sup>*</sup></label>
                    <div style="display: flex; align-items: center;">
                    <span>Rp</span>
                    <input type="number" name="price" maxlength="100" required placeholder="Harga produk" style="margin-left: 5px; opacity: 0.6;">
                    </div>
                </div>
                <div class="input-field">
                    <label>Detail Produk <sup>*</sup></label>
                    <textarea name="content" required maxlength="10000" required placeholder="Deskripsi produk" style="opacity: 0.7;"></textarea>
                </div>
                <div class="input-field">
                    <label>Gambar Produk <sup>*</sup></label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="flex-btn">
                    <button type="submit" name="publish" class="btn">Publish Produk</button>
                    <button type="submit" name="draft" class="btn">Save as draft</button>
                </div>
            </form>
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