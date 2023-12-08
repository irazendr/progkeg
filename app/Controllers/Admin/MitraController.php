<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MitraController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Mitra',
            'daftar_mitra' => "",

        ];

        return view("admin/mitra/index", $data);
    }
}
