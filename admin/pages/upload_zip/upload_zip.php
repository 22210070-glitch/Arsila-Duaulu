<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">

                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                        <h5 class="card-title fw-semibold">Upload Peta Zona Nilai Tanah</h5>
                    </div>

                    <form action="?q=add_upload_zip" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Data</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File Shapefile (.zip)</label>
                            <input type="file" class="form-control" name="shapefile_zip" accept=".zip" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Upload dan Tampilkan</button>
                    </form>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Nama File</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $result = $conn->query("SELECT * FROM shp_upload ORDER BY uploaded_at DESC");
                                while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['judul']) ?></td>
                                    <td><?= htmlspecialchars($row['file_name']) ?></td>
                                    <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
                                    <td>
                                        <a href="?q=delete_upload_zip&id=<?= $row['id'] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus file ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>