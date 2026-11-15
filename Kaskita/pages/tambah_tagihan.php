<?php
session_start();

if (
    !isset($_SESSION['login']) ||
    $_SESSION['role'] !== 'bendahara'
) {
    header('Location: ../index.php');
    exit;
}

require_once '../config/Database.php';

$db = new Database();
$conn = $db->connect();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_tagihan = trim($_POST['nama_tagihan'] ?? '');
    $nominal = trim($_POST['nominal'] ?? '');
    $tanggal_tagihan = $_POST['tanggal_tagihan'] ?? '';
    $jatuh_tempo = $_POST['jatuh_tempo'] ?? '';

    if (
        $nama_tagihan === '' ||
        $nominal === '' ||
        $tanggal_tagihan === '' ||
        $jatuh_tempo === ''
    ) {

        $error = 'Semua data tagihan wajib diisi.';

    } elseif (!is_numeric($nominal) || $nominal <= 0) {

        $error = 'Nominal tagihan harus berupa angka.';

    } else {

        $stmt = $conn->prepare("
            INSERT INTO tagihan
            (nama_tagihan, nominal, tanggal_tagihan, jatuh_tempo)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "siss",
            $nama_tagihan,
            $nominal,
            $tanggal_tagihan,
            $jatuh_tempo
        );

        if ($stmt->execute()) {

            header('Location: tagihan.php');
            exit;

        } else {

            $error = 'Tagihan gagal ditambahkan.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Tagihan | KasKita</title>

    <link rel="stylesheet" href="/kaskita/assets/css/style.css">

</head>

<body>

    <div class="app">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="brand">

                <div class="brand-icon">
                    K
                </div>

                <div class="brand-name">
                    <span>Kas</span>Kita
                </div>

            </div>

            <div class="menu-section">

                <p class="menu-title">
                    MENU UTAMA
                </p>

                <nav class="menu">

                    <a href="dashboard.php">
                        <span class="menu-icon">⌂</span>
                        <span>Dashboard</span>
                    </a>

                    <a href="mahasiswa.php">
                        <span class="menu-icon">♙</span>
                        <span>Mahasiswa</span>
                    </a>

                    <a href="tambah_tagihan.php" class="active">
                        <span class="menu-icon">▣</span>
                        <span>Tambah Tagihan</span>
                    </a>

                </nav>

            </div>

            <div class="sidebar-bottom">

                <a href="../index.php" class="logout">
                    <span class="menu-icon">↪</span>
                    <span>Keluar</span>
                </a>

            </div>

        </aside>


        <!-- MAIN CONTENT -->
        <main class="main-content">

            <header class="topbar">

                <div class="page-title">

                    <h1>
                        Tambah Tagihan
                    </h1>

                    <p>
                        Buat tagihan kas untuk mahasiswa kelas 3A
                    </p>

                </div>

            </header>


            <div class="content-card">

                <div class="content-header">

                    <div>

                        <h2>
                            Form Tagihan
                        </h2>

                        <p>
                            Masukkan informasi tagihan yang akan diberikan kepada mahasiswa.
                        </p>

                    </div>

                </div>


            <?php if ($error !== ''): ?>

                    <div class="error-message">
                        <?= htmlspecialchars($error) ?>
                    </div>

            <?php endif; ?>


            <?php if ($success !== ''): ?>

                    <div class="success-message">
                        <?= htmlspecialchars($success) ?>
                    </div>

                <?php endif; ?>


                <form method="POST" action="tambah_tagihan.php">

                    <div class="form-group">

                        <label for="nama_tagihan">
                            Nama Tagihan
                        </label>

                        <input type="text" id="nama_tagihan" name="nama_tagihan" placeholder="Contoh: Kas November 2026"
                            required>

                    </div>


                    <div class="form-group">

                        <label for="nominal">
                            Nominal
                        </label>

                        <input type="number" id="nominal" name="nominal" placeholder="Contoh: 6000" min="1" required>

                    </div>


                    <div class="form-group">

                        <label for="tanggal_tagihan">
                            Tanggal Tagihan
                        </label>

                        <input type="date" id="tanggal_tagihan" name="tanggal_tagihan" required>

                    </div>


                    <div class="form-group">

                        <label for="jatuh_tempo">
                            Jatuh Tempo
                        </label>

                        <input type="date" id="jatuh_tempo" name="jatuh_tempo" required>

                    </div>


                    <div class="form-actions">

                        <button type="submit" class="btn-primary">
                            Simpan Tagihan
                        </button>

                        <a href="dashboard.php" class="btn-secondary">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </main>

    </div>

</body>

</html>