<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}
require_once "koneksi.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM mahasiswa WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index?success=Data berhasil dihapus");
    } else {
        header("Location: indexp?error=" . urlencode("Terjadi kesalahan: " . $conn->error));
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: index");
    exit();
}
?>