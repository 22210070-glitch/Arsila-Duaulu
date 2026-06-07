<?php
$section = $conn->query("SELECT * FROM section_keunggulan LIMIT 1")->fetch_assoc();
$resultKeunggulan = $conn->query("SELECT * FROM keunggulan_item WHERE section_id = {$section['id']} ORDER BY urutan ASC");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">

                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                        <h5 class="card-title fw-semibold">Data Keunggulan</h5>
                        <div>
                            <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#modalEditSection">Edit Section</button>
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalTambahKeunggulan">Tambah Keunggulan</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Ikon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($item = $resultKeunggulan->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($item['judul_item']) ?></td>
                                    <td><?= htmlspecialchars($item['deskripsi']) ?></td>
                                    <td><i class="bi <?= htmlspecialchars($item['ikon']) ?>"></i> <?= $item['ikon'] ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit<?= $item['id'] ?>">Edit</button>
                                        <a href="?q=delete_section3&id=<?= $item['id'] ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal Edit Item -->
                                <div class="modal fade" id="modalEdit<?= $item['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="post" action="?q=edit_section3">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Keunggulan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" name="judul_item" class="form-control"
                                                            value="<?= $item['judul_item'] ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Deskripsi</label>
                                                        <textarea name="deskripsi" class="form-control"
                                                            required><?= $item['deskripsi'] ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Ikon</label>
                                                        <input type="text" name="ikon" class="form-control"
                                                            value="<?= $item['ikon'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Tambah Keunggulan -->
                    <div class="modal fade" id="modalTambahKeunggulan" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="post" action="?q=add_section3">
                                <input type="hidden" name="section_id" value="<?= $section['id'] ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Keunggulan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <input type="text" name="judul_item" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Deskripsi</label>
                                            <textarea name="deskripsi" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Ikon</label>
                                            <input type="text" name="ikon" class="form-control"
                                                placeholder="Contoh: bi-check-circle" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Edit Section Judul -->
                    <div class="modal fade" id="modalEditSection" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="post" action="?q=edit_section3">
                                <input type="hidden" name="section_id" value="<?= $section['id'] ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Section</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Judul Section</label>
                                            <input type="text" name="judul" class="form-control"
                                                value="<?= $section['judul'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Teks Footer</label>
                                            <input type="text" name="teks_footer" class="form-control"
                                                value="<?= $section['teks_footer'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label>Link Footer (YouTube)</label>
                                            <input type="text" name="link_footer" class="form-control"
                                                value="<?= $section['link_footer'] ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>