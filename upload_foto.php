<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto Mahasiswa</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #6dd5ed, #2193b0);
        /* Light Blue to Teal Gradient */
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #333;
    }

    .container {
        background-color: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 600px;
        text-align: center;
    }

    header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #eee;
    }

    header h1 {
        color: #2c3e50;
        /* Dark Blue Gray */
        margin: 0;
        font-size: 2.2em;
    }

    header .button {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        font-size: 1em;
        transition: background-color 0.3s ease;
        background-color: #3498db;
        /* Bright Blue */
        color: white;
    }

    header .button:hover {
        background-color: #2980b9;
        /* Darker Blue */
    }

    main h2 {
        color: #2c3e50;
        margin-top: 20px;
        margin-bottom: 25px;
        font-size: 1.8em;
    }

    .error {
        color: #c0392b;
        /* Red */
        background-color: #fdecea;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #e74c3c;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    label {
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
        text-align: left;
    }

    input[type="text"],
    input[type="file"] {
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1em;
    }

    input[type="file"]::-webkit-file-upload-button {
        background-color: #f39c12;
        /* Orange */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="file"]::-webkit-file-upload-button:hover {
        background-color: #e67e22;
        /* Darker Orange */
    }

    input[type="submit"] {
        background-color: #2ecc71;
        /* Green */
        color: white;
        padding: 15px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1.1em;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #27ae60;
        /* Darker Green */
    }

    p {
        color: #777;
        font-size: 0.9em;
        margin-top: 15px;
    }

    footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
        text-align: center;
        color: #777;
        font-size: 0.9em;
    }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Upload Foto Mahasiswa</h1>
            <p><a href="index" class="button">Kembali</a></p>
        </header>

        <main>
            <h2>Pilih Foto untuk Mahasiswa</h2>
            <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            <form action="upload_foto_aksi" method="post" enctype="multipart/form-data">
                <label for="mahasiswa_id">ID Mahasiswa:</label>
                <input type="text" id="mahasiswa_id" name="mahasiswa_id" required><br><br>

                <label for="foto">Pilih File Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required><br><br>

                <input type="submit" value="Upload Foto">
                <p>Format yang diizinkan: JPEG, PNG, GIF. Maksimum 2MB.</p>
            </form>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?>UBSI CYBER COMMUNITY</p>
        </footer>
    </div>
</body>

</html>