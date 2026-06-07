<?php
include '../conf/conf.php';
include 'kmeans_helper.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silaww | Admin</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/fav.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="index.html" class="text-nowrap logo-img">
                        <img src="assets/images/silalogofix.png" width="220" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= (isset($_GET['q']) && $_GET['q'] == 'beranda') ? 'active' : ''; ?>"
                                href="?q=beranda" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">UI COMPONENTS</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link <?= (isset($_GET['q']) && $_GET['q'] == 'section1') ? 'active' : ''; ?>"
                                href="?q=section1" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                                <span class="hide-menu">Section 1</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link <?= (isset($_GET['q']) && $_GET['q'] == 'section2') ? 'active' : ''; ?>"
                                href="?q=section2" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-filter"></i>
                                </span>
                                <span class="hide-menu">Section 2</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link <?= (isset($_GET['q']) && $_GET['q'] == 'section3') ? 'active' : ''; ?>"
                                href="?q=section3" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-pen"></i>
                                </span>
                                <span class="hide-menu">Section 3</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link <?= (isset($_GET['q']) && $_GET['q'] == 'upload_zip') ? 'active' : ''; ?>"
                                href="?q=upload_zip" aria-expanded="false">
                                <span>
                                    <i class="fa-solid fa-file-arrow-up"></i>
                                </span>
                                <span class="hide-menu">Upload ZIP</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <span id="clock" style="font-weight: bold;"></span>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                                        class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->

            <?php
            include 'link_admin.php';
            ?>
            <div class="py-6 px-6 text-center">
                <p class="mb-0 fs-4">Design and Developed by <a href="#" target="_blank"
                        class="pe-1 text-primary text-decoration-underline">Silaww</a></p>
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="assets/js/dashboard.js"></script>

    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            document.getElementById('clock').textContent = timeString;
        }

        setInterval(updateClock, 1000); // update setiap detik
        updateClock(); // update awal saat halaman dimuat
    </script>

</body>

</html>