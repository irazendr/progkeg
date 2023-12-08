<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KelurahanController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Kelurahan',
            'daftar_mitra' => "",

        ];

        return view("admin/kelurahan/index", $data);
    }
}
