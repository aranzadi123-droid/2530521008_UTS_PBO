<?php
session_start();

require_once 'config/Database.php';

$db = new Database();
$conn = $db->connect();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '') {

        $error = 'Username wajib diisi.';

    } else {

        $stmt = $conn->prepare("
            SELECT id_user, username, password, role, nama
            FROM users
            WHERE username = ?
        ");

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            /*
            |--------------------------------------------------------------------------
            | MAHASISWA BELUM MEMBUAT PASSWORD
            |--------------------------------------------------------------------------
            */

            if (
                $user['role'] === 'mahasiswa' &&
                is_null($user['password'])
            ) {

                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['nama'];
                $_SESSION['role'] = 'mahasiswa';

                header('Location: pages/buat_password.php');
                exit;
            }

            /*
            |--------------------------------------------------------------------------
            | LOGIN BIASA
            |--------------------------------------------------------------------------
            */

            if ($password === '') {

                $error = 'Password wajib diisi.';

            } elseif ($password === $user['password']) {

                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['nama'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'bendahara') {

                    header('Location: pages/dashboard.php');
                    exit;

                } elseif ($user['role'] === 'mahasiswa') {

                    header('Location: pages/dashboard_mahasiswa.php');
                    exit;
                }

            } else {

                $error = 'Username atau password salah.';
            }

        } else {

            $error = 'Username atau password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | KasKita</title>

    <link rel="stylesheet" href="/kaskita/assets/css/style.css">

</head>

<body>

    <div class="login-page">

        <div class="login-card">

            <div class="login-header">

                <div class="brand-icon">
                    K
                </div>

                <h1>
                    KasKita
                </h1>

                <p>
                    Sistem Informasi Kas Mahasiswa
                </p>

            </div>


            <?php if ($error !== ''): ?>

                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>


            <form method="POST" action="index.php">

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input type="password" id="password" name="password" placeholder="Masukkan password">

                </div>


                <button type="submit" class="btn-login">
                    Masuk
                </button>

            </form>


            <div class="login-footer">

                <p>
                    © 2026 KasKita
                </p>

            </div>

        </div>

    </div>

</body>

</html>