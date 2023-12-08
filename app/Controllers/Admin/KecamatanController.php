<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KecamatanController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Kecamatan',
            'daftar_mitra' => "",

        ];

        return view("admin/kecamatan/index", $data);
    }
}
