<?php

namespace App\Controllers\Admin;

use App\Models\ProgressModel;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    protected $progressModel;
    protected $db, $builder, $builder2, $builder3, $query, $query2, $query3;
    public function __construct()
    {
        $this->progressModel = new ProgressModel();
        $this->db = \config\Database::connect();
        $this->builder = $this->db->table('progress_kegiatan');
        $this->builder->select('progress_kegiatan.id as prog_id, progress_kegiatan.id_kegiatan as id_keg, nama_kegiatan, target, realisasi, progress_target.tgl_update as target_update, progress_kegiatan.tgl_update as progress_update');
        $this->builder->join('daftar_kegiatan', 'daftar_kegiatan.id_kegiatan =  progress_kegiatan.id_kegiatan');
        $this->builder->join('progress_target', 'progress_target.id_kegiatan =  daftar_kegiatan.id_kegiatan');
        $this->query = $this->builder->get();

        $this->builder2 = $this->db->table('daftar_kegiatan');
        $this->builder2->select('id_kegiatan, nama_kegiatan');
        $this->query2 = $this->builder2->get();

        $this->builder3 = $this->db->table('progress_target');
        $this->builder3->select('progress_target.id_kegiatan as id_keg, nama_kegiatan');
        $this->builder3->join('daftar_kegiatan', 'daftar_kegiatan.id_kegiatan =  progress_target.id_kegiatan');
        $this->query3 = $this->builder3->get();
    }
    public function index()
    {
        // Fetch aggregated progress data by date
        // $aggregatedProgressData = $this->progressModel->getAggregatedProgressByDate();

        $data = [
            'title' => 'Dashboard',
            'daftar_kegiatan' => $this->query->getResult(),
            'list_keg' => $this->query2->getResult(),
            'target' => $this->query3->getResult(),
            // 'aggregatedProgressData' => $aggregatedProgressData,
        ];
        return view('admin/dashboard/index', $data);
    }

    // Add a new method to fetch aggregated progress data by date for a specific activity
    public function getAggregatedProgress($activityID)
    {

        // Fetch aggregated progress data by date for the specified activity
        $aggregatedProgressData = $this->progressModel->getAggregatedProgressByDate($activityID);

        // Return the data as JSON
        return $this->response->setJSON($aggregatedProgressData);
    }
}
