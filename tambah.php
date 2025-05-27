<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    header h1 {
        color: var(--primary);
        letter-spacing: 1.5px;
        margin: 0;
        font-weight: 700;
        font-size: 1.5em;
    }

    .button,
    .actions .button {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-alt) 100%);
        color: var(--text-main);
        border: none;
        border-radius: 6px;
        padding: 12px 22px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        margin-right: 8px;
        transition: background 0.3s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.12);
    }

    .button:hover,
    .actions .button:hover {
        background: linear-gradient(90deg, var(--primary-alt) 0%, var(--primary) 100%);
        color: var(--text-main);
    }

    main h2 {
        color: var(--success);
        margin-top: 0;
        margin-bottom: 22px;
        font-weight: 700;
        text-align: center;
    }

    form {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 30px 20px 20px 20px;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.04);
    }

    label {
        display: block;
        margin-bottom: 16px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    input[type="text"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 11px 12px;
        margin-top: 6px;
        margin-bottom: 2px;
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

    button[type="submit"] {
        width: 100%;
        margin-top: 18px;
        background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%);
        color: var(--bg-main);
        border: none;
        border-radius: 6px;
        padding: 12px 0;
        font-size: 1.08em;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
    }

    button[type="submit"]:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
        color: var(--text-main);
    }

    .back-link {
        margin-top: 22px;
        text-align: center;
    }

    .back-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .back-link a:hover {
        color: var(--success);
        text-decoration: underline;
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
        <header>
            <h1>Tambah Mahasiswa</h1>
            <a href="index.php" class="button">Kembali</a>
        </header>
        <main>
            <h2>Tambah Data Mahasiswa</h2>
            <form action="tambah_aksi.php" method="post" enctype="multipart/form-data">
                <label>Nama
                    <input type="text" name="nama" required>
                </label>
                <label>NIM
                    <input type="text" name="nim" required>
                </label>
                <label>Jurusan
                    <input type="text" name="jurusan" required>
                </label>
                <label>Foto
                    <input type="file" name="foto" accept="image/*">
                </label>
                <button type="submit">Simpan</button>
            </form>
            <div class="back-link">
                <a href="index.php">&larr; Kembali ke Daftar</a>
            </div>
        </main>
    </div>
</body>

</html>