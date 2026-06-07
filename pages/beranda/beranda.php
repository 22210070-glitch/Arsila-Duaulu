<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM section1_admin LIMIT 1");
                $data = mysqli_fetch_assoc($query);
                ?>

                <h1 class="text-white text-center">
                    <?= htmlspecialchars($data['title']) ?>
                </h1>
                <h6 class="text-center">
                    <?= htmlspecialchars($data['subtitle']) ?>
                </h6>
                <div class="container mt-5 filter-section">
                    <div class="card shadow-sm p-4" style="background: rgba(255, 255, 255, 0.9); border-radius: 12px;">
                        <h4 class="mb-4 text-center"><i class="bi bi-sliders"></i> Filter Peta Berdasarkan</h4>
                        <form id="filterForm">
                            <div class="row">
                                <!-- Kecamatan -->
                                <div class="col-md-4 mb-3">
                                    <label for="kecamatanSelect"><strong>Kecamatan</strong></label>
                                    <select class="form-select" id="kecamatanSelect">
                                        <option value="">-- Semua Kecamatan --</option>
                                        <!-- Diisi otomatis dari GeoJSON -->
                                    </select>
                                </div>

                                <!-- Kelurahan -->
                                <div class="col-md-4 mb-3">
                                    <label for="kelurahanSelect"><strong>Kelurahan</strong></label>
                                    <select class="form-select" id="kelurahanSelect">
                                        <option value="">-- Semua Kelurahan --</option>
                                        <!-- Diisi otomatis saat kecamatan berubah -->
                                    </select>
                                </div>

                                <!-- Jenis Zona -->
                                <div class="col-md-4 mb-3">
                                    <label for="zonaSelect"><strong>Jenis Zona</strong></label>
                                    <select class="form-select" id="zonaSelect">
                                        <option value="">-- Semua Zona --</option>
                                        <option value="1">Zona 1</option>
                                        <option value="2">Zona 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="button" id="resetFilter" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>





<section class="featured-section" id="section_2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="custom-block custom-block-overlay">
                    <div class="d-flex flex-column h-100">
                        <div id="cesiumContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <section class="faq-section section-padding" id="section_3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <h2 class="mb-4">Panduan</h2>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-5 col-12">
                <img src="images/faq_graphic.jpg" class="img-fluid" alt="FAQs">
            </div>
            <div class="col-lg-6 col-12 m-auto">
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Bagaimana cara menggunakan peta?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Gunakan tombol zoom in/out dan fitur pan (geser) untuk menjelajahi peta. Klik pada zona
                                tertentu untuk melihat informasi detail nilai tanah dan kategori zonanya.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Bagaimana menyaring data berdasarkan nilai tanah?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Aplikasi menyediakan fitur filter harga yang dapat digunakan untuk menampilkan zona
                                tanah sesuai dengan rentang nilai tertentu. Pilih nilai di dropdown, maka peta akan
                                otomatis menyesuaikan tampilan datanya.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Apakah data peta bisa diunduh?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Ya. Pengguna dapat mengunduh data zona nilai tanah dalam format <code>GeoJSON</code>
                                melalui tombol “Download Peta (GeoJSON)” yang tersedia di halaman peta aplikasi.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section> -->

<?php
// Ambil satu data panduan
$panduan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM panduan ORDER BY created_at DESC LIMIT 1"));
$gambar = !empty($panduan['gambar']) ? $panduan['gambar'] : 'images/default.jpg';

// Ambil semua item panduan terkait
$panduan_id = $panduan['id'];
$items = mysqli_query($conn, "SELECT * FROM panduan_item WHERE panduan_id = '$panduan_id' AND is_active = 1 ORDER BY urutan ASC");

$i = 0; // untuk ID accordion
?>

<section class="faq-section section-padding" id="section_3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <h2 class="mb-4"><?= htmlspecialchars($panduan['judul']) ?></h2>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-5 col-12">
                <img src="admin/<?= $gambar ?>" class="img-fluid" alt="FAQs">
            </div>
            <div class="col-lg-6 col-12 m-auto">
                <div class="accordion" id="accordionExample">
                    <?php while ($row = mysqli_fetch_assoc($items)): ?>
                    <?php
                        $headingId = "heading" . $i;
                        $collapseId = "collapse" . $i;
                        $show = $i === 0 ? 'show' : '';
                        $collapsed = $i === 0 ? '' : 'collapsed';
                        ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?= $headingId ?>">
                            <button class="accordion-button <?= $collapsed ?>" type="button" data-bs-toggle="collapse"
                                data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"
                                aria-controls="<?= $collapseId ?>">
                                <?= htmlspecialchars($row['pertanyaan']) ?>
                            </button>
                        </h2>
                        <div id="<?= $collapseId ?>" class="accordion-collapse collapse <?= $show ?>"
                            aria-labelledby="<?= $headingId ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?= nl2br(htmlspecialchars($row['jawaban'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>



<?php
$section = $conn->query("SELECT * FROM section_keunggulan LIMIT 1")->fetch_assoc();
$keunggulanItems = $conn->query("SELECT * FROM keunggulan_item ORDER BY urutan ASC");
?>

<section class="timeline-section section-padding" id="section_4">
    <div class="section-overlay"></div>
    <div class="container">
        <div class="row">
            <?php if ($section): ?>
            <div class="col-12 text-center">
                <h2 class="text-white mb-4"><?= htmlspecialchars($section['judul']) ?></h2>
            </div>

            <div class="col-lg-10 col-12 mx-auto">
                <div class="timeline-container">
                    <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline">
                        <div class="list-progress">
                            <div class="inner"></div>
                        </div>

                        <?php while ($item = $keunggulanItems->fetch_assoc()): ?>
                        <li>
                            <h4 class="text-white mb-3"><?= htmlspecialchars($item['judul_item']) ?></h4>
                            <p class="text-white"><?= htmlspecialchars($item['deskripsi']) ?></p>
                            <div class="icon-holder">
                                <i class="bi <?= htmlspecialchars($item['ikon']) ?>"></i>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div class="col-12 text-center mt-5">
                <p class="text-white">
                    <?= htmlspecialchars($section['teks_footer']) ?>
                    <?php if (!empty($section['link_footer'])): ?>
                    <a href="<?= htmlspecialchars($section['link_footer']) ?>"
                        class="btn custom-btn custom-border-btn ms-3" target="_blank">
                        Lihat Youtube Kami!
                    </a>
                    <?php endif; ?>
                </p>
            </div>
            <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-white">Data belum tersedia. Silakan isi data pada admin panel terlebih dahulu.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>