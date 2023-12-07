<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table            = 'daftar_kegiatan';
    protected $primaryKey       = 'kode_kegiatan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_kegiatan', 'nama_kegiatan', 'slug_kegiatan', 'tgl_mulai', 'tgl_selesai', 'user'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tgl_input';
    protected $updatedField  = 'tgl_ubah';
}
