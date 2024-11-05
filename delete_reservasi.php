<?php
// Start the session
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the reservation ID from the URL
    $reservation_id = $_GET['id'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Edirne";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // SQL query to delete the reservation with the given ID
    $sql = "DELETE FROM Reservasi WHERE id = ?";

    // Prepare the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the reservation ID parameter
        $stmt->bind_param("i", $reservation_id);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // If the reservation was deleted successfully, redirect to the admin dashboard
            header('Location: dasboard-admin.php');
            exit;
        } else {
            echo "Terjadi kesalahan saat menghapus reservasi.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyiapkan pernyataan SQL.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "ID reservasi tidak ditemukan.";
}
?>
