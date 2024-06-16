<?php
    $db_name = 'mysql:host=localhost;port=3307;dbname=green_coffee';
    $user_name = 'root';
    $user_password = '';

    // $conn = new PDO($db_name, $user_name, $user_password);

    try {
        $conn = new PDO($db_name, $user_name, $user_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    
    // if(!$conn) {
    //     echo "Did not connect to database.";
    // }

    function unique_id(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($chars);
        $randomString = '';

        for ($i = 0; $i < 20; $i++) {
            $randomString .= $chars[mt_rand(0, $charLength - 1)];
        }
        return $randomString;
    }

?>