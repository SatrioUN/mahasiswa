<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "koneksi.php";

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    if (empty($username) || empty($password)) {
        $login_error = "Username dan password harus diisi.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $db_username, $db_password);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION["user_id"] = $user_id;
                $_SESSION["username"] = $db_username;
                header("Location: index.php");
                exit();
            } else {
                $login_error = "Password salah.";
            }
        } else {
            $login_error = "Pengguna tidak ditemukan.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Mahasiswa</title>
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

    .login-container {
        background: var(--bg-accent);
        border-radius: 16px;
        box-shadow: var(--shadow);
        padding: 42px 38px 36px 38px;
        width: 100%;
        max-width: 380px;
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

    .login-header h2 {
        color: var(--primary);
        margin-bottom: 6px;
        font-size: 2.1em;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .login-header p {
        color: var(--text-muted);
        margin-bottom: 30px;
        font-size: 1.07em;
    }

    .form-group {
        margin-bottom: 26px;
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

    .login-button {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-alt) 100%);
        color: var(--text-main);
        padding: 13px 0;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        font-size: 1.12em;
        width: 100%;
        font-weight: 700;
        transition: background 0.3s, transform 0.16s;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.10);
    }

    .login-button:hover {
        background: linear-gradient(90deg, var(--primary-alt) 0%, var(--primary) 100%);
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

    .signup-link {
        margin-top: 32px;
        font-size: 1em;
        color: var(--text-muted);
        text-align: center;
    }

    .signup-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .signup-link a:hover {
        color: var(--success);
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .login-container {
            padding: 22px 3vw 16px 3vw;
        }
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Login</h2>
            <p>Selamat datang kembali! Silakan masuk ke akun Anda.</p>
        </div>
        <?php if ($login_error): ?>
        <div class="error-message"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Masuk</button>
        </form>
        <div class="signup-link">Belum punya akun? <a href="register.php">Daftar di sini</a>.</div>
    </div>
</body>

</html>