<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
    exit();
}

$username = $_SESSION["username"];

require_once "koneksi.php";

// Ambil juga kolom foto
$sql = "SELECT id, nama, nim, jurusan, foto FROM mahasiswa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
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
        max-width: 1100px;
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
        font-size: 2em;
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
        margin-bottom: 15px;
        font-weight: 700;
    }

    .actions {
        margin-bottom: 22px;
    }

    .actions .button.primary {
        background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%);
        color: var(--bg-main);
    }

    .actions .button.primary:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
        color: var(--text-main);
    }

    .actions .button.secondary {
        background: linear-gradient(90deg, var(--warning) 0%, var(--primary) 100%);
        color: var(--bg-main);
    }

    .actions .button.secondary:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--warning) 100%);
        color: var(--text-main);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--bg-card);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.04);
    }

    thead {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-alt) 100%);
        color: #fff;
    }

    th,
    td {
        padding: 14px 15px;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    tr:nth-child(even) {
        background: var(--bg-accent);
    }

    tr:hover {
        background: #23263a;
        transition: background 0.2s;
    }

    th {
        font-weight: 700;
        letter-spacing: 1px;
    }

    td.foto {
        text-align: center;
    }

    td.foto img {
        max-width: 56px;
        max-height: 56px;
        border-radius: 50%;
        border: 2px solid var(--primary);
        box-shadow: 0 2px 8px rgba(79, 140, 255, 0.08);
        background: #17191e;
    }

    td.foto .no-photo {
        color: var(--text-muted);
        font-size: 0.92em;
        font-style: italic;
    }

    td.actions a {
        display: inline-block;
        padding: 7px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.92em;
        margin-right: 5px;
        transition: background 0.2s, color 0.2s;
        font-weight: 600;
    }

    td.actions .edit-button {
        background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%);
        color: var(--bg-main);
    }

    td.actions .edit-button:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
        color: var(--text-main);
    }

    td.actions .delete-button {
        background: linear-gradient(90deg, var(--danger) 0%, var(--primary) 100%);
        color: var(--text-main);
    }

    td.actions .delete-button:hover {
        background: linear-gradient(90deg, var(--primary) 0%, var(--danger) 100%);
    }

    .no-data {
        color: var(--text-muted);
        font-style: italic;
        margin-top: 25px;
        font-size: 1.1em;
        text-align: center;
    }

    @media (max-width: 800px) {
        .container {
            padding: 18px 2vw 15px 2vw;
        }

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead tr {
            display: none;
        }

        tr {
            margin-bottom: 1em;
            border-bottom: 2px solid var(--primary);
            border-radius: 8px;
            background: var(--bg-card);
            box-shadow: 0 1px 4px rgba(79, 140, 255, 0.07);
        }

        td {
            position: relative;
            padding-left: 50%;
            border-bottom: none;
        }

        td:before {
            position: absolute;
            left: 18px;
            top: 14px;
            width: 48%;
            white-space: nowrap;
            font-weight: 600;
            color: var(--primary);
        }

        td:nth-of-type(1):before {
            content: "ID";
        }

        td:nth-of-type(2):before {
            content: "Nama";
        }

        td:nth-of-type(3):before {
            content: "NIM";
        }

        td:nth-of-type(4):before {
            content: "Prodi";
        }

        td:nth-of-type(5):before {
            content: "Foto";
        }

        td:nth-of-type(6):before {
            content: "Update";
        }

        td.foto {
            text-align: left;
            padding-left: 50%;
        }
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

    /* Scrollbar styling for dark mode */
    ::-webkit-scrollbar {
        width: 10px;
        background: #22242a;
    }

    ::-webkit-scrollbar-thumb {
        background: #30343e;
        border-radius: 6px;
    }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Selamat datang, <?php echo htmlspecialchars($username); ?>!</h1>
            <a href="logout" class="button">Logout</a>
        </header>

        <main>
            <h2>Data Mahasiswa</h2>
            <div class="actions">
                <a href="tambah.php" class="button primary">Tambah Data Mahasiswa</a>
                <a href="upload" class="button secondary">Upload Data (CSV)</a>
            </div>

            <?php
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Nama</th>";
                echo "<th>NIM</th>";
                echo "<th>Prodi</th>";
                echo "<th>Foto</th>";
                echo "<th>Update</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["nama"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nim"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["jurusan"]) . "</td>";
                    // Kolom foto
                    echo "<td class='foto'>";
                    if (!empty($row["foto"]) && file_exists("uploads/" . $row["foto"])) {
                        echo "<img src='uploads/" . htmlspecialchars($row["foto"]) . "' alt='Foto'>";
                    } else {
                        echo "<span class='no-photo'>Tidak ada foto</span>";
                    }
                    echo "</td>";
                    // Kolom aksi
                    echo "<td class='actions'>";
                    echo "<a href='edit?id=" . $row["id"] . "' class='edit-button'>Edit</a>";
                    echo "<a href='hapus_aksi?id=" . $row["id"] . "' class='delete-button' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='no-data'>Tidak ada data mahasiswa.</p>";
            }
            ?>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> UBSI CYBER COMMUNITY</p>
        </footer>
    </div>
</body>

</html>
<?php
$conn->close();
?>