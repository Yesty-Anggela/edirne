<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Edirne";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Mengambil data reservasi berdasarkan ID
    $sql = "SELECT * FROM Reservasi WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservasi = $result->fetch_assoc();

    // Memeriksa apakah data reservasi ditemukan
    if (!$reservasi) {
        echo "Data reservasi tidak ditemukan.";
        exit;
    }
} else {
    echo "ID reservasi tidak disediakan.";
    exit;
}

// Memproses form submit untuk memperbarui data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $tanggal_reservasi = $_POST['tanggal_reservasi'];
    $jam_reservasi = $_POST['jam_reservasi'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $catatan_pesanan = $_POST['catatan_pesanan'];

    // Query untuk memperbarui data reservasi
    $sql = "UPDATE Reservasi SET nama_lengkap=?, nomor_telepon=?, email=?, tanggal_reservasi=?, jam_reservasi=?, jumlah_orang=?, catatan_pesanan=? WHERE order_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nama_lengkap, $nomor_telepon, $email, $tanggal_reservasi, $jam_reservasi, $jumlah_orang, $catatan_pesanan, $order_id);

    if ($stmt->execute()) {
        echo "Data reservasi berhasil diperbarui.";
        header('Location:dasboard-admin.php'); // Redirect back to the dashboard
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Reservasi</title>
    <link rel="stylesheet" href="updatestyle.css" />
</head>
<body>
    <div class="container">
        <h1>Update Reservasi</h1>
        <form action="update_reservasi.php?id=<?php echo $order_id; ?>" method="post">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $reservasi['nama_lengkap']; ?>" >

            <label for="nomor_telepon">Nomor Telepon:</label>
            <input type="text" id="nomor_telepon" name="nomor_telepon" value="<?php echo $reservasi['nomor_telepon']; ?>" >

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $reservasi['email']; ?>" >

            <label for="tanggal_reservasi">Tanggal Reservasi:</label>
            <input type="date" id="tanggal_reservasi" name="tanggal_reservasi" value="<?php echo $reservasi['tanggal_reservasi']; ?>" >

            <label for="jam_reservasi">Jam Reservasi:</label>
            <input type="time" id="jam_reservasi" name="jam_reservasi" value="<?php echo $reservasi['jam_reservasi']; ?>" >

            <label for="jumlah_orang">Jumlah Orang:</label>
            <input type="number" id="jumlah_orang" name="jumlah_orang" value="<?php echo $reservasi['jumlah_orang']; ?>" >

            <label for="catatan_pesanan">Catatan Pesanan:</label>
            <textarea id="catatan_pesanan" name="catatan_pesanan" ><?php echo $reservasi['catatan_pesanan']; ?></textarea>

            <!-- <label for="status">Status Reservasi:</label>
            <select id="status" name="status" required>
                <option value="Pending" <?php if ($reservasi['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Confirmed" <?php if ($reservasi['Status'] == 'Confirmed') echo 'selected'; ?>>Dikonfirmasi</option>
                <option value="Cancelled" <?php if ($reservasi['Status'] == 'Cancelled') echo 'selected'; ?>>Dibatalkan</option>
            </select> -->

            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</body>
</html>
