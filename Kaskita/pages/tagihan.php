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

/* Ambil semua tagihan */
$query = "
    SELECT
        id_tagihan,
        nama_tagihan,
        nominal,
        tanggal_tagihan,
        jatuh_tempo,
        status
    FROM tagihan
    ORDER BY id_tagihan DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tagihan | KasKita</title>

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

                <a href="tagihan.php" class="active">
                    <span class="menu-icon">▣</span>
                    <span>Tagihan</span>
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
                    Tagihan
                </h1>

                <p>
                    Kelola tagihan kas mahasiswa kelas 3A
                </p>

            </div>

        </header>


        <div class="content-card">

            <div class="content-header">

                <div>

                    <h2>
                        Daftar Tagihan
                    </h2>

                    <p>
                        Daftar tagihan kas yang telah dibuat.
                    </p>

                </div>


                <div>

                    <a href="tambah_tagihan.php" class="btn-primary">
                        + Tambah Tagihan
                    </a>

                </div>

            </div>


            <div class="payment-table">

                <!-- HEADER -->
                <div class="table-head">

                    <span>
                        Tagihan
                    </span>

                    <span>
                        Nominal
                    </span>

                    <span>
                        Jatuh Tempo
                    </span>

                    <span>
                        Status
                    </span>

                </div>


                <?php if ($result->num_rows > 0): ?>

                    <?php while ($tagihan = $result->fetch_assoc()): ?>

                        <div class="student-payment-row">

                            <div>

                                <strong>
                                    <?= htmlspecialchars($tagihan['nama_tagihan']) ?>
                                </strong>

                                <small>
                                    Dibuat:
                                    <?= date('d M Y', strtotime($tagihan['tanggal_tagihan'])) ?>
                                </small>

                            </div>


                            <div>

                                <strong>
                                    Rp <?= number_format(
                                        $tagihan['nominal'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>
                                </strong>

                            </div>


                            <div>

                                <strong>
                                    <?= date(
                                        'd M Y',
                                        strtotime($tagihan['jatuh_tempo'])
                                    ) ?>
                                </strong>

                            </div>


                            <div>

                                <?php if ($tagihan['status'] === 'aktif'): ?>

                                    <span class="status waiting-status">
                                        Aktif
                                    </span>

                                <?php else: ?>

                                    <span class="status">
                                        Selesai
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="student-payment-row">

                        <div>

                            <strong>
                                Belum ada tagihan
                            </strong>

                            <small>
                                Silakan tambahkan tagihan terlebih dahulu.
                            </small>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </main>

</div>

</body>

</html>