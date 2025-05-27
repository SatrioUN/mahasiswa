<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $nim = $_POST["nim"];
    $jurusan = $_POST["jurusan"];
    $foto_baru = $_FILES["foto"]["name"];
    $tmp_name = $_FILES["foto"]["tmp_name"];
    $folder = "uploads/";

    // Ambil nama foto lama dari database
    $sql_select = "SELECT foto FROM mahasiswa WHERE id=$id";
    $result_select = $conn->query($sql_select);
    $row_select = $result_select->fetch_assoc();
    $foto_lama = $row_select["foto"];

    // Proses upload foto baru jika ada
    if (!empty($foto_baru)) {
        // Hapus foto lama jika ada
        if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
            unlink($folder . $foto_lama);
        }
        move_uploaded_file($tmp_name, $folder . $foto_baru);
        $foto = $foto_baru;
    } else {
        $foto = $foto_lama; // Gunakan foto lama jika tidak ada foto baru yang diunggah
    }

    $sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim', jurusan='$jurusan', foto='$foto' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>