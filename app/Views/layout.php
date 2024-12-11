<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title><?= $title ?? 'TOPSIS Dashboard' ?></title>
    <style>
        body {
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            z-index: 1040;
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar .nav-link {
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }

        /* Content Styling */
        .content {
            margin-left: 250px;
            margin-top: 70px;
            transition: margin-left 0.3s ease;
        }

        .content.shifted {
            margin-left: 0;
        }

        /* Profile styling */
        .profile-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-section img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-bottom: 10px;
        }

        /* Close Button Styling */
        .sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- Hamburger Button (Only visible on mobile) -->
            <button class="btn btn-dark me-3" id="sidebarToggle">
                ☰
            </button>
            <a class="navbar-brand" href="#">TOPSIS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() === site_url('home') ? 'active' : '' ?>" href="<?= site_url('home') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() === site_url('profile') ? 'active' : '' ?>" href="<?= site_url('profile') ?>">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() === site_url('contact') ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="close-btn" id="sidebarClose">×</button>
        <div class="p-4">
            <!-- Profile Section -->
            <div class="profile-section">
                <img src="https://picsum.photos/200/300" alt="Profile Image">
                <h5>Husnul Khatimah</h5>
                <p>220605110169</p>
            </div>

            <!-- Menu -->
            <h4 class="text-center">Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('/') ? 'active' : '' ?>" href="<?= site_url('/') ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/alternatif') ? 'active' : '' ?>" href="<?= site_url('topsis/alternatif') ?>">Data Alternatif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/kriteria') ? 'active' : '' ?>" href="<?= site_url('topsis/kriteria') ?>">Data Kriteria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/matriks_keputusan') ? 'active' : '' ?>" href="<?= site_url('topsis/matriks_keputusan') ?>">Matriks Keputusan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/normalisasi') ? 'active' : '' ?>" href="<?= site_url('topsis/normalisasi') ?>">Hasil Normalisasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/normalisasi_terbobot') ? 'active' : '' ?>" href="<?= site_url('topsis/normalisasi_terbobot') ?>">Hasil Normalisasi Terbobot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/jarak_ideal') ? 'active' : '' ?>" href="<?= site_url('topsis/jarak_ideal') ?>">Hasil Nilai Ideal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() === site_url('topsis/hasil_preferensi_ranking') ? 'active' : '' ?>" href="<?= site_url('topsis/hasil_preferensi_ranking') ?>">Hasil Nilai Preferensi dan Rank</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <?= $this->renderSection('content') ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const toggleBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarClose');

            // Fungsi untuk membuka sidebar
            function openSidebar() {
                sidebar.classList.remove('hidden');
                content.classList.remove('shifted');
            }

            // Fungsi untuk menutup sidebar
            function closeSidebar() {
                sidebar.classList.add('hidden');
                content.classList.add('shifted');
            }

            // Event listener tombol hamburger
            toggleBtn.addEventListener('click', openSidebar);

            // Event listener tombol close
            closeBtn.addEventListener('click', closeSidebar);
        });
    </script>
</body>

</html>
