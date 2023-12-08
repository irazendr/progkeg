<?= $this->extend('admin/layout/template'); ?>
<?= $this->Section('style'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?= $this->endSection(); ?>
<?= $this->Section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Akun</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Data Akun</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Daftar Akun
                </div>
                <div class="card-body">
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
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_akun as $akun) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <?= $akun->nama_lengkap; ?>
                                    </td>
                                    <td>
                                        <?= $akun->email; ?>
                                    </td>
                                    <td>
                                        <?= $akun->username; ?>
                                    </td>
                                    <td>
                                        <?= $akun->name; ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y H:i:s', strtotime($akun->created_at)); ?>
                                    </td>
                                    <td width="15%" class="text-center">
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ubahModal<?= $akun->userid; ?>"><i class="fas fa-edit"></i>
                                            Ubah</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?= $akun->userid; ?>)"><i class="fas fa-trash-alt"></i>
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
    <?php foreach ($data_akun as $k) : ?>
        <!-- Modal Ubah -->
        <div class="modal fade" id="ubahModal<?= $k->userid; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-modal text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Ubah Data
                            Akun</h5>
                        <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('akun/ubah/' . $k->userid); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= $k->nama_lengkap; ?>" required />
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="inputEmail" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= $k->email; ?>" required />
                                        <label for="inputEmail"><?= lang('Auth.email') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" id="inputUsername" type="text" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= $k->username; ?>" required />
                                        <label for="inputUsername"><?= lang('Auth.username') ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example" id="group_id" name="group_id">
                                            <?php foreach ($list_role as $l) : ?>
                                                <option value="<?= $l->id; ?>" <?php if ($l->id == $k->roleid) : ?>selected<?php endif ?>>
                                                    <?= $l->id; ?>. <?= $l->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="">Role</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="password_hash" id="password_hash" value="checkedValue">
                                        Reset Password?
                                    </label>
                                </div>
                            </div>

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

        function reset(id) {
            Swal.fire({
                title: 'Reset Password',
                text: "Anda Yakin Akan Reset Password?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Reset',
                cancelButtonText: 'Batal'
            }).then((result) => {
                var baseUrl = '<?= base_url(); ?>';
                $.ajax({
                    type: 'GET',
                    url: baseUrl + 'akun/reset-password/' + id,
                    data: {
                        _method: 'put',
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
                                    window.location.href = "<?= base_url('akun'); ?>"

                                }

                            })
                        }
                    }
                })
            })
        }

        function hapus(id) {
            Swal.fire({
                title: 'Hapus',
                text: "Anda Yakin Data Akun Akan Dihapus?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("akun/hapus"); ?>',
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
                                    window.location.href = "<?= base_url('akun'); ?>"

                                }

                            })
                        }
                    }
                })
            })
        }
    </script>
    <?= $this->endSection(); ?>