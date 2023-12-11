<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KecamatanModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;

class KecamatanController extends BaseController
{
    protected $kecModel;
    protected $db, $builder, $builder2, $query, $query2;
    public function __construct()
    {
        $this->kecModel = new KecamatanModel();
        $this->db = \config\Database::connect();
        $this->builder = $this->db->table('kecamatan');
        $this->builder->select('kode_kecamatan, nama_kec, tgl_input, tgl_ubah');
        // $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        // $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->query = $this->builder->get();

        // $this->builder2 = $this->db->table('auth_groups');
        // $this->builder2->select('id, name');
        // $this->query2 = $this->builder2->get();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Kecamatan',
            'data_kecamatan' => $this->query->getResult(),

        ];

        return view("admin/kecamatan/index", $data);
    }

    public function store()
    {
        $kode_kecamatan                      = $this->request->getPost('kode_kecamatan');
        $nama_kec                      = $this->request->getPost('nama_kec');

        // Load the form helper and validation library
        helper(['form']);
        $validation                         = \Config\Services::validation();

        // Run the validation
        if ($this->request->withMethod('post') && !$this->validate($this->kecModel->validationRules)) {
            // Validation failed, reload the form with validation errors
            $data = [
                'title' => 'Daftar Kecamatan',
                'data_kecamatan' => $this->query->getResult(),
                'validation' => $validation,
            ];
            return view('admin/kecamatan/index', $data);
        }
        $data = [
            'kode_kecamatan' => $kode_kecamatan,
            'nama_kec' => $nama_kec,

        ];
        $this->kecModel->insert($data);
        return redirect()->back()->with('success', 'Data Kecamatan Berhasil Ditambahkan.');
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

    public function import_kecamatan()
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

            $kode_kecamatan                  = $value[1];
            $nama_kec                      = $value[2];

            $data = [
                'kode_kecamatan' => $kode_kecamatan,
                'nama_kec' => $nama_kec,
            ];

            $this->kecModel->insert($data);
        }

        return redirect()->back()->with('success', 'Data Kecamatan Berhasil Diimport.');
    }
    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $kode_kecamatan = $this->request->getVar('kode_kecamatan');
            $this->kecModel->delete($kode_kecamatan);
            $result = [
                'success' => 'Data Kecamatan Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan Pada Sistem!');
        }
    }
}