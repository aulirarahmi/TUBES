<?php
session_start();
include 'includes/db.php';

// Periksa apakah pengguna sudah login, jika belum, arahkan ke halaman login
$isLoggedIn = isset($_SESSION['user_id']);

// Sekarang Anda dapat mengakses data pengguna dari session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = null; // Atur nilai default jika session belum ada
}

// Pastikan tipe rambu diterima sebagai parameter GET
if (isset($_GET['tipe'])) {
    $tipe_rambu = $_GET['tipe'];

    // Query untuk mengambil data dari database
    $stmt = $pdo->prepare("SELECT * FROM rambu WHERE tipe_rambu = :tipe");
    $stmt->bindParam(':tipe', $tipe_rambu);
    $stmt->execute();
    $rambu_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} else {
    die("Tipe rambu tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rambu <?= htmlspecialchars($tipe_rambu); ?></title>
    <link rel="stylesheet" href="css/learning.css">
</head>
<body>
    <main>
            <!-- Navbar -->
        <div class="header">
        <div class="logo">
            <a href="index.php">
            <img src="images/CTK LOGO black.png" alt="Logo Traffic Knowledge">
        </div>
      <!-- Menu navigasi -->
     <div class="nav-menu">
    <div class="dropdown">
        <a href="#learning" class="dropdown-toggle">Learning</a>
        <div class="dropdown-menu">
            <a href="rambu.php?tipe=peringatan">Rambu Peringatan</a>
            <a href="rambu.php?tipe=larangan">Rambu Larangan</a>
            <a href="rambu.php?tipe=petunjuk">Rambu Petunjuk</a>
            <a href="rambu.php?tipe=perintah">Rambu Perintah</a>
        </div>
    </div>
    <a href="quiz.php" class="button">Quiz</a>
    <a href="#about" class="button">About us</a>
</div>
        <!-- Tombol autentikasi -->
        <?php if ($isLoggedIn): ?>
                <!-- Tampilkan foto profil jika sudah login -->
                <img src="images/profile.jpg" alt="Foto Profil" class="profile-photo">
                <div class="user-logout">
                <a href="logout.php" class="button">Logout</a>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                <a href="login/login.php">Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <section class="grid-container">
    <?php foreach ($rambu_data as $rambu): ?>
    <div class="rambu-item">
        <h2><?= htmlspecialchars($rambu['nama_rambu']); ?></h2>
        <img src="images/<?= htmlspecialchars($rambu['image']); ?>" alt="<?= htmlspecialchars($rambu['nama_rambu']); ?>">
        <p><?= htmlspecialchars($rambu['deskripsi']); ?></p>
    </div>
    <?php endforeach; ?>
</section>

    <footer>
        <p>Created by @PSIII PABW B</p>
    </footer>
    </main>
</body>
</html>
