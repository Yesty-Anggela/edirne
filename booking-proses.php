<?php 
    include('koneksi.php');
    
    $order_id = rand();

    if ($stmt = $con->prepare('INSERT INTO reservasi (nama_lengkap, nomor_telepon, email, tanggal_reservasi, jam_reservasi, jumlah_orang, catatan_pesanan, order_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
        $stmt->bind_param('sssssiss', $_POST['nama_lengkap'], $_POST['nomor_telepon'], $_POST['email'], $_POST['tanggal_reservasi'], $_POST['jam_reservasi'], $_POST['jumlah_orang'], $_POST['catatan_pesanan'], $order_id);
        $stmt->execute();
        echo "<script> setTimeout(function(){window.location.href = 'midtrans/examples/snap/checkout-process-simple-version.php?order_id=$order_id'; },2);</script>";
        $stmt->close();
    } else {
        echo 'Could not prepare statement!';
    }

    // Upload file bukti bayar
    if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
        $ekstensi_diperbolehkan = array('png', 'jpg');
        $bukti_bayar = $_FILES['bukti_bayar']['name'];
        $file_extension = strtolower(pathinfo($bukti_bayar, PATHINFO_EXTENSION));
        $file_size = $_FILES['bukti_bayar']['size'];
        $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
        $upload_path = 'bukti_bayar/' . $bukti_bayar;

        if (in_array($file_extension, $ekstensi_diperbolehkan)) {
            if ($file_size < 1044070) {            
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $reservation_id = $con->insert_id; // Get the last inserted id
                    if ($stmt = $con->prepare('UPDATE reservasi SET bukti_pembayaran = ? WHERE id = ?')) {
                        $stmt->bind_param('si', $bukti_bayar, $reservation_id);
                        if ($stmt->execute()) {
                            echo 'Bukti Pembayaran Berhasil Diupload';
                        } else {
                            echo 'Failed to update statement: ' . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        echo 'Could not prepare statement: ' . $con->error;
                    }
                } else {
                    echo 'GAGAL MENGUPLOAD FILE';
                }
            } else {
                echo 'UKURAN FILE TERLALU BESAR';
            }
        } else {
            echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
        }
    }
?>