<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">

                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                        <h5 class="card-title fw-semibold">Data Panduan</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPanduan">Tambah Panduan</button>
                    </div>

                    <?php $resultPanduan = $conn->query("SELECT * FROM panduan ORDER BY id DESC"); ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Gambar</th>
                                    <th>FAQ</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($panduan = $resultPanduan->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($panduan['judul']) ?></td>
                                    <td><img src="<?= $panduan['gambar'] ?>" width="100"></td>
                                    <td>
                                        <?php
                                            $faqList = $conn->query("SELECT * FROM panduan_item WHERE panduan_id = {$panduan['id']} ORDER BY urutan ASC");
                                            if ($faqList->num_rows > 0):
                                                while ($faq = $faqList->fetch_assoc()):
                                            ?>
                                        <strong><?= htmlspecialchars($faq['pertanyaan']) ?></strong><br>
                                        <?= nl2br(htmlspecialchars($faq['jawaban'])) ?>
                                        <hr>
                                        <?php endwhile;
                                            else: ?>
                                        <em>Belum ada FAQ</em>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit<?= $panduan['id'] ?>">Edit</button>
                                        <a href="?q=delete_section2&id=<?= $panduan['id'] ?>"
                                            onclick="return confirm('Hapus data ini?')"
                                            class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit<?= $panduan['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <form method="post" action="?q=edit_section2" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $panduan['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Panduan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" name="judul" class="form-control"
                                                            value="<?= htmlspecialchars($panduan['judul']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Gambar Sekarang</label><br>
                                                        <img src="<?= $panduan['gambar'] ?>" width="150">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Ganti Gambar (opsional)</label>
                                                        <input type="file" name="gambar" class="form-control"
                                                            accept="image/*">
                                                    </div>

                                                    <hr>
                                                    <?php
                                                        $faqs = $conn->query("SELECT * FROM panduan_item WHERE panduan_id = {$panduan['id']}");
                                                        while ($f = $faqs->fetch_assoc()):
                                                        ?>
                                                    <input type="hidden" name="faq_id_existing[]"
                                                        value="<?= $f['id'] ?>">
                                                    <div class="mb-2 border p-2">
                                                        <label>Pertanyaan</label>
                                                        <input type="text" name="faq_pertanyaan_existing[]"
                                                            class="form-control"
                                                            value="<?= htmlspecialchars($f['pertanyaan']) ?>" required>
                                                        <label>Jawaban</label>
                                                        <textarea name="faq_jawaban_existing[]" class="form-control"
                                                            required><?= htmlspecialchars($f['jawaban']) ?></textarea>
                                                    </div>
                                                    <?php endwhile; ?>

                                                    <hr>
                                                    <h6>FAQ Baru</h6>
                                                    <div id="faqBaru<?= $panduan['id'] ?>"></div>
                                                    <button type="button"
                                                        class="btn btn-info btn-sm mb-2 btn-tambah-faq"
                                                        data-target="faqBaru<?= $panduan['id'] ?>">+ FAQ Baru</button>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="modalTambahPanduan" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <form method="post" action="?q=add_section2" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Panduan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <input type="text" name="judul" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Upload Gambar</label>
                                            <input type="file" name="gambar" class="form-control" accept="image/*"
                                                required>
                                        </div>
                                        <hr>
                                        <h6>FAQ</h6>
                                        <div id="faqWrapper"></div>
                                        <button type="button" class="btn btn-info btn-sm"
                                            onclick="tambahFaqBaru('faqWrapper')">+ Tambah FAQ</button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                    function tambahFaqBaru(targetId) {
                        const el = document.getElementById(targetId);
                        if (!el) {
                            console.error('Target FAQ tidak ditemukan:', targetId);
                            return;
                        }
                        const html = `
                        <div class="border p-2 mb-2">
                            <label>Pertanyaan</label>
                            <input type="text" name="faq_pertanyaan_baru[]" class="form-control" required>
                            <label>Jawaban</label>
                            <textarea name="faq_jawaban_baru[]" class="form-control" required></textarea>
                        </div>`;
                        el.insertAdjacentHTML('beforeend', html);
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>