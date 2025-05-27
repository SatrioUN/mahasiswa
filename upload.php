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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Mahasiswa</title>
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
        max-width: 460px;
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
        font-size: 1.3em;
    }

    .button {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-alt) 100%);
        color: var(--text-main);
        border: none;
        border-radius: 6px;
        padding: 10px 18px;
        font-size: 0.98em;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        margin-right: 8px;
        transition: background 0.3s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.12);
    }

    .button:hover {
        background: linear-gradient(90deg, var(--primary-alt) 0%, var(--primary) 100%);
    }

    main h2 {
        color: var(--success);
        margin-top: 0;
        margin-bottom: 16px;
        font-weight: 700;
        text-align: center;
    }

    form {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 30px 20px 16px 20px;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.04);
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    input[type="text"],
    input[type="file"] {
        width: 100%;
        padding: 10px 12px;
        margin-top: 4px;
        margin-bottom: 16px;
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

    input[type="submit"] {
        width: 100%;
        margin-top: 6px;
        background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%);
        color: var(--bg-main);
        border: none;
        border-radius: 6px;
        padding: 12px 0;
        font-size: 1.05em;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
    }

    input[type="submit"]:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
        color: var(--text-main);
    }

    .error {
        color: var(--danger);
        background: #242222;
        border-left: 6px solid var(--danger);
        padding: 8px 14px;
        border-radius: 6px;
        margin-bottom: 16px;
    }

    p {
        color: var(--text-muted);
        font-size: 0.99em;
    }

    footer {
        margin-top: 44px;
        padding-top: 22px;
        border-top: 2px solid var(--primary);
        text-align: center;
        color: var(--text-muted);
        font-size: 0.97em;
        letter-spacing: 1px;
    }

    @media (max-width: 600px) {
        .container {
            padding: 12px 2vw 15px 2vw;
        }

        form {
            padding: 15px 4vw 8px 4vw;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Upload Foto Mahasiswa</h1>
            <a href="index.php" class="button">Kembali</a>
        </header>
        <main>
            <h2>Pilih Foto untuk Mahasiswa</h2>
            <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            <form action="upload_foto_aksi.php" method="post" enctype="multipart/form-data">
                <label for="mahasiswa_id">ID Mahasiswa</label>
                <input type="text" id="mahasiswa_id" name="mahasiswa_id" required>

                <label for="foto">Pilih File Foto</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>

                <input type="submit" value="Upload Foto">
                <p>Format yang diizinkan: JPEG, PNG, GIF. Maksimum 2MB.</p>
            </form>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> UBSI CYBER COMMUNITY</p>
        </footer>
    </div>
</body>

</html>