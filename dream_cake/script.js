document.addEventListener("DOMContentLoaded", function() {
    // Tangkap elemen tombol "View Dream Book"
    const viewDreamBookBtn = document.querySelector('.btn-view-dream-book');

    // Lakukan request AJAX saat tombol diklik
    viewDreamBookBtn.addEventListener("click", function() {
        // Buat objek XMLHttpRequest
        let xhr = new XMLHttpRequest();

        // Set konfigurasi AJAX
        xhr.open("POST", "count_clicks.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Tambahkan event handler untuk saat respons diterima
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Perbarui teks tombol dengan jumlah klik yang diterima dari server
                viewDreamBookBtn.textContent = "View Dream Book (" + xhr.responseText + ")";
            }
        };

        // Kirim request POST dengan data yang diperlukan
        xhr.send("clicked=true");
    });
});
