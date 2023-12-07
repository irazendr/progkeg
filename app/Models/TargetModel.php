<?php

namespace App\Models;

use CodeIgniter\Model;

class TargetModel extends Model
{
    protected $table            = 'progress_target';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_kegiatan', 'target', 'user'];

    // Dates
    protected $useTimestamps = true;
    protected $validationRules = [
        'kode_kegiatan' => [
            'rules' => 'required|is_unique[progress_target.kode_kegiatan]',
            'errors' => [
                'is_unique' => 'Target Kegiatan Yang Dipilih Sudah Ada!',
            ],
        ],
    ];

    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tgl_input';
    protected $updatedField  = 'tgl_update';
}
