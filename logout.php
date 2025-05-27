<?php
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=login.php?logout=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Sistem Informasi Mahasiswa</title>
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
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logout-container {
        background: var(--bg-accent);
        padding: 44px 42px 34px 42px;
        border-radius: 16px;
        box-shadow: var(--shadow);
        min-width: 340px;
        max-width: 98vw;
        text-align: center;
    }

    .logout-header h2 {
        color: var(--success);
        font-size: 2em;
        margin-bottom: 18px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .logout-message {
        color: var(--text-secondary);
        font-size: 1.08em;
        margin-bottom: 26px;
    }

    .logout-button {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-alt) 100%);
        color: var(--text-main);
        padding: 13px 35px;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        font-size: 1em;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.3s;
        margin-bottom: 10px;
        display: inline-block;
    }

    .logout-button:hover {
        background: linear-gradient(90deg, var(--primary-alt) 0%, var(--primary) 100%);
    }

    .back-link {
        margin-top: 18px;
        font-size: 0.99em;
        color: var(--text-muted);
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

    @media (max-width: 540px) {
        .logout-container {
            padding: 18px 2vw 15px 2vw;
            min-width: unset;
        }
    }
    </style>
</head>

<body>
    <div class="logout-container">
        <div class="logout-header">
            <h2>Logout Berhasil</h2>
        </div>
        <p class="logout-message">Anda telah berhasil keluar dari sistem.<br>Anda akan diarahkan ke halaman login...</p>
        <a href="login.php" class="logout-button">Kembali ke Login</a>
        <p class="back-link">Atau <a href="index.php">Kembali ke Dashboard</a></p>
    </div>
</body>

</html>