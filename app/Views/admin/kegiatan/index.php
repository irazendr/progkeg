<?= $this->extend('admin/layout/template'); ?>
<?= $this->Section('style'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?= $this->endSection(); ?>
<?= $this->Section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?= $title; ?></h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('daftar-kegiatan'); ?>">Kegiatan</a></li>
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Kegiatan
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                            <?php if (session('success')) : ?>
                            <div class="swal" data-type="success" data-swal="<?= session('success'); ?>"></div>
                            <?php endif; ?>

                            <?php if (session('error')) : ?>
                            <div class="swal" data-type="error" data-swal="<?= session('error'); ?>"></div>
                            <?php endif; ?>

                            <table class="table table-striped table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Kegiatan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tipe Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Tanggal Input</th>
                                        <th>User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($daftar_kegiatan as $k) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <?= $k->id_keg; ?>
                                        </td>
                                        <td>
                                            <?= $k->nama_kegiatan; ?>
                                        </td>
                                        <td>
                                            <?= $k->tipe; ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($k->tgl_mulai)); ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($k->tgl_selesai)); ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i:s', strtotime($k->tgl_masuk)); ?>
                                        </td>
                                        <td>
                                            <?= $k->user_k; ?>
                                        </td>
                                        <td width="15%" class="text-center">
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#ubahModal<?= $k->id_keg; ?>"><i
                                                    class="fas fa-edit"></i>
                                            </button>
                                            <?php if (in_groups('Admin')) : ?>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="hapus('<?= $k->id_keg; ?>')"><i class="fas fa-trash-alt"></i>
                                            </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Modal Tambah-->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-modal text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Tambah
                        Kegiatan</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('daftar-kegiatan/tambah'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="kode_kegiatan">Kode Kegiatan</label>
                            <input type="text" name="kode_kegiatan" id="kode_kegiatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="tipe_kegiatan"
                                    name="tipe_kegiatan">
                                    <option value="" disabled selected>
                                        --Pilih Tipe Kegiatan--</option>
                                    <?php foreach ($list_tipe as $m) : ?>
                                    <option value="<?= $m->id; ?>">
                                        <?= $m->tipe; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="tipe_kegiatan">Tipe Kegiatan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Pilih Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Pilih Tanggal Selesai:</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        </div>
                        <input type="hidden" id="user" name="user" value="<?= user()->username; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach ($daftar_kegiatan as $l) : ?>
    <!-- Modal Ubah -->
    <div class="modal fade" id="ubahModal<?= $l->id_keg; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-modal text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Ubah Data
                        Kegiatan</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('daftar-kegiatan/ubah/' . $l->id_keg); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                            <label for="kode_kegiatan">Kode Kegiatan</label>
                            <input type="text" name="kode_kegiatan" id="kode_kegiatan" class="form-control"
                                value="<?= $l->id_keg; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control"
                                value="<?= $l->nama_kegiatan; ?>" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="tipe_kegiatan"
                                    name="tipe_kegiatan" disabled>
                                    <?php foreach ($list_tipe as $m) : ?>
                                    <option value="<?= $l->tipe_kegiatan; ?>"
                                        <?php if ($m->id == $l->tipe_kegiatan) : ?>selected<?php endif ?>>
                                        <?= $m->tipe; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="tipe_kegiatan">Tipe Kegiatan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Pilih Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai"
                                value="<?= $l->tgl_mulai; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Pilih Tanggal Selesai:</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai"
                                value="<?= $l->tgl_selesai; ?>">
                        </div>
                        <input type="hidden" id="user" name="user" value="<?= user()->username; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>


    <?= $this->endSection(); ?>
    <?= $this->Section('script'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    $('.swal').each(function() {
        const type = $(this).data('type');
        const message = $(this).data('swal');

        if (type === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: message,
                showConfirmButton: false,
                timer: 1500
            });
        } else if (type === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

    function hapus(kode_kegiatan) {
        Swal.fire({
            title: 'Hapus',
            text: "Anda Yakin Data Kegiatan Akan Dihapus?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked "Hapus" button
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("daftar-kegiatan/hapus"); ?>',
                    data: {
                        _method: 'delete',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        kode_kegiatan: kode_kegiatan
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "<?= base_url('daftar-kegiatan'); ?>"
                                }
                            })
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User clicked "Batal" button
                Swal.fire('Batal', 'Tidak ada data yang dihapus', 'info');
            }
        });

    }
    </script>
    <?= $this->endSection(); ?>