<?php
    include '../components/connection.php';

    if(isset($_POST['register'])){
        $id = unique_id();

        // Sanitize and filter input data
        $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $pass = filter_var(sha1($_POST['password']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpass = filter_var(sha1($_POST['cpassword']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Handle file upload
        $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/' . $image;

        try {
            // Prepare and execute select statement
            $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
            $select_admin->execute([$email]);

            if($select_admin->rowCount() > 0){
                $warning_msg[] = 'User email already exists';
            } 
            else{
                if($pass != $cpass){
                    $warning_msg[] = 'Password does not match';
                } 
                else {
                    // Prepare and execute insert statement
                    $insert_admin = $conn->prepare("INSERT INTO `admin` (id, name, email, password, profile) VALUES (?, ?, ?, ?, ?)");
                    $insert_admin->execute([$id, $name, $email, $pass, $image]); // Changed $cpass to $pass

                    // Move uploaded file
                    move_uploaded_file($image_tmp_name, $image_folder);

                    $success_msg[] = 'New admin registered successfully';
                }
            }
        } 
        catch(PDOException $e){
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
    <title>Green Coffee Admin Panel - Register Page</title>
</head>

<body>

    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h3>Register Now</h3>
                    <div class="input-field">
                        <label>user name<sup>*</sup></label>
                        <input type="text" name="name" maxlength="20" required placeholder="Enter your username" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    
                    <div class="input-field">
                        <label>user email<sup>*</sup></label>
                        <input type="email" name="email" maxlength="20" required placeholder="Enter your email" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input-field">
                        <label>user password<sup>*</sup></label>
                        <input type="password" name="password" maxlength="20" required placeholder="Enter your password" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input-field">
                        <label>confirm password<sup>*</sup></label>
                        <input type="password" name="cpassword" maxlength="20" required placeholder="confirm password" oninput="this.value.replace(/\s/g,'')">
                    </div>

                    <div class="input-field">
                        <label>select profile<sup>*</sup></label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="register" class="btn">Register Now</button>
                    <p>Already have an account? <a href="login.php">Login</a></p>
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