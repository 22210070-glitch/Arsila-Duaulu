<?php
include 'conf/conf.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Silaww</title>

    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon">
    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
        rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="css/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="css/templatemo-topic-listing1.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/fontawesome/css/all.min.css">


    <!-- CesiumJS -->
    <link rel="stylesheet" href="https://cesium.com/downloads/cesiumjs/releases/1.98/Build/Cesium/Widgets/widgets.css">
</head>

<body id="top">

    <main>

        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="./">
                    <img src="images/silalogofix.png" alt="Logo" style="height: 50px;" class="me-2">
                </a>

                <!-- Toggle (untuk mobile) -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu dan Login di Kanan -->
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav d-flex align-items-center">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_1">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_2">Peta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_3">Panduan</a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="#" class="fa-solid fa-user smoothscroll" data-bs-toggle="modal"
                                data-bs-target="#loginModal"></a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>


        <?php
        include 'link.php';
        ?>

    </main>

    <!-- Modal Login & Register -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="auth-container">

                        <!-- FORM LOGIN -->
                        <div class="auth-left" id="loginFormBox">
                            <h3 class="fw-bold mb-5">Sign in</h3>
                            <form action="proses_login" method="POST">
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <a href="#" class="mb-3 d-block">Lupa kata sandi anda?</a>
                                <button type="submit">Sign In</button>
                            </form>
                        </div>

                        <!-- FORM REGISTER -->
                        <div class="auth-left d-none" id="registerFormBox">
                            <h3 class="fw-bold mb-5">Sign up</h3>
                            <form action="proses_register" method="POST">
                                <input type="text" name="name" placeholder="Nama Lengkap" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <input type="password" name="confirm_password" placeholder="Konfirmasi Password"
                                    required>
                                <button type="submit">Sign Up</button>
                            </form>
                        </div>

                        <!-- KANAN: CTA -->
                        <div class="auth-right" id="authRightBox">
                            <h2 id="authTitle">Halo, Teman!</h2>
                            <p id="authText">Daftarkan diri anda dan mulai gunakan layanan kami segera</p>
                            <a href="javascript:void(0)" class="btn-outline" id="toggleAuthBtn">Sign Up</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    const loginFormBox = document.getElementById('loginFormBox');
    const registerFormBox = document.getElementById('registerFormBox');
    const toggleAuthBtn = document.getElementById('toggleAuthBtn');
    const authTitle = document.getElementById('authTitle');
    const authText = document.getElementById('authText');

    let isRegister = false;

    toggleAuthBtn.addEventListener('click', function() {
        if (!isRegister) {
            loginFormBox.classList.add('d-none');
            registerFormBox.classList.remove('d-none');

            authTitle.innerText = 'Selamat Datang Kembali!';
            authText.innerText = 'Sudah punya akun? Silakan masuk untuk melanjutkan.';
            toggleAuthBtn.innerText = 'Sign In';

            isRegister = true;
        } else {
            registerFormBox.classList.add('d-none');
            loginFormBox.classList.remove('d-none');

            authTitle.innerText = 'Halo, Teman!';
            authText.innerText = 'Daftarkan diri anda dan mulai gunakan layanan kami segera';
            toggleAuthBtn.innerText = 'Sign Up';

            isRegister = false;
        }
    });
    </script>

    <!-- JavaScript untuk Toggle Form -->
    <!-- <script>
        function toggleForm() {
            var loginForm = document.getElementById("loginForm");
            var registerForm = document.getElementById("registerForm");
            var modalTitle = document.getElementById("modalTitle");
            var toggleText = document.getElementById("toggleText");

            if (loginForm.style.display === "none") {
                // Pindah ke Login
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                modalTitle.innerHTML = "Welcome Back!";
                toggleText.innerHTML =
                    `Don't have an account? <a href="#" class="text-primary" onclick="toggleForm()">Register now</a>`;
            } else {
                // Pindah ke Register
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                modalTitle.innerHTML = "Create an Account!";
                toggleText.innerHTML =
                    `Already have an account? <a href="#" class="text-primary" onclick="toggleForm()">Sign In</a>`;
            }
        }
    </script> -->

    <footer class="site-footer section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-12 mb-4 pb-2">
                    <a class="navbar-brand mb-2" href="">
                        <img src="images/silalogofix.png" alt="Logo" style="height: 50px;" class="me-2">
                    </a>
                </div>

                <div class="col-lg-3 col-md-4 col-6">
                    <h6 class="site-footer-title mb-3">Resources</h6>

                    <ul class="site-footer-links">
                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">Home</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">How it works</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">FAQs</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                    <h6 class="site-footer-title mb-3">Information</h6>
                    <p class="text-white d-flex mb-1">
                        <a href="tel: 305-240-9671" class="site-footer-link">
                            305-240-9671
                        </a>
                    </p>
                    <p class="text-white d-flex">
                        <a href="mailto:info@company.com" class="site-footer-link">
                            info@company.com
                        </a>
                    </p>
                </div>
                <div class="col-lg-3 col-md-4 col-12 mt-lg-0 ms-auto">
                    <p class="copyright-text">Copyright © 2025, All rights reserved.
                        <br><br>Design By <a rel="nofollow" href="#" target="_blank">Silaww</a>
                        <a href="#"></a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <style>
    #cesiumContainer {
        width: 100%;
        height: 500px;
    }
    </style>

    <script src="https://cesium.com/downloads/cesiumjs/releases/1.99/Build/Cesium/Cesium.js"></script>

    <script>
    Cesium.Ion.defaultAccessToken =
        'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIwYzFjZmYyMi03ZTIxLTQxYzMtYjViNy1jNjYzZWNjOWEwY2IiLCJpZCI6Mjg0NDY2LCJpYXQiOjE3NDIxMDExNDB9.PPTGMOjuwsAi53j9xqoplVAjIPtsJ3ELIJyjWsBDPg0';

    const viewer = new Cesium.Viewer('cesiumContainer', {
        terrainProvider: new Cesium.EllipsoidTerrainProvider(),
        timeline: false,
        animation: false,
        baseLayerPicker: false,
        selectionIndicator: true,
        infoBox: true,
        navigationHelpButton: false,
        homeButton: true,
        sceneModePicker: true,
        fullscreenButton: true,
        geocoder: false
    });

    viewer.scene.screenSpaceCameraController.enableZoom = true;
    viewer.scene.screenSpaceCameraController.enableWheelZoom = true;
    viewer.scene.screenSpaceCameraController.enableInputs = true;

    const center = Cesium.Cartesian3.fromDegrees(124.8189, 1.3127, 5000);
    viewer.camera.flyTo({
        destination: center,
        duration: 3
    });

    let allEntities = [];
    const kelurahanMap = {};
    const kecamatanSet = new Set();

    fetch('get_all_geojson.php')
        .then(response => response.json())
        .then(paths => {
            return Promise.all(paths.map(path =>
                Cesium.GeoJsonDataSource.load(path, {
                    clampToGround: true
                }).then(ds => {
                    viewer.dataSources.add(ds);

                    viewer.flyTo(ds, {
                        duration: 2
                    });

                    ds.entities.values.forEach(entity => {
                        const props = entity.properties;
                        const kec = props?.KECAMATAN?._value || '';
                        const kel = props?.KELURAHAN?._value || '';

                        // Warna berdasarkan cluster hasil K-Means
                        let fillColor = Cesium.Color.GRAY.withAlpha(0.4);

                        if (props?.cluster) {
                            const clusterId = props.cluster._value.toString().trim();

                            if (clusterId === '0') {
                                fillColor = Cesium.Color.BLUE.withAlpha(0.6);
                            } else if (clusterId === '1') {
                                fillColor = Cesium.Color.RED.withAlpha(0.6);
                            } else if (clusterId === '2') {
                                fillColor = Cesium.Color.GREEN.withAlpha(0.6);
                            } else if (clusterId === '3') {
                                fillColor = Cesium.Color.YELLOW.withAlpha(0.6);
                            }
                        }

                        entity.originalColor = fillColor;

                        if (Cesium.defined(entity.polygon)) {
                            entity.polygon.material = fillColor;
                            entity.polygon.outline = true;
                            entity.polygon.outlineColor = Cesium.Color.BLACK;
                        }

                        let html = `<strong>Detail Zona:</strong><br>`;
                        props?.propertyNames.forEach(key => {
                            html += `<b>${key}</b>: ${props[key]._value}<br>`;
                        });
                        entity.description = html;

                        allEntities.push(entity);

                        if (kec && kel) {
                            kecamatanSet.add(kec);
                            if (!kelurahanMap[kec]) kelurahanMap[kec] = new Set();
                            kelurahanMap[kec].add(kel);
                        }
                    });
                })
            ));
        })
        .then(() => {
            const kecamatanSelect = document.getElementById('kecamatanSelect');
            kecamatanSelect.innerHTML = `<option value="">-- Semua Kecamatan --</option>`;
            kecamatanSet.forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec;
                opt.textContent = kec.replace('KECAMATAN ', '');
                kecamatanSelect.appendChild(opt);
            });

            updateKelurahanDropdown();
            applyFilter();
        });

    document.getElementById('kecamatanSelect')?.addEventListener('change', () => {
        updateKelurahanDropdown();
        applyFilter();
    });

    document.getElementById('kelurahanSelect')?.addEventListener('change', applyFilter);
    document.getElementById('zonaSelect')?.addEventListener('change', applyFilter);

    document.getElementById('resetFilter')?.addEventListener('click', () => {
        document.getElementById('kecamatanSelect').value = '';
        document.getElementById('zonaSelect').value = '';
        updateKelurahanDropdown();
        applyFilter();
    });

    function updateKelurahanDropdown() {
        const selectedKecamatan = document.getElementById('kecamatanSelect').value;
        const kelSelect = document.getElementById('kelurahanSelect');
        kelSelect.innerHTML = `<option value="">-- Semua Kelurahan --</option>`;

        let kelList = new Set();

        if (selectedKecamatan && kelurahanMap[selectedKecamatan]) {
            kelList = kelurahanMap[selectedKecamatan];
        } else {
            Object.values(kelurahanMap).forEach(set => set.forEach(k => kelList.add(k)));
        }

        kelList.forEach(kel => {
            const opt = document.createElement('option');
            opt.value = kel;
            opt.textContent = kel.replace('KELURAHAN ', '');
            kelSelect.appendChild(opt);
        });
    }

    function applyFilter() {
        const kec = document.getElementById('kecamatanSelect').value;
        const kel = document.getElementById('kelurahanSelect').value;
        const zona = document.getElementById('zonaSelect').value;

        allEntities.forEach(entity => {
            const p = entity.properties;
            const show =
                (!kec || p.KECAMATAN?._value === kec) &&
                (!kel || p.KELURAHAN?._value === kel) &&
                (!zona || p.cluster?._value.toString() === zona);

            entity.show = show;

            if (Cesium.defined(entity.polygon) && entity.originalColor) {
                entity.polygon.material = entity.originalColor;
            }
        });
    }
    </script>



    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>


    <style>
    .auth-container {
        display: flex;
        min-height: 500px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .auth-left,
    .auth-right {
        flex: 1;
        padding: 40px;
    }

    .auth-left {
        background-color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    .auth-left .social-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .auth-left .social-buttons button {
        border: 1px solid #ccc;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        background: none;
        font-size: 16px;
    }

    .auth-left input {
        border: none;
        background-color: #f0f0f0;
        border-radius: 5px;
        padding: 12px;
        width: 100%;
        margin-bottom: 15px;
    }

    .auth-left button[type="submit"] {
        background-color: #00b894;
        border: none;
        color: #fff;
        padding: 12px;
        width: 100%;
        border-radius: 30px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .auth-left a {
        font-size: 14px;
        color: #444;
        text-decoration: none;
        margin-top: 8px;
        display: inline-block;
    }

    .auth-right {
        background: linear-gradient(to bottom right, rgb(0, 218, 174), rgb(189, 255, 254));
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .auth-right h2 {
        font-weight: bold;
        margin-bottom: 15px;
    }

    .auth-right p {
        margin-bottom: 25px;
        max-width: 300px;
    }

    .auth-right .btn-outline {
        background: none;
        border: 2px solid white;
        color: white;
        padding: 10px 30px;
        border-radius: 25px;
        font-weight: bold;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .auth-container {
            flex-direction: column;
        }

        .auth-left,
        .auth-right {
            padding: 30px 20px;
        }
    }
    </style>


</body>

</html>