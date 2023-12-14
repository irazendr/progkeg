<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KelurahanModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;

class KelurahanController extends BaseController
{
    protected $kelModel;
    protected $db, $builder, $builder2, $query, $query2;
    public function __construct()
    {
        $this->kelModel = new KelurahanModel();
        $this->db = \config\Database::connect();
        $this->builder = $this->db->table('kelurahan');
        $this->builder->select('kode_kelurahan, nama_kel_des, kelurahan.kode_kecamatan as kode_kec, nama_kec, kelurahan.tgl_input as tgl_inp, kelurahan.tgl_ubah as tgl_ub');
        $this->builder->join('kecamatan', 'kecamatan.kode_kecamatan = kelurahan.kode_kecamatan');
        // $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->query = $this->builder->get();
        $this->builder2                     = $this->db->table('kecamatan');
        $this->builder2->select('kode_kecamatan, nama_kec');
        $this->query2                       = $this->builder2->get();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Kelurahan',
            'data_kelurahan' => $this->query->getResult(),
            'list_kec' => $this->query2->getResult(),

        ];

        return view("admin/kelurahan/index", $data);
    }

    public function store()
    {
        $kode_kelurahan                      = $this->request->getPost('kode_kelurahan');
        $kode_kecamatan                      = $this->request->getPost('kode_kecamatan');
        $nama_kel_des                      = $this->request->getPost('nama_kel_des');


        // Load the form helper and validation library
        helper(['form']);
        $validation                         = \Config\Services::validation();

        // Run the validation
        if ($this->request->withMethod('post') && !$this->validate($this->kelModel->validationRules)) {
            // Validation failed, reload the form with validation errors
            $data = [
                'title' => 'Daftar kelurahan',
                'data_kelurahan' => $this->query->getResult(),
                'validation' => $validation,
            ];
            return view('admin/kecamatan/index', $data);
        }
        $data = [
            'kode_kelurahan' => $kode_kelurahan,
            'nama_kel_des' => $nama_kel_des,
            'kode_kecamatan' => $kode_kecamatan,

        ];
        $this->kelModel->insert($data);
        return redirect()->back()->with('success', 'Data Kelurahan/Desa Berhasil Ditambahkan.');
    }
    // public function update($kode_kegiatan)
    // {
    //     $nama_kegiatan                      = $this->request->getPost('nama_kegiatan');
    //     $tipe_kegiatan                      = $this->request->getPost('tipe_kegiatan');
    //     $tgl_mulai                          = $this->request->getPost('tgl_mulai');
    //     $tgl_selesai                        = $this->request->getPost('tgl_selesai');
    //     $user                               = $this->request->getPost('user');

    //     // Check if $nama_kegiatan is not null and is a string
    //     if (!is_null($nama_kegiatan) && is_string($nama_kegiatan)) {
    //         $slug                           = url_title($nama_kegiatan, '-', TRUE);
    //     }
    //     $data = [
    //         'nama_kegiatan' => esc($nama_kegiatan),
    //         'tipe_kegiatan' => $tipe_kegiatan,
    //         'slug_kegiatan' => $slug,
    //         'tgl_mulai' => $tgl_mulai,
    //         'tgl_selesai' => $tgl_selesai,
    //         'user' => $user,

    //     ];
    //     $this->KegiatanModel->update($kode_kegiatan, $data);
    //     return redirect()->back()->with('success', 'Data Kegiatan Berhasil Diubah.');
    // }

    public function import_kelurahan()
    {
        $file                               = $this->request->getFile('file');
        // dd($file);
        $ext                                = $file->getExtension();


        if ($ext === "xls") {
            $reader                         = new XlsReader();
        } else {
            $reader                         = new XlsxReader();
        }
        $spreadsheet                        = $reader->load($file);
        $sheet                              = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value) {
            if ($key === 0) {
                continue;
            }

            $kode_kelurahan                  = $value[1];
            $nama_kel_des                      = $value[2];
            $kode_kecamatan                  = $value[3];

            $data = [
                'kode_kelurahan' => $kode_kelurahan,
                'nama_kel_des' => $nama_kel_des,
                'kode_kecamatan' => $kode_kecamatan,
            ];

            $this->kelModel->insert($data);
        }

        return redirect()->back()->with('success', 'Data Kelurahan/Desa Berhasil Diimport.');
    }
    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $kode_kelurahan = $this->request->getVar('kode_kelurahan');
            $this->kelModel->delete($kode_kelurahan);
            $result = [
                'success' => 'Data Kelurahan/Desa Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan Pada Sistem!');
        }
    }
}
