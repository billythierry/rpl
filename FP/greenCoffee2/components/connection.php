<?php
    $db_name = 'mysql:host=localhost;port=3307;dbname=green_coffee';
    $db_user = 'root';
    $db_pasword = '';

    // $conn = new PDO($db_name,$db_user,$db_pasword);

    try {
        $conn = new PDO($db_name, $db_user, $db_pasword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    function unique_id() {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charlength = strlen($chars);
        $randomstring = '';
        for ($i = 0; $i < 20; $i++) {
            $randomstring = $chars[mt_rand(0, $charlength -1)];
        }
        return $randomstring;
    }
?>