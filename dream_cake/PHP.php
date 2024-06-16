<?php
<?php
session_start();

// Inisialisasi jumlah klik
if (!isset($_SESSION['click_count'])) {
    $_SESSION['click_count'] = 0;
}

// Periksa apakah ada request POST dari tombol
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["clicked"])) {
    // Tambahkan jumlah klik
    $_SESSION['click_count']++;

    // Kirim kembali jumlah klik sebagai respons
    echo $_SESSION['click_count'];
}

$pdf_link = "dream book.pdf";
?>