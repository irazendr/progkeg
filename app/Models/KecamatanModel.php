<?php

namespace App\Models;

use CodeIgniter\Model;

class KecamatanModel extends Model
{
    protected $table            = 'kecamatan';
    protected $primaryKey       = 'kode_kecamatan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_kecamatan', 'nama_kec'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tgl_input';
    protected $updatedField  = 'tgl_ubah';

    // Validation
    protected $validationRules = [
        'kode_kecamatan' => [
            'rules' => 'required|is_unique[kecamatan.kode_kecamatan]',
            'errors' => [
                'is_unique' => 'Kecamatan Sudah Ada!',
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