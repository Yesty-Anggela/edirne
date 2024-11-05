<?php 
    include('koneksi.php');
    
    if ($stmt = $con->prepare('INSERT INTO contact (nama, email, no_telepon, komentar) VALUES (?, ?, ?, ?)')) {
        $stmt->bind_param('ssss', $_POST['nama'], $_POST['email'], $_POST['no_telepon'], $_POST['komentar']);
        $stmt->execute();
        echo "Berhasil Mengirim";
        $stmt->close();
    } else {
        echo 'Could not prepare statement!';
    }
?>