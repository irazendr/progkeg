<?= $this->extend('admin/layout/template'); ?>
<?= $this->Section('style'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?= $this->endSection(); ?>
<?= $this->Section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?= $title; ?></h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('input-target'); ?>">Kegiatan</a></li>
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Target Realisasi Kegiatan
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                            <?php if (session('success')) : ?>
                                <div class="swal" data-type="success" data-swal="<?= session('success'); ?>"></div>
                            <?php endif; ?>

                            <?php if (isset($validation) && $validation->getError('id_kegiatan')) : ?>
                                <div class="swal" data-type="error" data-swal="<?= $validation->getError('id_kegiatan'); ?>"></div>
                            <?php endif; ?>
                            <table class="table table-striped table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Target</th>
                                        <th>Tanggal Input</th>
                                        <th>User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($target as $k) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?= $k->nama_kegiatan; ?>
                                            </td>
                                            <td>
                                                <?= $k->target; ?>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y', strtotime($k->tgl_masuk)); ?>
                                            </td>
                                            <td>
                                                <?= $k->user_t; ?>
                                            </td>
                                            <td width="15%" class="text-center">
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ubahModal<?= $k->id_t; ?>"><i class="fas fa-edit"></i>
                                                    Update</button>
                                                <?php if (in_groups('Admin')) : ?>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?= $k->id_t; ?>)"><i class="fas fa-trash-alt"></i>
                                                        Hapus</button>
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
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Input Target Realisasi Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('input-target/tambah'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select <?php if (isset($validation) && $validation->getError('id_kegiatan')) : ?>is-invalid<?php endif ?>" aria-label="Default select example" id="id_kegiatan" name="id_kegiatan">
                                    <option value="" disabled selected>--Pilih Kegiatan--</option>
                                    <?php foreach ($list_keg as $l) : ?>
                                        <option value="<?= $l->id_kegiatan; ?>"><?= $l->nama_kegiatan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="target">Nama Kegiatan</label>
                                <div class="invalid-feedback">
                                <?php if (isset($validation) && $validation->getError('id_kegiatan')) : ?>
                                            <?= $validation->getError('id_kegiatan'); ?>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <input type="number" name="target" id="target" class="form-control" required>
                                <label for="target">Target</label>
                            </div>
                        </div>
                        <input type="hidden" id="user" name="user" value="<?= user()->username; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <?php foreach ($target as $l) : ?>
        <!-- Modal Update -->
        <div class="modal fade" id="ubahModal<?= $l->id_t; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Update Target Realisasi
                            Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('input-target/ubah/' . $l->id_t); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select <?php if (isset($validation) && $validation->getError('id_kegiatan')) : ?>is-invalid<?php endif ?>" aria-label="Default select example" id="id_kegiatan" name="id_kegiatan" disabled>
                                        <?php foreach ($list_keg as $m) : ?>
                                            <option value="<?= $m->id_kegiatan; ?>" <?php if ($m->id_kegiatan == $l->id_keg) : ?>selected<?php endif ?>>
                                                <?= $m->nama_kegiatan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="">Nama Kegiatan</label>
                                    <div class="invalid-feedback">
                                        <?php if (isset($validation) && $validation->getError('id_kegiatan')) : ?>
                                            <?= $validation->getError('id_kegiatan'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input type="number" name="target" id="target" class="form-control" value="<?= $l->target; ?>" required>
                                    <label for="target">Target</label>
                                </div>
                            </div>
                            <input type="hidden" id="user" name="user" value="<?= user()->username; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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

        function hapus(id) {
            Swal.fire({
                title: 'Hapus',
                text: "Anda Yakin Data Target Realisasi Kegiatan Akan Dihapus?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("input-target/hapus"); ?>',
                    data: {
                        _method: 'delete',
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        id: id
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
                                    window.location.href = "<?= base_url('input-target'); ?>"

                                }

                            })
                        }
                    }
                })
            })
        }
    </script>
    <?= $this->endSection(); ?>