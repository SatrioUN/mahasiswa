<?php
include 'koneksi.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Ambil nama foto dari database sebelum menghapus data
    $sql_select = "SELECT foto FROM mahasiswa WHERE id=$id";
    $result_select = $conn->query($sql_select);
    $row_select = $result_select->fetch_assoc();
    $foto_lama = $row_select["foto"];
    $folder = "uploads/";

    $sql = "DELETE FROM mahasiswa WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        
        if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
            unlink($folder . $foto_lama);
        }
        header("Location: index");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
}
?>