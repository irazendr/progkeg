<?php

namespace App\Models;

use CodeIgniter\Model;

class KelurahanModel extends Model
{
    protected $table            = 'kelurahan';
    protected $primaryKey       = 'kode_kelurahan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_kelurahan', 'kode_kecamatan', 'nama_kel_des'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tgl_input';
    protected $updatedField  = 'tgl_ubah';

    // Validation
    protected $validationRules = [
        'kode_kelurahan' => [
            'rules' => 'required|is_unique[kelurahan.kode_kelurahan]',
            'errors' => [
                'is_unique' => 'Kelurahan/Desa Sudah Ada!',
            ],
        ],
    ];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}