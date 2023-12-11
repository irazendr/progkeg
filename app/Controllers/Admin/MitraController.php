<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MitraModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;

class MitraController extends BaseController
{
    protected $mitraModel;
    protected $db, $builder, $builder2, $query, $query2;
    public function __construct()
    {
        $this->mitraModel = new MitraModel();
        $this->db = \config\Database::connect();
        $this->builder = $this->db->table('mitra');
        $this->builder->select('id_mitra, nama_lengkap, role, tgl_input, tgl_ubah');
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
            'title' => 'Daftar Mitra',
            'data_mitra' => $this->query->getResult(),

        ];

        return view("admin/mitra/index", $data);
    }

    public function store()
    {
        $id_mitra                      = $this->request->getPost('id_mitra');
        $nama_lengkap                      = $this->request->getPost('nama_lengkap');
        $role                      = $this->request->getPost('role');

        $data = [
            'id_mitra' => $id_mitra,
            'nama_lengkap' => $nama_lengkap,
            'role' => $role,

        ];
        $this->mitraModel->insert($data);
        return redirect()->back()->with('success', 'Data Mitra Berhasil Ditambahkan.');
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

    public function import_mitra()
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

            $id_mitra                  = $value[1];
            $role                  = $value[2];
            $nama_lengkap                      = $value[3];

            $data = [
                'id_mitra' => $id_mitra,
                'role' => $role,
                'nama_lengkap' => $nama_lengkap,
            ];

            $this->mitraModel->insert($data);
        }

        return redirect()->back()->with('success', 'Data Mitra Berhasil Diimport.');
    }
    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $id_mitra = $this->request->getVar('id_mitra');
            $this->mitraModel->delete($id_mitra);
            $result = [
                'success' => 'Data Mitra Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan Pada Sistem!');
        }
    }
}