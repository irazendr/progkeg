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
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>

        </div>
    </main>



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
                                        window.location.href = "<?= base_url('daftar-kegiatan'); ?>"
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