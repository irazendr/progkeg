<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Myth\Auth\Models\UserModel;
use App\Models\GroupAkunModel;
use App\Models\AkunModel;
use Myth\Auth\Password;


class AkunController extends BaseController
{
    protected $userModel, $groupAkunModel, $akunModel;
    protected $db, $builder, $builder2, $query, $query2;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->groupAkunModel = new GroupAkunModel();
        $this->akunModel = new AkunModel();
        $this->db = \config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, nama_lengkap, username, email, name,created_at, auth_groups.id as list_role, auth_groups_users.group_id as roleid');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->query = $this->builder->get();

        $this->builder2 = $this->db->table('auth_groups');
        $this->builder2->select('id, name');
        $this->query2 = $this->builder2->get();
    }
    public function index()
    {
        $data = [
            'title' => 'Data Akun',
            'data_akun' => $this->query->getResult(),
            'list_role' => $this->query2->getResult()

        ];
        return view('admin/akun/index', $data);
    }

    public function ubah($id)
    {
        // Retrieve data from both tables
        $userData = $this->akunModel->find($id);
        $groupData = $this->groupAkunModel->find($id);

        if (!$userData || !$groupData) {
            return redirect()->back()->with('error', 'Data Tidak Ditemukan.');
        }

        // Updated data
        $name = $this->request->getPost('nama_lengkap');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('group_id');
        $password = '1234';
        $hashedPassword = Password::hash($password);
        $isMatch = Password::verify($password, $hashedPassword);
        $needsRehash = Password::needsRehash($hashedPassword, PASSWORD_DEFAULT);


        $data1 = [
            'nama_lengkap' => $name,
            'username' => $username,
            'email' => $email,
            'password_hash' => $hashedPassword,
        ];

        $data2 = [
            'group_id' => $role,
        ];


        // Check if data has changed
        $userDataChanged = $this->checkIfDataChanged($userData, $data1);
        $groupDataChanged = $this->checkIfDataChanged($groupData, $data2);

        // dd($userDataChanged,$groupDataChanged);


        if ($userDataChanged && $groupDataChanged) {
            $userData = $this->userModel->find($id);
            $userData->fill($data1);
            $this->userModel->save($userData);
            $this->groupAkunModel->update($id, $data2);
        } elseif ($userDataChanged) {
            $userData = $this->userModel->find($id);
            $userData->fill($data1);
            $this->userModel->save($userData);
        }
        if ($groupDataChanged) {
            $this->groupAkunModel->update($id, $data2);
        }


        return redirect()->back()->with('success', 'Data Akun Berhasil Diubah.');
    }

    private function checkIfDataChanged($entity, $data)
    {
        foreach ($data as $field => $value) {
            // Assume properties or public getter methods
            if ($entity->$field !== $value) {
                return true;
            }
        }

        return false;
    }

    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $id_user = $this->request->getVar('id');
            $this->userModel->delete($id_user);
            $result = [
                'success' => 'Data Akun Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            return redirect()->back()->with('error', 'Terjadi Kesalahan Pada Sistem!');
        }
    }
    // public function reset()
    // {
    //     if ($this->request->isAJAX()) {
    //         $id_user = $this->request->getVar('id');
    //         $auth = service('authentication');
    //         $hashedPassword = $auth->hashPassword('1234');
    //         $this->userModel->save([
    //             'id' => $id_user,
    //             'password_hash' => $hashedPassword,
    //         ]);
    //         $result = [
    //             'success' => 'Password Akun Berhasil Direset.'
    //         ];
    //         echo json_encode($result);
    //     } else {
    //         exit('404 Not Found');
    //     }
    // }
}
