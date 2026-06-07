<div class="container-fluid">
    <!--  Row 1 -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Section 1</h5>
                        </div>
                        <!-- Tombol Modal Tambah -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            Tambah Data
                        </button>
                    </div>

                    <?php
                    $result = $conn->query("SELECT * FROM section1_admin ORDER BY id DESC");
                    ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Subjudul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= htmlspecialchars($row['subtitle']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit<?= $row['id'] ?>">
                                            Edit
                                        </button>
                                        <a href="?q=delete_section1&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1"
                                    aria-labelledby="modalEditLabel<?= $row['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="post" action="?q=edit_section1">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditLabel<?= $row['id'] ?>">
                                                        Edit Data
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" name="title" class="form-control"
                                                            value="<?= htmlspecialchars($row['title']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Subjudul</label>
                                                        <input type="text" name="subtitle" class="form-control"
                                                            value="<?= htmlspecialchars($row['subtitle']) ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
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
                    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="post" action="?q=add_section1">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Section 1</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Subjudul</label>
                                            <input type="text" name="subtitle" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
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