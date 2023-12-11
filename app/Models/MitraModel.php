<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table            = 'mitra';
    protected $primaryKey       = 'id_mitra';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mitra', 'nama_lengkap', 'role'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tgl_input';
    protected $updatedField  = 'tgl_ubah';

    // Validation
    protected $validationRules = [
        'id_mitra' => [
            'rules' => 'required|is_unique[mitra.id_mitra]',
            'errors' => [
                'is_unique' => 'Mitra Sudah Ada!',
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