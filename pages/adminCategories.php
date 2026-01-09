<?php
include '../database/koneksi.php';
$page_css = 'adminCategories.css';
include 'layout/headerAdmin.php';

$sql = "SELECT * FROM kategori";
$result = $koneksi->query($sql);
?>

<section>
    <div class="area-data-kategori">
        <h2 class="title-page-kategori" >Page Kategori</h2>
        <div class="header-data-kategori">
            <div class="button-input-kat" data-bs-toggle="modal" data-bs-target="#exampleModalInputKategori">
                <p>Tambah Kategori</p>
            </div>

            <div class="modal fade" id="exampleModalInputKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Input Kategori Tanaman</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../functions/tambahKategori.php" method="post">
                                <?php if (isset($_SESSION['errorKategori'])): ?>
                                    <div class="notifAlert">
                                        <p class="textNotif"><?= ($_SESSION['errorKategori']) ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Nama Kategori Tanaman :</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukan kategori" name="nama_kategori">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Deskripsi :</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi"></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="button-input-kat">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="area-tabel-kategori">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td class="d-flex align-items-center gap-2 w-auto">
                                <!-- <a href="edit.php?id=" class="btn btn-warning btn-sm">Edit</a> -->
                                <button type="button" class="btn btn-warning btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalEdit<?= $row['id'] ?>">
                                    Edit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalEdit<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="../functions/editKategori.php">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Kategori :</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="nama_kategori"
                                                            id="nama_kategori<?= $row['id'] ?>"
                                                            value="<?= $row['nama_kategori'] ?>"
                                                            required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Deskripsi :</label>
                                                        <textarea
                                                            type="email"
                                                            class="form-control"
                                                            name="deskripsi"
                                                            id="deskripsi<?= $row['id'] ?>"
                                                            required rows="4"><?= $row['deskripsi'] ?></textarea>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning ">Simpan</button>
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
                                            <form action="../functions/hapusKategori.php" method="POST">
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
<?php if (isset($_SESSION['errorKategori']) && empty($_SESSION['just_logged_out'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('exampleModalInputKategori'));
            modal.show();
        });
    </script>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('exampleModalInputKategori');
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