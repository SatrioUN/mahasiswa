<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}
require_once "koneksi.php";

// Tentukan direktori tempat menyimpan foto
$upload_dir = "uploads/"; // Pastikan direktori ini ada dan writable oleh server

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto"])) {
    $foto = $_FILES["foto"];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_name = basename($foto["name"]);
    $file_tmp = $foto["tmp_name"];
    $file_type = $foto["type"];
    $file_error = $foto["error"];
    $file_size = $foto["size"];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    $errors = [];

    // Validasi tipe file
    if (!in_array($file_type, $allowed_types)) {
        $errors[] = "Tipe file tidak diizinkan. Hanya JPEG, PNG, dan GIF yang diperbolehkan.";
    }

    // Validasi ukuran file
    if ($file_size > $max_file_size) {
        $errors[] = "Ukuran file terlalu besar. Maksimum 2MB diperbolehkan.";
    }

    // Cek apakah ada error saat upload
    if ($file_error !== UPLOAD_ERR_OK) {
        $errors[] = "Terjadi kesalahan saat mengunggah file.";
    }

    if (empty($errors)) {
        // Buat nama file unik untuk menghindari duplikasi
        $unique_filename = uniqid() . "_" . $file_name;
        $destination = $upload_dir . $unique_filename;

        if (move_uploaded_file($file_tmp, $destination)) {
            // Asumsikan Anda ingin menyimpan nama file terkait dengan seorang mahasiswa
            // Anda perlu mekanisme untuk mengidentifikasi mahasiswa mana yang fotonya diunggah
            // Misalnya, melalui ID mahasiswa yang dikirimkan melalui form

            $mahasiswa_id = $_POST["mahasiswa_id"] ?? null; // Ambil ID mahasiswa dari form

            if ($mahasiswa_id) {
                // Pastikan kolom 'foto' ada di tabel 'mahasiswa'
                $sql = "UPDATE mahasiswa SET foto = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $unique_filename, $mahasiswa_id);

                if ($stmt->execute()) {
                    header("Location: index?success=" . urlencode("Foto berhasil diunggah dan disimpan."));
                } else {
                    $errors[] = "Gagal menyimpan nama file ke database: " . $stmt->error;
                    // Hapus file yang sudah diupload jika gagal menyimpan ke database
                    unlink($destination);
                }
                $stmt->close();
            } else {
                $errors[] = "ID Mahasiswa tidak ditemukan.";
                // Hapus file yang sudah diupload karena tidak ada ID mahasiswa
                unlink($destination);
            }
        } else {
            $errors[] = "Gagal memindahkan file ke direktori penyimpanan.";
        }
    }

    if (!empty($errors)) {
        $error_message = "Terjadi kesalahan saat mengunggah foto:<br>" . implode("<br>", $errors);
        header("Location: upload_foto?error=" . urlencode($error_message));
    }

    $conn->close();
} else {
    header("Location: upload_foto");
    exit();
}
?>