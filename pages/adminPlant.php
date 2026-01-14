<?php
include '../database/koneksi.php';
$page_css = 'adminPlants.css';
include 'layout/headerAdmin.php';

$sqlT = "SELECT tanaman.*, kategori.nama_kategori 
        FROM tanaman
        JOIN kategori ON tanaman.kategori_id = kategori.id";
$resultT = $koneksi->query($sqlT);

$sqlK = "SELECT * FROM kategori";
$resultK = $koneksi->query($sqlK);
?>

<section>
    <div class="area-data-Tanaman">
        <h2 class="title-page-Tanaman">Page Tanaman</h2>
        <div class="header-data-Tanaman">
            <div class="button-input-tan" data-bs-toggle="modal" data-bs-target="#exampleModalInputTanaman">
                <p>Tambah Tanaman</p>
            </div>

            <div class="modal fade" id="exampleModalInputTanaman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Input Tanaman</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../functions/tambahPlant.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body d-flex gap-4 flex-wrap">
                                <?php if (isset($_SESSION['errorTanaman'])): ?>
                                    <div class="notifAlert">
                                        <p class="textNotif"><?= ($_SESSION['errorTanaman']) ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="area-input-kiri">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Kategori Tanaman :</label>
                                        <select class="form-select" name="kategori_id" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach ($resultK as $row): ?>
                                                <option value="<?= $row['id'] ?>">
                                                    <?= $row['nama_kategori'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Nama Tanaman :</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukan kategori" name="nama_tanaman">
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Foto Tanaman :</label>
                                        <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="Masukan kategori" name="foto">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Asal & Penemuan Tanaman :</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukan kategori" name="asal_tanaman">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Musim :</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukan kategori" name="musim">
                                    </div>
                                </div>
                                <div class="area-input-kanan">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Deskripsi :</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Harga Tanaman :</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Rp. " name="harga">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Stok :</label>
                                        <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Stok" name="stok">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Status :</label>
                                        <select class="form-select" name="status" required>
                                            <option value="" disabled selected>-- Pilih Status --</option>
                                            <option value="tersedia">Tersedia</option>
                                            <option value="sedang_restok">Sedang Restok</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="button-input-tan-save">Save changes</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="area-tabel-tanaman table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Nama Tanaman</th>
                        <th>Asal & Penemuan</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Musim</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultT->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                            <td><?= htmlspecialchars($row['nama_tanaman']) ?></td>
                            <td><?= htmlspecialchars($row['asal_tanaman']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi_tanaman']) ?></td>
                            <td><?= htmlspecialchars($row['harga']) ?></td>
                            <td><?= htmlspecialchars($row['stok']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['musim']) ?></td>
                            <td><img style="width: 70px; height: 70px;" src="../uploads/<?= $row['foto'] ?>" alt="" srcset=""></td>
                            <td class="d-flex align-items-center gap-2 w-auto">
                                <!-- <a href="edit.php?id=" class="btn btn-warning btn-sm">Edit</a> -->
                                <button type="button" class="btn btn-warning btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#modalEditPlant<?= $row['id'] ?>">
                                    Edit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalEditPlant<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg ">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Data Tanaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="../functions/editPlant.php" method="post" enctype="multipart/form-data">
                                                <div class="modal-body d-flex gap-4">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="area-input-kiri">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kategori Tanaman :</label>
                                                            <select class="form-select" name="kategori_id" required>
                                                                <option value="">-- Pilih Kategori --</option>
                                                                <?php foreach ($resultK as $kat): ?>
                                                                    <option value="<?= $kat['id'] ?>"
                                                                        <?= ($kat['id'] == $row['kategori_id']) ? 'selected' : '' ?>>
                                                                        <?= $kat['nama_kategori'] ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Tanaman :</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="nama_tanaman"
                                                                value="<?= $row['nama_tanaman'] ?>"
                                                                required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Foto Tanaman :</label>
                                                            <input type="file" class="form-control" name="foto">
                                                            <small class="text-muted">
                                                                Kosongkan jika tidak ingin mengganti foto
                                                            </small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Asal & Penemuan Tanaman :</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="asal_tanaman"
                                                                value="<?= $row['asal_tanaman'] ?>"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Musim :</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="musim"
                                                                value="<?= $row['musim'] ?>"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="area-input-kanan">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Harga Tanaman :</label>
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Rp. " value="<?= $row['harga'] ?>" name="harga">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Stok :</label>
                                                            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Stok" value="<?= $row['stok'] ?>" name="stok">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Status :</label>
                                                            <select class="form-select" name="status" required>
                                                                <option value="tersedia" <?= $row['status'] == 'tersedia' ? 'selected' : '' ?>>
                                                                    Tersedia
                                                                </option>
                                                                <option value="sedang_restok" <?= $row['status'] == 'sedang_restok' ? 'selected' : '' ?>>
                                                                    Sedang Restok
                                                                </option>
                                                            </select>

                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi :</label>
                                                            <textarea
                                                                class="form-control"
                                                                rows="3"
                                                                name="deskripsi"
                                                                required><?= $row['deskripsi_tanaman'] ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="button-input-tan-save">
                                                        Update
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>


                                <!-- <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a> -->
                                <button type="button" class="btn btn-danger btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?= $row['id'] ?>">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalDelete<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog w-25 modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Yakin Mau Hapus Data?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="../functions/hapusPlant.php" method="POST">
                                                <input type="hidden" name="idp" value="<?= $row['id'] ?>">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                    <button type="sumbit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php if (isset($_SESSION['errorTanaman']) && empty($_SESSION['just_logged_out'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('exampleModalInputTanaman'));
            modal.show();
        });
    </script>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('exampleModalInputTanaman');
        if (!modalEl) return;

        modalEl.addEventListener('hidden.bs.modal', function() {
            fetch('../functions/clear-error.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).catch(err => {
                console.error('Failed to clear session error:', err);
            });
        });
    });
</script>
<?php include 'layout/footer.php'; ?>