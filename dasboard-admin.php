<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <!-- <link rel="stylesheet" type="text/css" href="styleadmin.css"> -->
    <link rel="stylesheet" href="dasboard.css" />
    <style>
    /* Admin Dashboard Styles */

    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 2.5rem;
        color: #333;
    }

    p {
        text-align: center;
        font-size: 1.2rem;
        color: #666;
    }

    .logout-btn {
        text-align: right;
        margin-bottom: 1.5rem;
    }

    .btn-logout {
        text-decoration: none;
        color: #fff;
        background-color: #d9534f;
        padding: 0.6rem 1.2rem;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #c9302c;
    }

    .container {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    table thead {
        background-color: #333;
        color: #fff;
    }

    table th, table td {
        padding: 1rem;
        text-align: left;
        border: 1px solid #ddd;
        word-wrap: break-word;
        hyphens: auto;
    }

    table th {
        background-color: #333;
        color: #fff;
        font-weight: bold;
    }

    table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tbody tr:hover {
        background-color: #e6f7ff;
    }

    table tbody tr td {
        vertical-align: middle;
    }

    .btn {
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        display: inline-block;
        margin-right: 10px; /* Add spacing between buttons */
    }

    .btn.delete {
        background-color: #d9534f;
        color: #fff;
    }

    .btn.update {
        background-color: #0275d8;
        color: #fff;
        margin-bottom: 20px;
    }

    .btn.delete:hover {
        background-color: #c9302c;
    }

    .btn.update:hover {
        background-color: #025aa5;
    }

    .reservation-button {
        text-align: center;
        margin-top: 1.5rem;
    }

    .reservation-button a {
        text-decoration: none;
        color: #fff;
        background-color: #0275d8;
        padding: 0.6rem 1.2rem;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .reservation-button a:hover {
        background-color: #025aa5;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Admin</h1>
        <p>Data Reservasi Meja Edirne Coffe & Space</p>
        <div class="logout-btn">
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID Reservasi</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Tanggal Reservasi</th>
                    <th>Jam Reservasi</th>
                    <th>Jumlah Orang</th>
                    <th>Catatan Pesanan</th>
                    <th>Status Reservasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data reservasi akan dimuat di sini menggunakan PHP -->
                <?php
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

                // Query untuk mengambil data reservasi
                $sql = "SELECT * FROM Reservasi";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Menampilkan data untuk setiap baris
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["order_id"] . "</td>
                                <td>" . $row["nama_lengkap"] . "</td>
                                <td>" . $row["nomor_telepon"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>" . $row["tanggal_reservasi"] . "</td>
                                <td>" . $row["jam_reservasi"] . "</td>
                                <td>" . $row["jumlah_orang"] . "</td>
                                <td>" . $row["catatan_pesanan"] . "</td>
                                <td>" . $row["Status"] . "</td>
                                <td>
                                    <a href='update_reservasi.php?id=" . $row["order_id"] . "' class='btn update'>Update</a>
                                    <a href='delete_reservasi.php?id=" . $row["id"] . "' class='btn delete' onclick='return confirmDelete()'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Tidak ada data reservasi</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus reservasi ini?");
        }
    </script>
</body>
</html>
