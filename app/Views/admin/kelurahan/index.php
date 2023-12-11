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
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Daftar Kelurahan
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal"
                        data-bs-target="#tambahModal">
                        <i class="fas fa-plus"></i> Tambah
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm mb-2" data-bs-toggle="modal"
                        data-bs-target="#importModal">
                        <i class="fas fa-upload"></i> Import Data
                    </button>
                    <?php if (session('success')) : ?>
                    <div class="swal" data-type="success" data-swal="<?= session('success'); ?>"></div>
                    <?php endif; ?>

                    <?php if (isset($validation) && $validation->getError('kode_kelurahan')) : ?>
                    <div class="swal" data-type="error" data-swal="<?= $validation->getError('kode_kelurahan'); ?>">
                    </div>
                    <?php endif; ?>
                    <table class="table table-striped table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Kelurahan/Desa</th>
                                <th>Nama Kelurahan/Desa</th>
                                <th>Kode Kecamatan</th>
                                <th>Nama Kecamatan</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_kelurahan as $kel) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?= $kel->kode_kelurahan; ?>
                                </td>
                                <td>
                                    <?= $kel->nama_kel_des; ?>
                                </td>
                                <td>
                                    <?= $kel->kode_kec; ?>
                                </td>
                                <td>
                                    <?= $kel->nama_kec; ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i:s', strtotime($kel->tgl_inp)); ?>
                                </td>
                                <td width="15%" class="text-center">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#ubahModal<?= $kel->kode_kelurahan; ?>"><i
                                            class="fas fa-edit"></i>
                                        Ubah</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="hapus(<?= $kel->kode_kelurahan; ?>)"><i class="fas fa-trash-alt"></i>
                                        Hapus</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
                        Kelurahan/Desa</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('kecamatan/tambah'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="kode_kelurahan">Kode Kelurahan</label>
                            <input type="text" name="kode_kelurahan" id="kode_kelurahan"
                                class="form-control <?php if (isset($validation) && $validation->getError('kode_kelurahan')) : ?>is-invalid<?php endif ?>"
                                required>
                            <div class="invalid-feedback">
                                <?php if (isset($validation) && $validation->getError('kode_kelurahan')) : ?>
                                <?= $validation->getError('kode_kelurahan'); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kel_des">Nama Kelurahan/Desa</label>
                            <input type="text" name="nama_kel_des" id="nama_kel_des" class="form-control" required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import-->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-modal text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-upload"></i> Import Data
                        Kelurahan/Desa</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('kelurahan/import'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="mb-1" for="">Unggah File</label>

                            <input type="file" class="form-control" name="file" id="" accept=".xls,.xlsx">
                            <a href="/template_import_kel.xlsx">Template Import Data</a>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                </form>
            </div>
        </div>
    </div>

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

    function hapus(kode_kelurahan) {
        Swal.fire({
            title: 'Hapus',
            text: "Anda Yakin Data Kelurahan/Desa Akan Dihapus?",
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
                    url: '<?= base_url("kelurahan/hapus"); ?>',
                    data: {
                        _method: 'delete',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        kode_kelurahan: kode_kelurahan
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "<?= base_url('kelurahan'); ?>"

                                }

                            })
                        }
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User clicked "Batal" button
                Swal.fire('Batal', 'Tidak ada data yang dihapus', 'info');
            }

        })
    }
    </script>
    <?= $this->endSection(); ?>