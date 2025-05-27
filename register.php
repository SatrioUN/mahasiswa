<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login, jika ya, redirect ke dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// Konfigurasi database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'db_mahasiswa';

// Buat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("<div class='container'><div class='error'>Koneksi database gagal: " . $conn->connect_error . "</div></div>");
}

// Inisialisasi variabel error
$register_error = '';

// Proses pendaftaran saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $register_error = "Semua field harus diisi.";
    } elseif ($password !== $confirm_password) {
        $register_error = "Password dan Konfirmasi Password tidak cocok.";
    } elseif (strlen($password) < 6) {
        $register_error = "Password minimal harus 6 karakter.";
    } else {
        // Periksa apakah username sudah ada
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $register_error = "Username sudah terdaftar.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Siapkan query untuk menyimpan pengguna baru
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                // Pendaftaran berhasil, redirect ke halaman login
                header("Location: login.php?register_success=1");
                exit();
            } else {
                $register_error = "Terjadi kesalahan saat mendaftar.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Informasi Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
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
        --shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
    }

    body {
        font-family: 'Montserrat', Arial, sans-serif;
        background: linear-gradient(135deg, #23243a 0%, #17191e 100%);
        min-height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--text-main);
    }

    .register-container {
        background: var(--bg-accent);
        border-radius: 16px;
        box-shadow: var(--shadow);
        padding: 40px 36px 32px 36px;
        width: 100%;
        max-width: 410px;
        text-align: center;
        animation: fadein 0.9s;
    }

    @keyframes fadein {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .register-header h2 {
        color: var(--primary);
        margin-bottom: 6px;
        font-size: 2.1em;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .register-header p {
        color: var(--text-muted);
        margin-bottom: 28px;
        font-size: 1.09em;
    }

    .form-group {
        margin-bottom: 23px;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 1em;
        letter-spacing: 0.3px;
    }

    .form-group input[type="text"],
    .form-group input[type="password"] {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid var(--border);
        border-radius: 7px;
        background: var(--bg-card);
        color: var(--text-main);
        font-size: 1em;
        transition: border-color 0.25s, box-shadow 0.23s;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="password"]:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 8px var(--primary);
    }

    .register-button {
        background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%);
        color: var(--bg-main);
        padding: 13px 0;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        font-size: 1.1em;
        width: 100%;
        font-weight: 700;
        transition: background 0.3s, transform 0.14s;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.10);
    }

    .register-button:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
        color: var(--text-main);
        transform: scale(1.025);
    }

    .error-message {
        color: var(--danger);
        background: #242222;
        border-left: 6px solid var(--danger);
        padding: 10px 18px;
        border-radius: 6px;
        margin-bottom: 18px;
        font-size: 0.98em;
        text-align: left;
    }

    .login-link {
        margin-top: 32px;
        font-size: 1em;
        color: var(--text-muted);
        text-align: center;
    }

    .login-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .login-link a:hover {
        color: var(--success);
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .register-container {
            padding: 18px 3vw 14px 3vw;
        }
    }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Daftar</h2>
            <p>Buat akun baru Anda!</p>
        </div>
        <?php if ($register_error): ?>
        <div class="error-message"><?php echo htmlspecialchars($register_error); ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password (minimal 6 karakter)</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="register-button">Daftar</button>
        </form>
        <div class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a>.</div>
    </div>
</body>

</html>