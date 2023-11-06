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
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
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
                            <div class="swal" data-swal="<?= session('success'); ?>"></div>

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Tanggal Input</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($daftar_kegiatan as $k) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <?= $k->nama_kegiatan; ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($k->tgl_mulai)); ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($k->tgl_selesai)); ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i:s', strtotime($k->tgl_input)); ?>
                                        </td>
                                        <td width="15%" class="text-center">
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#ubahModal<?= $k->id_kegiatan; ?>"><i
                                                    class="fas fa-edit"></i>
                                                Ubah</button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="hapus(<?= $k->id_kegiatan; ?>)"><i
                                                    class="fas fa-trash-alt"></i>
                                                Hapus</button>
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
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Tambah
                        Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('daftar-kegiatan/tambah'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Pilih Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Pilih Tanggal Selesai:</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
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

    <?php foreach ($daftar_kegiatan as $l) : ?>
    <!-- Modal Ubah -->
    <div class="modal fade" id="ubahModal<?= $l->id_kegiatan; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Ubah Data
                        Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('daftar-kegiatan/ubah/' . $k->id_kegiatan); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control"
                                value="<?= $l->nama_kegiatan; ?>" required>
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

    <?php foreach ($daftar_kegiatan as $m) : ?>
    <!-- Modal Hapus -->
    <div class="modal fade" id="hapusModal<?= $m->id_kegiatan; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash-alt"></i> Hapus Data
                        Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('daftar-kegiatan/hapus/' . $m->id_kegiatan); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <p>Yakin Data Kegiatan : <?= $m->nama_kegiatan; ?>, Akan Dihapus?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
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
    const swal = $('.swal').data('swal');
    if (swal) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: swal,
            showConfirmButton: false,
            timer: 1500
        })

    }

    function hapus(id_kegiatan) {
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
            $.ajax({
                type: 'POST',
                url: '<?= base_url("daftar-kegiatan/hapus"); ?>',
                data: {
                    _method: 'delete',
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    id_kegiatan: id_kegiatan
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
                                window.location.href = "<?= base_url('daftar-kegiatan'); ?>"

                            }

                        })
                    }
                }
            })
            // if (result.isConfirmed) {
            //     Swal.fire(
            //         'Terhapus!',
            //         'Data Kegiatan Berhasil Dihapus.',
            //         'success'
            //     )
            // }
        })
    }
    </script>
    <?= $this->endSection(); ?>