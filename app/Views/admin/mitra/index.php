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
                    Daftar Mitra
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

                    <?php if (session('error')) : ?>
                    <div class="swal" data-type="error" data-swal="<?= session('error'); ?>"></div>
                    <?php endif; ?>
                    <table class="table table-striped table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Mitra</th>
                                <th>Nama Lengkap</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_mitra as $mitra) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <?= $mitra->id_mitra; ?>
                                </td>
                                <td>
                                    <?= $mitra->nama_lengkap; ?>
                                </td>
                                <td>
                                    <?= $mitra->role; ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i:s', strtotime($mitra->tgl_input)); ?>
                                </td>
                                <td width="15%" class="text-center">
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#ubahModal<?= $mitra->id_mitra; ?>"><i class="fas fa-edit"></i>
                                        Ubah</button>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="hapus(<?= $mitra->id_mitra; ?>)"><i class="fas fa-trash-alt"></i>
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
                        Mitra</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('mitra/tambah'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="id_mitra">ID Mitra</label>
                            <input type="text" name="id_mitra" id="id_mitra" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="role" name="role">
                                    <option value="PCL">PCL</option>
                                    <option value="PML">PML</option>
                                </select>
                                <label for="role">Role</label>
                            </div>
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
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-upload"></i> Import Data Mitra</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('mitra/import'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="mb-1" for="">Unggah File</label>

                            <input type="file" class="form-control" name="file" id="" accept=".xls,.xlsx">
                            <a href="/template_import_mitra.xlsx">Template Import Data</a>
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

    function hapus(id_mitra) {
        Swal.fire({
            title: 'Hapus',
            text: "Anda Yakin Data Mitra Akan Dihapus?",
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
                    url: '<?= base_url("mitra/hapus"); ?>',
                    data: {
                        _method: 'delete',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        id_mitra: id_mitra,
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
                                    window.location.href = "<?= base_url('mitra'); ?>"
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