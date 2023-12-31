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
                <li class="breadcrumb-item"><a href="<?= base_url('input-progress'); ?>">Kegiatan</a></li>
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Histori Input Progress Kegiatan
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                    <a href="/export-excel" class="btn btn-secondary btn-sm mb-2 text-white">
                                        <i class="fas fa-file-excel"></i> Export Data
                                    </a>
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#importModal">
                                        <i class="fas fa-upload"></i> Import Data
                                    </button>
                                </div>

                            </div>


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
                                        <th>PCL</th>
                                        <th>PML</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Realisasi</th>
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
                                                <?= $k->pcl_nama; ?>
                                            </td>
                                            <td>
                                                <?= $k->pml_nama; ?>
                                            </td>
                                            <td>
                                                <?= $k->nama_kec; ?>
                                            </td>
                                            <td>
                                                <?= $k->nama_kel_des; ?>
                                            </td>
                                            <td>
                                                <?= $k->realisasi; ?>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y', strtotime($k->tgl_masuk)); ?>
                                            </td>
                                            <td>
                                                <?= $k->user_k; ?>
                                            </td>
                                            <td width="15%" class="text-center">
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ubahModal<?= $k->prog_id; ?>"><i class="fas fa-edit"></i>
                                                </button>
                                                <?php if (in_groups('Admin')) : ?>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?= $k->prog_id; ?>)"><i class="fas fa-trash-alt"></i>
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
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i>Input Progress Kegiatan
                    </h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('input-progress/tambah'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="kode_kegiatan" name="kode_kegiatan">
                                    <?php foreach ($list_keg as $l) : ?>
                                        <option value="<?= $l->id_k; ?>">
                                            <?= $l->nama_kegiatan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="">Nama Kegiatan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="id_mitra_pcl" name="id_mitra_pcl">
                                    <option value="" disabled selected>
                                        --Pilih PCL--</option>
                                    <?php foreach ($list_mitra_pcl as $m) : ?>
                                        <option value="<?= $m->id_mitra; ?>">
                                            <?= $m->nama_lengkap; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="role">PCL</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="id_mitra_pml" name="id_mitra_pml">
                                    <option value="" disabled selected>
                                        --Pilih PML--</option>
                                    <?php foreach ($list_mitra_pml as $n) : ?>
                                        <option value="<?= $n->id_mitra; ?>">
                                            <?= $n->nama_lengkap; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="role">PML</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="id_kec_tambah" name="id_kec">
                                    <option value="" disabled selected>
                                        --Pilih Kecamatan--</option>
                                    <?php foreach ($list_kec as $o) : ?>
                                        <option value="<?= $o->kode_kecamatan; ?>">
                                            [<?= $o->kode_kecamatan; ?>] <?= $o->nama_kec; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="role">Kecamatan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <select class="form-select" aria-label="Default select example" id="id_kel_tambah" name="id_kel">

                                </select>
                                <label for="role">Kelurahan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3 mb-md-0">
                                <input type="number" name="realisasi" id="realisasi" class="form-control" required>
                                <label for="realisasi">Realisasi</label>
                            </div>
                        </div>
                        <input type="hidden" name="tgl_input" value="<?= date('Y-m-d'); ?>">
                        <input type="hidden" name="tgl_update" value="<?= date('Y-m-d'); ?>">
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
        <!-- Modal Update -->
        <div class="modal fade" id="ubahModal<?= $l->prog_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-modal text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Update Progress
                            Kegiatan</h5>
                        <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('input-progress/ubah/' . $l->prog_id); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select" aria-label="Default select example" id="kode_kegiatan" name="kode_kegiatan" disabled>
                                        <?php foreach ($list_keg as $m) : ?>
                                            <option value="<?= $m->id_k; ?>" <?php if ($m->id_k == $l->id_keg) : ?>selected<?php endif ?>>
                                                <?= $m->nama_kegiatan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="">Nama Kegiatan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select" aria-label="Default select example" id="id_mitra_pcl" name="id_mitra_pcl">

                                        <?php foreach ($list_mitra_pcl as $m) : ?>
                                            <option value="<?= $m->id_mitra; ?>" <?php if ($m->id_mitra == $l->id_mitra_pcl) : ?>selected<?php endif ?>>
                                                [<?= $m->id_mitra; ?>] <?= $m->nama_lengkap; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="role">PCL</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select" aria-label="Default select example" id="id_mitra_pml" name="id_mitra_pml">

                                        <?php foreach ($list_mitra_pml as $n) : ?>
                                            <option value="<?= $n->id_mitra; ?>" <?php if ($n->id_mitra == $l->id_mitra_pml) : ?>selected<?php endif ?>>
                                                [<?= $n->id_mitra; ?>] <?= $n->nama_lengkap; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="role">PML</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select" aria-label="Default select example" id="id_kec" name="id_kec">


                                        <?php foreach ($list_kec as $o) : ?>
                                            <option value="<?= $o->kode_kecamatan; ?>" <?php if ($o->kode_kecamatan == $l->id_kec) : ?>selected<?php endif ?>>
                                                [<?= $o->kode_kecamatan; ?>] <?= $o->nama_kec; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="role">Kecamatan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select" aria-label="Default select example" id="id_kel" name="id_kel">

                                        <?php foreach ($list_kel as $p) : ?>
                                            <option value="<?= $p->kode_kelurahan; ?>" <?php if ($p->kode_kelurahan == $l->id_kel) : ?>selected<?php endif ?>>
                                                [<?= $p->kode_kelurahan; ?>] <?= $p->nama_kel_des; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="role">Kelurahan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input type="number" name="realisasi" id="realisasi" class="form-control" value="<?= $l->realisasi; ?>" required>
                                    <label for="realisasi">Realisasi</label>
                                </div>
                            </div>
                            <input type="hidden" name="tgl_update" value="<?= date('Y-m-d'); ?>">
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

    <!-- Modal Import-->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-modal text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-upload"></i> Import Data Progress
                        Kegiatan</h5>
                    <h5 data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></h5>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('input-progress/import'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="mb-1" for="">Unggah File</label>

                            <input type="file" class="form-control" name="file" id="" accept=".xls,.xlsx">
                            <a href="/template_import_realisasi.xlsx">Template Import Data</a>
                        </div>
                        <input type="hidden" id="user" name="user" value="<?= user()->username; ?>">
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

        function hapus(id) {
            Swal.fire({
                title: 'Hapus',
                text: "Anda Yakin Data Progress Kegiatan Akan Dihapus?",
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
                        url: '<?= base_url("input-progress/hapus"); ?>',
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
                                        window.location.href =
                                            "<?= base_url('input-progress'); ?>"

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
    <script>
        $(document).ready(function() {
            $('#id_kec_tambah').change(function() {
                var id_kec = $(this).val();

                // Perbarui dropdown "Kelurahan" dengan data dari server
                $.ajax({
                    type: "POST",
                    url: "/input-progress/getKelurahanByKecamatan",
                    data: {
                        id_kec: id_kec
                    },
                    dataType: "json",
                    success: function(response) {
                        var options =
                            '<option value="" disabled selected>--Pilih Kelurahan/Desa--</option>';

                        $.each(response.kelurahan, function(key, value) {
                            options += '<option value="' + value.kode_kelurahan +
                                '">[' + value.kode_kelurahan + '] ' +
                                value.nama_kel_des + '</option>';
                        });

                        // Perbarui dropdown "Kelurahan"
                        $('#id_kel_tambah').html(options);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#id_kec_tambah').change(function() {
                var id_kec = $(this).val();

                // Perbarui dropdown "Kelurahan" dengan data dari server
                $.ajax({
                    type: "POST",
                    url: "/input-progress/getKelurahanByKecamatan",
                    data: {
                        id_kec: id_kec
                    },
                    dataType: "json",
                    success: function(response) {
                        var options =
                            '<option value="" disabled selected>--Pilih Kelurahan/Desa--</option>';

                        $.each(response.kelurahan, function(key, value) {
                            options += '<option value="' + value.kode_kelurahan +
                                '">[' + value.kode_kelurahan + '] ' +
                                value.nama_kel_des + '</option>';
                        });

                        // Perbarui dropdown "Kelurahan"
                        $('#id_kel_tambah').html(options);
                    }
                });
            });
        });
    </script>



    <?= $this->endSection(); ?>