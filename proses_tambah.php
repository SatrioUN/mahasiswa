<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $nim = $_POST["nim"];
    $jurusan = $_POST["jurusan"];
    $foto = $_FILES["foto"]["name"];
    $tmp_name = $_FILES["foto"]["tmp_name"];
    $folder = "uploads/";

    // Pindahkan file foto ke folder uploads jika ada
    if (!empty($foto)) {
        move_uploaded_file($tmp_name, $folder . $foto);
    } else {
        $foto = ""; // Jika tidak ada foto yang diunggah, set nama file menjadi kosong
    }

    $sql = "INSERT INTO mahasiswa (nama, nim, jurusan, foto) VALUES ('$nama', '$nim', '$jurusan', '$foto')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>