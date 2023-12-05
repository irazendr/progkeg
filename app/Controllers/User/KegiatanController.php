<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProgressModel;
use App\Models\TargetModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\PermissionModel;


class KegiatanController extends BaseController
{

    protected $progressModel, $targetModel, $userModel, $permissionModel;
    protected $db, $builder, $builder2, $builder3, $builder4, $query, $query2, $query3, $query4;
    public function __construct()
    {
        // Memuat library Myth/Auth
        $this->userModel = new UserModel();
        $this->permissionModel = new PermissionModel();
        $this->progressModel = new ProgressModel();
        $this->targetModel = new TargetModel();

        $this->db = \config\Database::connect();
        $this->builder = $this->db->table('progress_kegiatan');
        $this->builder->select('progress_kegiatan.id as prog_id, progress_kegiatan.id_kegiatan as id_keg, nama_kegiatan, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k, auth_permissions.name as permissions');
        $this->builder->join('daftar_kegiatan', 'daftar_kegiatan.id_kegiatan =  progress_kegiatan.id_kegiatan');
        $this->builder->join('progress_target', 'progress_target.id_kegiatan =  daftar_kegiatan.id_kegiatan');
        $this->builder->join('users', 'users.username =  progress_target.user');
        $this->builder->join('auth_users_permissions', 'auth_users_permissions.user_id =  users.id');
        $this->builder->join('auth_permissions', 'auth_permissions.id= auth_users_permissions.permission_id');
        $this->query = $this->builder->get();

        $this->builder2 = $this->db->table('daftar_kegiatan');
        $this->builder2->select('daftar_kegiatan.id_kegiatan as id_k, progress_target.id as id_t, progress_target.id_kegiatan as id_keg,nama_kegiatan, progress_target.target, progress_target.tgl_input as tgl_masuk, progress_target.user as user_t');
        $this->builder2->join('progress_target', 'progress_target.id_kegiatan = daftar_kegiatan.id_kegiatan');
        $this->query2 = $this->builder2->get();

        $this->builder3 = $this->db->table('daftar_kegiatan');
        $this->builder3->select('id_kegiatan, nama_kegiatan');
        $this->query3 = $this->builder3->get();

        // Mendapatkan user ID dari sesi
        $session = session();
        $userID = $session->get('logged_in');

        // Mendapatkan informasi pengguna dari database
        $userInfo = $this->userModel->find($userID);

        $this->builder4 = $this->db->table('daftar_kegiatan');
        $this->builder4->select('daftar_kegiatan.id_kegiatan as id_keg, nama_kegiatan, tgl_mulai, tgl_selesai, daftar_kegiatan.tgl_ubah, daftar_kegiatan.tgl_input AS tgl_masuk, daftar_kegiatan.user AS user_k, auth_users_permissions.user_id AS permissions, users.id AS users');
        $this->builder4->join('users', 'users.username = daftar_kegiatan.user');
        $this->builder4->join('auth_users_permissions', 'auth_users_permissions.user_id = users.id');
        $this->builder4->join('auth_permissions', 'auth_permissions.id = auth_users_permissions.permission_id');
        $this->builder4->where('auth_users_permissions.user_id', $userInfo->id);
        $this->query4 = $this->builder4->get();
        // dd($this->query4->getResult());
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Kegiatan',
            'daftar_kegiatan' => $this->query4->getResult(),

        ];
        return view('admin/kegiatan/index', $data);
    }
    public function store()
    {
        $nama_kegiatan = $this->request->getPost('nama_kegiatan');
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        $tgl_selesai = $this->request->getPost('tgl_selesai');
        $user = $this->request->getPost('user');

        // Check if $nama_kegiatan is not null and is a string
        if (!is_null($nama_kegiatan) && is_string($nama_kegiatan)) {
            $slug = url_title($nama_kegiatan, '-', TRUE);
            // Continue with the rest of your code
        }
        $data = [
            'nama_kegiatan' => esc($nama_kegiatan),
            'slug_kegiatan' => $slug,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'user' => $user,

        ];
        $this->KegiatanModel->insert($data);
        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Ditambahkan.');
    }
    public function update($id_kegiatan)
    {
        $nama_kegiatan = $this->request->getPost('nama_kegiatan');
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        $tgl_selesai = $this->request->getPost('tgl_selesai');
        $user = $this->request->getPost('user');

        // Check if $nama_kegiatan is not null and is a string
        if (!is_null($nama_kegiatan) && is_string($nama_kegiatan)) {
            $slug = url_title($nama_kegiatan, '-', TRUE);
        }
        $data = [
            'nama_kegiatan' => esc($nama_kegiatan),
            'slug_kegiatan' => $slug,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'user' => $user,

        ];
        $this->KegiatanModel->update($id_kegiatan, $data);
        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Diubah.');
    }
    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $id_kegiatan = $this->request->getVar('id_kegiatan');
            $this->KegiatanModel->delete($id_kegiatan);
            $result = [
                'success' => 'Data Kegiatan Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            exit('404 Not Found');
        }
    }

    public function input()
    {
        $data = [
            'title' => 'Histori Input Progress Kegiatan',
            // 'daftar_kegiatan' => $this->KegiatanModel->orderBy('tgl_mulai', 'DESC')->findAll()
            'daftar_kegiatan' => $this->query->getResult(),
            'list_keg' => $this->query3->getResult(),

        ];
        return view('admin/kegiatan/progress', $data);
    }

    public function progress()
    {
        $id_kegiatan = $this->request->getPost('id_kegiatan');
        $target = $this->request->getPost('target');
        $realisasi = $this->request->getPost('realisasi');
        $user = $this->request->getPost('user');


        $data = [
            'id_kegiatan' => $id_kegiatan,
            'target' => $target,
            'realisasi' => $realisasi,
            'user' => $user,

        ];
        $this->progressModel->insert($data);
        return redirect()->back()->with('success', 'Data Progress Kegiatan Berhasil Ditambahkan.');
    }
    public function up_progress($id)
    {
        $target = $this->request->getPost('target');
        $realisasi = $this->request->getPost('realisasi');
        $user = $this->request->getPost('user');


        $data = [
            'target' => $target,
            'realisasi' => $realisasi,
            'user' => $user,

        ];
        $this->progressModel->update($id, $data);
        return redirect()->back()->with('success', 'Progress Kegiatan Berhasil Diperbarui.');
    }

    public function destroy_progress()
    {
        if ($this->request->isAJAX()) {
            $prog_id = $this->request->getVar('id');
            $this->progressModel->delete($prog_id);
            $result = [
                'success' => 'Data Progress Kegiatan Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            exit('404 Not Found');
        }
    }

    public function input_target()
    {
        $data = [
            'title' => 'Target Realisasi Kegiatan',
            // 'daftar_kegiatan' => $this->KegiatanModel->orderBy('tgl_mulai', 'DESC')->findAll()
            'daftar_kegiatan' => $this->query->getResult(),
            'target' => $this->query2->getResult(),
            'list_keg' => $this->query3->getResult(),

        ];
        return view('admin/kegiatan/target', $data);
    }

    public function target()
    {
        // Load the form helper and validation library
        helper(['form']);
        $validation = \Config\Services::validation();

        // Run the validation
        if ($this->request->getMethod() === 'post' && !$this->validate($this->targetModel->validationRules)) {
            // Validation failed, reload the form with validation errors
            $data = [
                'title' => 'Target Realisasi Kegiatan',
                'daftar_kegiatan' => $this->query->getResult(),
                'target' => $this->query2->getResult(),
                'list_keg' => $this->query3->getResult(),
                'validation' => $validation,
            ];
            return view('admin/kegiatan/target', $data);
        }

        // Validation passed, proceed with adding the target
        $data = [
            'id_kegiatan' => $this->request->getPost('id_kegiatan'),
            'target' => $this->request->getPost('target'),
            'user' => $this->request->getPost('user'),

        ];

        $this->targetModel->insert($data);

        return redirect()->back()->with('success', 'Data Target Realisasi Kegiatan Berhasil Ditambahkan.');
    }

    public function up_target($id)
    {
        $target = $this->request->getPost('target');
        $user = $this->request->getPost('user');



        $data = [
            'target' => $target,
            'user' => $user,

        ];
        $this->targetModel->update($id, $data);
        return redirect()->back()->with('success', 'Data Target Realisasi Kegiatan Berhasil Diperbarui.');
    }

    public function destroy_target()
    {
        if ($this->request->isAJAX()) {
            $tar_id = $this->request->getVar('id');
            $this->targetModel->delete($tar_id);
            $result = [
                'success' => 'Data Target Realisasi Kegiatan Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            exit('404 Not Found');
        }
    }
}
