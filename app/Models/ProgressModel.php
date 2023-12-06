<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $table            = 'progress_kegiatan';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_kegiatan', 'realisasi', 'user', 'tgl_input', 'tgl_update'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'date';
    // protected $createdField  = 'tgl_input';
    // protected $updatedField  = 'tgl_update';

    // Add a method to fetch aggregated progress data by date
    public function getAggregatedProgressByDate($activityID)
    {
        $query = $this->select('progress_kegiatan.tgl_input, SUM(progress_kegiatan.realisasi) as total_realisasi, progress_target.target')
            ->join('daftar_kegiatan', 'daftar_kegiatan.id_kegiatan = progress_kegiatan.id_kegiatan')
            ->join('progress_target', 'progress_target.id_kegiatan = daftar_kegiatan.id_kegiatan')
            ->where('progress_kegiatan.id_kegiatan', $activityID)
            ->groupBy(['progress_kegiatan.id_kegiatan', 'progress_kegiatan.tgl_input'])
            ->orderBy('progress_kegiatan.tgl_input', 'ASC')
            ->findAll();

        return $query;
    }
}
