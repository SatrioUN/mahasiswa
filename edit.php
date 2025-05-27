<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}
$username = $_SESSION["username"];
include 'koneksi.php';

$id = $_GET["id"];
$sql = "SELECT * FROM mahasiswa WHERE id=$id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <style>
    :root {
        --bg-main: #17191e;
        --bg-accent: #22242a;
        --bg-card: #242731;
        --primary: #4f8cff;
        --primary-alt: #326ac0;
        --success: #38d39f;
        --danger: #ff5e62;
        --warning: #ffc371;
        --text-main: #f8f8f8;
        --text-secondary: #ccd6f6;
        --text-muted: #8892b0;
        --border: #333642;
        --shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    body {
        font-family: 'Montserrat', Arial, sans-serif;
        background: var(--bg-main);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        color: var(--text-main);
    }

    .container {
        background: var(--bg-accent);
        margin: 40px auto;
        padding: 40px 30px 30px 30px;
        border-radius: 16px;
        box-shadow: var(--shadow);
        max-width: 480px;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--primary);
        padding-bottom: 18px;
        margin-bottom: 25px;
    }

    header h1,
    .container h1 {
        color: var(--primary);
        letter-spacing: 1.5px;
        margin: 0 0 20px 0;
        font-weight: 700;
        font-size: 1.5em;
        text-align: center;
    }

    .button,
    .actions .button,
    .button.cancel {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-alt) 100%);
        color: var(--text-main);
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        margin-right: 8px;
        transition: background 0.3s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.12);
        display: inline-block;
    }

    .button.cancel {
        background: linear-gradient(90deg, var(--danger) 0%, var(--primary-alt) 100%);
        color: var(--text-main);
        margin-left: 0;
    }

    .button:hover,
    .button.cancel:hover {
        background: linear-gradient(90deg, var(--primary-alt) 0%, var(--primary) 100%);
    }

    form {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 30px 20px 20px 20px;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.04);
    }

    label {
        display: block;
        margin-bottom: 12px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    input[type="text"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 11px 12px;
        margin-top: 6px;
        margin-bottom: 12px;
        border: 1px solid var(--border);
        border-radius: 5px;
        background: var(--bg-accent);
        color: var(--text-main);
        font-size: 1em;
        box-sizing: border-box;
    }

    input[type="file"] {
        background: none;
        color: var(--text-muted);
        border: none;
    }

    img {
        margin: 8px 0;
        border-radius: 8px;
        max-width: 70px;
        max-height: 70px;
        background: #1e2128;
        border: 2px solid var(--primary);
    }

    small {
        color: var(--text-muted);
    }

    @media (max-width: 600px) {
        .container {
            padding: 12px 2vw 15px 2vw;
        }

        form {
            padding: 18px 4vw 8px 4vw;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Data Mahasiswa</h1>
        <?php
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        ?>
        <form action="proses_edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">

            <label for="nama">Nama
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($row["nama"]); ?>" required>
            </label>

            <label for="nim">NIM
                <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($row["nim"]); ?>" required>
            </label>

            <label for="jurusan">Jurusan
                <input type="text" id="jurusan" name="jurusan" value="<?php echo htmlspecialchars($row["jurusan"]); ?>"
                    required>
            </label>

            <label for="foto">Foto Saat Ini</label>
            <?php if (!empty($row["foto"]) && file_exists("uploads/" . $row["foto"])): ?>
            <img src='uploads/<?php echo htmlspecialchars($row["foto"]); ?>'
                alt='<?php echo htmlspecialchars($row["nama"]); ?>'>
            <?php else: ?>
            <span style="color:#888;font-size:0.97em;">Tidak ada foto</span>
            <?php endif; ?>

            <label for="foto">Ganti Foto</label>
            <input type="file" id="foto" name="foto">
            <small>Biarkan kosong jika tidak ingin mengubah foto.</small>

            <br><br>
            <input type="submit" value="Simpan Perubahan" class="button">
            <a href="index.php" class="button cancel">Batal</a>
        </form>
        <?php
        } else {
            echo "<p>Data mahasiswa tidak ditemukan.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>

</html>