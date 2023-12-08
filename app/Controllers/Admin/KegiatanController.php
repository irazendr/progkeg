<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProgressModel;
use App\Models\TargetModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\PermissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xls as XlsReader;
use DateTime;


class KegiatanController extends BaseController
{

    protected $progressModel, $targetModel, $userModel, $permissionModel;
    protected $db, $builder, $builder2, $builder3, $builder4, $query, $query2, $query3, $query4;
    public function __construct()
    {
        // Memuat library Myth/Auth
        $this->userModel                    = new UserModel();
        $this->permissionModel              = new PermissionModel();
        $this->progressModel                = new ProgressModel();
        $this->targetModel                  = new TargetModel();

        $this->db                           = \config\Database::connect();
        $this->builder                      = $this->db->table('progress_target');
        $this->builder->select('progress_kegiatan.id as prog_id, progress_kegiatan.kode_kegiatan as id_keg, daftar_kegiatan.kode_kegiatan as kode_keg, tipe_kegiatan, nama_kegiatan, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k');
        $this->builder->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan');
        $this->builder->join('progress_kegiatan', 'progress_kegiatan.kode_kegiatan =  daftar_kegiatan.kode_kegiatan');
        $this->builder->join('users', 'users.username =  progress_kegiatan.user');
        // $this->builder->join('auth_users_permissions', 'auth_users_permissions.user_id =  users.id');
        // $this->builder->join('auth_permissions', 'auth_permissions.id= auth_users_permissions.permission_id');
        $this->query                        = $this->builder->get();

        $this->builder2                     = $this->db->table('daftar_kegiatan');
        $this->builder2->select('daftar_kegiatan.kode_kegiatan as id_k, progress_target.id as id_t, progress_target.kode_kegiatan as id_keg, tipe_kegiatan,nama_kegiatan, progress_target.target, progress_target.tgl_input as tgl_masuk, progress_target.user as user_t');
        $this->builder2->join('progress_target', 'progress_target.kode_kegiatan = daftar_kegiatan.kode_kegiatan');
        $this->query2                       = $this->builder2->get();

        $this->builder3                     = $this->db->table('daftar_kegiatan');
        $this->builder3->select('kode_kegiatan, nama_kegiatan');
        $this->query3                       = $this->builder3->get();

        // // Mendapatkan user ID dari sesi
        // $session = session();
        // $userID = $session->get('logged_in');

        // // Mendapatkan informasi pengguna dari database
        // $userInfo = $this->userModel->find($userID);

        $this->builder4                     = $this->db->table('daftar_kegiatan');
        $this->builder4->select('daftar_kegiatan.kode_kegiatan as id_keg, tipe_kegiatan, nama_kegiatan, tgl_mulai, tgl_selesai, daftar_kegiatan.tgl_ubah, daftar_kegiatan.tgl_input AS tgl_masuk, daftar_kegiatan.user AS user_k');
        $this->builder4->join('users', 'users.username = daftar_kegiatan.user');
        // $this->builder4->join('auth_users_permissions', 'auth_users_permissions.user_id = users.id');
        // $this->builder4->join('auth_permissions', 'auth_permissions.id = auth_users_permissions.permission_id');
        // $this->builder4->where('auth_users_permissions.user_id', $userInfo->id);
        $this->query4                       = $this->builder4->get();
        // dd($this->query4->getResult());
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Kegiatan',
            'daftar_kegiatan' => $this->query4->getResult(),
            'list_keg' => $this->query2->getResult(),

        ];
        return view('admin/kegiatan/index', $data);
    }
    public function store()
    {
        $kode_kegiatan                      = $this->request->getPost('kode_kegiatan');
        $nama_kegiatan                      = $this->request->getPost('nama_kegiatan');
        $tipe_kegiatan                      = $this->request->getPost('tipe_kegiatan');
        $tgl_mulai                          = $this->request->getPost('tgl_mulai');
        $tgl_selesai                        = $this->request->getPost('tgl_selesai');
        $user                               = $this->request->getPost('user');
        // dd($kode_kegiatan);
        // Check if $nama_kegiatan is not null and is a string
        if (!is_null($nama_kegiatan) && is_string($nama_kegiatan)) {
            $slug                           = url_title($nama_kegiatan, '-', TRUE);
            // Continue with the rest of your code
        }
        $data = [
            'kode_kegiatan' => $kode_kegiatan,
            'nama_kegiatan' => esc($nama_kegiatan),
            'tipe_kegiatan' => $tipe_kegiatan,
            'slug_kegiatan' => $slug,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'user' => $user,

        ];
        $this->KegiatanModel->insert($data);
        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Ditambahkan.');
    }
    public function update($kode_kegiatan)
    {
        $nama_kegiatan                      = $this->request->getPost('nama_kegiatan');
        $tipe_kegiatan                      = $this->request->getPost('tipe_kegiatan');
        $tgl_mulai                          = $this->request->getPost('tgl_mulai');
        $tgl_selesai                        = $this->request->getPost('tgl_selesai');
        $user                               = $this->request->getPost('user');

        // Check if $nama_kegiatan is not null and is a string
        if (!is_null($nama_kegiatan) && is_string($nama_kegiatan)) {
            $slug                           = url_title($nama_kegiatan, '-', TRUE);
        }
        $data = [
            'nama_kegiatan' => esc($nama_kegiatan),
            'tipe_kegiatan' => $tipe_kegiatan,
            'slug_kegiatan' => $slug,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'user' => $user,

        ];
        $this->KegiatanModel->update($kode_kegiatan, $data);
        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Diubah.');
    }
    public function destroy()
    {
        if ($this->request->isAJAX()) {
            $kode_kegiatan                  = $this->request->getVar('kode_kegiatan');
            $this->KegiatanModel->delete($kode_kegiatan);
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
            'daftar_kegiatan' => $this->query->getResult(),
            'list_keg' => $this->query2->getResult(),

        ];
        // dd($this->query->getResult());
        return view('admin/kegiatan/progress', $data);
    }

    public function progress()
    {
        $kode_kegiatan                      = $this->request->getPost('kode_kegiatan');
        $realisasi                          = $this->request->getPost('realisasi');
        $user                               = $this->request->getPost('user');
        $tgl_input                          = $this->request->getPost('tgl_input');


        $data = [
            'kode_kegiatan' => $kode_kegiatan,
            'realisasi' => $realisasi,
            'user' => $user,
            'tgl_input' => $tgl_input,
            'tgl_update' => $tgl_input,

        ];

        // Use a new builder instance for the current query
        $currentQuery                       = clone $this->builder;
        $currentQuery2                      = clone $this->builder;
        $currentQuery->select('progress_kegiatan.id as prog_id, progress_kegiatan.kode_kegiatan as id_keg, tipe_kegiatan, nama_kegiatan, progress_target.id as target_id, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k')
            ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan')
            ->join('progress_kegiatan', 'progress_kegiatan.kode_kegiatan =  daftar_kegiatan.kode_kegiatan')
            ->join('users', 'users.username =  progress_kegiatan.user');

        // Apply the where condition to the current query
        $results                            = $currentQuery->where('progress_target.kode_kegiatan', $kode_kegiatan)->get()->getResult();
        // dd($results);
        // Check if $results is not empty before accessing its elements
        if (!empty($results)) {
            $target                         = $results[0]->target;
            $target_id                      = $results[0]->target_id;
            // Menghitung total realisasi untuk kegiatan tersebut
            $total_realisasi                = 0;

            foreach ($results as $result) {
                $total_realisasi            += $result->realisasi;
            }

            // Menambahkan realisasi baru ke total realisasi
            $total_realisasi                += $realisasi;

            // Memasukkan total realisasi ke dalam data
            $data['total_realisasi']        = $total_realisasi;
            $data['id_target']              = $target_id;

            if ($total_realisasi < $target) {
                $this->progressModel->insert($data);
                return redirect()->back()->with('success', 'Data Progress Kegiatan Berhasil Ditambahkan.');
            } else {
                // dd($total_realisasi,$target);
                return redirect()->back()->with('error', 'Gagal Menambahkan. Progress Kegiatan Melebihi Target!');
            }
        } else {
            $currentQuery2->select('*')
                ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan');

            // Apply the where condition to the current query
            $results                        = $currentQuery2->where('progress_target.kode_kegiatan', $kode_kegiatan)->get()->getResult();
            // dd($results);
            $target                         = $results[0]->target;
            $target_id                      = $results[0]->id;

            $total_realisasi                = 0;

            // Menambahkan realisasi baru ke total realisasi
            $total_realisasi                += $realisasi;

            // Memasukkan total realisasi ke dalam data
            $data['total_realisasi']        = $total_realisasi;
            $data['id_target']              = $target_id;

            if ($total_realisasi < $target) {
                $this->progressModel->insert($data);
                return redirect()->back()->with('success', 'Data Progress Kegiatan Berhasil Ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'Gagal Mengimport. Progress Kegiatan Melebihi Target!');
            }
        }
    }


    public function import_progress()
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

        // dd($sheet);
        $success                            = true; // Assume success by default

        foreach ($sheet as $key => $value) {
            if ($key === 0) {
                continue;
            }

            $kode_kegiatan                  = $value[2];
            $realisasi                      = $value[5];
            $user                           = $this->request->getPost('user');
            $tgl_input_string               = $value[1];

            // Convert the string to a DateTime object
            $dateObject                     = DateTime::createFromFormat('m/d/Y', $tgl_input_string);

            $tgl_input                      = $dateObject->format('Y-m-d');

            $data = [
                'kode_kegiatan' => $kode_kegiatan,
                'realisasi' => $realisasi,
                'user' => $user,
                'tgl_input' => $tgl_input,
                'tgl_update' => $tgl_input,
            ];

            // Use a new builder instance for the current query
            $currentQuery                   = clone $this->builder;
            $currentQuery2                  = clone $this->builder;
            $currentQuery->select('progress_kegiatan.id as prog_id, progress_kegiatan.kode_kegiatan as id_keg, tipe_kegiatan, nama_kegiatan, progress_target.id as target_id, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k')
                ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan')
                ->join('progress_kegiatan', 'progress_kegiatan.kode_kegiatan =  daftar_kegiatan.kode_kegiatan')
                ->join('users', 'users.username =  progress_kegiatan.user')
                ->where('progress_target.kode_kegiatan', $kode_kegiatan);

            // Apply the where condition to the current query
            $results                        = $currentQuery->get()->getResult();
            // dd($data);
            // Jika ada hasil dari query
            if (!empty($results)) {
                $target                     = $results[0]->target;
                $target_id                  = $results[0]->target_id;
                // Menghitung total realisasi untuk kegiatan tersebut
                $total_realisasi            = array_sum(array_column($results, 'realisasi'));

                // Menambahkan realisasi baru ke total realisasi
                $total_realisasi            += $realisasi;

                // Memasukkan total realisasi ke dalam data
                $data['total_realisasi']    = $total_realisasi;
                $data['id_target']          = $target_id;

                if ($total_realisasi < $target) {
                    $this->progressModel->insert($data);
                } else {
                    // Set $success to false and exit the loop if target is exceeded
                    $success                = false;
                    break;
                }
            } else {
                $currentQuery2->select('*')
                    ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan');

                // Apply the where condition to the current query
                $results                    = $currentQuery2->where('progress_target.kode_kegiatan', $kode_kegiatan)->get()->getResult();

                $target                     = $results[0]->target;
                $target_id                  = $results[0]->id;

                $total_realisasi            = 0;

                // Menambahkan realisasi baru ke total realisasi
                $total_realisasi            += $realisasi;

                // Memasukkan total realisasi ke dalam data
                $data['total_realisasi']    = $total_realisasi;
                $data['id_target']          = $target_id;

                if ($total_realisasi < $target) {
                    $this->progressModel->insert($data);
                } else {
                    $success                = false;
                    break;
                }
            }
        }

        if ($success) {
            return redirect()->back()->with('success', 'Data Progress Kegiatan Berhasil Diimport.');
        } else {
            return redirect()->back()->with('error', 'Gagal Mengimport. Terdapat kesalahan pada data.');
        }
    }





    public function up_progress($id) // update masih error
    {
        // dd($id);
        // $target = $this->request->getPost('target');
        $realisasi                          = $this->request->getPost('realisasi');
        $user                               = $this->request->getPost('user');
        $tgl_update                         = $this->request->getPost('tgl_update');


        $data = [
            // 'target' => $target,
            'realisasi' => $realisasi,
            'user' => $user,
            'tgl_update' => $tgl_update,

        ];
        // Use a new builder instance for the current query
        $currentQuery                       = clone $this->builder;
        $currentQuery->select('progress_kegiatan.id as prog_id, progress_kegiatan.kode_kegiatan as id_keg, tipe_kegiatan, nama_kegiatan, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k')
            ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan')
            ->join('progress_kegiatan', 'progress_kegiatan.kode_kegiatan =  daftar_kegiatan.kode_kegiatan');
        $currentQuery2                      = clone $this->builder;
        $currentQuery2->select('progress_kegiatan.id as prog_id, progress_kegiatan.kode_kegiatan as id_keg, nama_kegiatan, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k')
            ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_target.kode_kegiatan')
            ->join('progress_kegiatan', 'progress_kegiatan.kode_kegiatan =  daftar_kegiatan.kode_kegiatan');

        // Apply the where condition to the current query
        $resultsByID                        = $currentQuery->where('progress_kegiatan.id', $id)->get()->getResult();
        // dd($resultsByID);
        $target                             = $resultsByID[0]->target;
        $kode_kegiatan                      = $resultsByID[0]->id_keg;
        $results                            = $currentQuery2->where('progress_kegiatan.kode_kegiatan', $kode_kegiatan)->get()->getResult();

        // dd($resultsByID,$results) ;

        // Jika ada hasil dari query
        if (!empty($results)) {
            // Menghitung total realisasi untuk kegiatan tersebut
            $total_realisasi                = 0;

            foreach ($results as $result) {
                $total_realisasi            += $result->realisasi;
            }

            // Memasukkan total realisasi ke dalam data
            $data['total_realisasi']        = $total_realisasi;

            if ($total_realisasi < $target) {
                $this->progressModel->update($id, $data);
                return redirect()->back()->with('success', 'Progress Kegiatan Berhasil Diperbarui.');
            } else {
                // dd($total_realisasi,$target);
                return redirect()->back()->with('error', 'Gagal Memperbarui. Progress Realisasi Kegiatan Melebihi Target!');
            }
        }
    }

    public function destroy_progress()
    {
        if ($this->request->isAJAX()) {
            $prog_id                        = $this->request->getVar('id');
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
        $validation                         = \Config\Services::validation();

        // Run the validation
        if ($this->request->withMethod('post') && !$this->validate($this->targetModel->validationRules)) {
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
            'kode_kegiatan' => $this->request->getPost('kode_kegiatan'),
            'target' => $this->request->getPost('target'),
            'user' => $this->request->getPost('user'),

        ];

        $this->targetModel->insert($data);

        return redirect()->back()->with('success', 'Data Target Realisasi Kegiatan Berhasil Ditambahkan.');
    }

    // public function import_target()
    // {
    //     $file                                   = $this->request->getFile('file');
    //     // dd($file);
    //     $ext                                    = $file->getExtension();


    //     if ($ext === "xls") {
    //         $reader                             = new XlsReader();
    //     } else {
    //         $reader                             = new XlsxReader();
    //     }
    //     $spreadsheet                            = $reader->load($file);
    //     $sheet                                  = $spreadsheet->getActiveSheet()->toArray();

    //     // dd($sheet);
    //     $success                                = false;
    //     foreach ($sheet as $key => $value) {
    //         if ($key === 0) {
    //             continue;
    //         } else {


    //             $kode_kegiatan                    = $value[2];
    //             $realisasi                      = $value[4];
    //             $user                           = $this->request->getPost('user');
    //             $tgl_input_string               = $value[1];

    //             // Convert the string to a DateTime object
    //             $dateObject                     = DateTime::createFromFormat('m/d/Y', $tgl_input_string);

    //             // Format the DateTime object as a string with the desired format
    //             $tgl_input                      = $dateObject->format('Y-m-d');
    //             // dd($tgl_input);
    //             $data = [
    //                 'kode_kegiatan' => $kode_kegiatan,
    //                 'realisasi' => $realisasi,
    //                 'user' => $user,
    //                 'tgl_input' => $tgl_input,
    //                 'tgl_update' => $tgl_input,

    //             ];
    //             // Use a new builder instance for the current query
    //             $currentQuery                   = clone $this->builder;
    //             $currentQuery->select('progress_kegiatan.id as prog_id, progress_kegiatan.kode_kegiatan as id_keg, nama_kegiatan, target, realisasi, tgl_mulai, tgl_selesai, progress_kegiatan.tgl_update, progress_kegiatan.tgl_input as tgl_masuk, progress_kegiatan.user as user_k')
    //                 ->join('daftar_kegiatan', 'daftar_kegiatan.kode_kegiatan =  progress_kegiatan.kode_kegiatan')
    //                 ->join('progress_target', 'progress_target.kode_kegiatan =  daftar_kegiatan.kode_kegiatan')
    //                 ->join('users', 'users.username =  progress_target.user');

    //             // Apply the where condition to the current query
    //             $results                        = $currentQuery->where('progress_kegiatan.kode_kegiatan', $kode_kegiatan)->get()->getResult();
    //             // dd($currentQuery->get()->getResult());
    //             // dd($results);
    //             $target                         = $results[0]->target;

    //             // Jika ada hasil dari query
    //             if (!empty($results)) {
    //                 // Menghitung total realisasi untuk kegiatan tersebut
    //                 $total_realisasi            = 0;

    //                 foreach ($results as $result) {
    //                     $total_realisasi        += $result->realisasi;
    //                 }

    //                 // Menambahkan realisasi baru ke total realisasi
    //                 $total_realisasi            += $realisasi;

    //                 // Memasukkan total realisasi ke dalam data
    //                 $data['total_realisasi']    = $total_realisasi;

    //                 if ($total_realisasi < $target) {
    //                     $this->progressModel->insert($data);
    //                     $success                = true;
    //                 } else {
    //                     // dd($total_realisasi,$target);
    //                     return redirect()->back()->with('error', 'Gagal Mengimport. Progress Kegiatan Melebihi Target!');
    //                 }
    //             }
    //         }
    //     }
    //     if ($success) {
    //         return redirect()->back()->with('success', 'Data Progress Kegiatan Berhasil Diimport.');
    //     }
    // }

    public function up_target($id)
    {
        $target                             = $this->request->getPost('target');
        $user                               = $this->request->getPost('user');



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
            $tar_id                         = $this->request->getVar('id');
            $this->targetModel->delete($tar_id);
            $result = [
                'success' => 'Data Target Realisasi Kegiatan Berhasil Dihapus.'
            ];
            echo json_encode($result);
        } else {
            exit('404 Not Found');
        }
    }
    public function export_excel()
    {
        $spreadsheet                        = new Spreadsheet();
        $activeWorksheet                    = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Tanggal Input');
        $activeWorksheet->setCellValue('C1', 'ID Kegiatan');
        $activeWorksheet->setCellValue('D1', 'Nama Kegiatan');
        $activeWorksheet->setCellValue('E1', 'Tanggal Mulai');
        $activeWorksheet->setCellValue('F1', 'Tanggal Selesai');
        $activeWorksheet->setCellValue('G1', 'Target');
        $activeWorksheet->setCellValue('H1', 'Realisasi');
        $activeWorksheet->setCellValue('I1', 'User');
        $activeWorksheet->setCellValue('J1', 'Tanggal Diperbarui');

        $row                                = 2;
        $laporan                            = $this->query->getResult();

        foreach ($laporan as $key => $item) {
            $activeWorksheet
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $item->tgl_masuk)
                ->setCellValue('C' . $row, $item->id_keg)
                ->setCellValue('D' . $row, $item->nama_kegiatan)
                ->setCellValue('E' . $row, $item->tgl_mulai)
                ->setCellValue('F' . $row, $item->tgl_selesai)
                ->setCellValue('G' . $row, $item->target)
                ->setCellValue('H' . $row, $item->realisasi)
                ->setCellValue('I' . $row, $item->user_k)
                ->setCellValue('J' . $row, $item->tgl_update);
            $row++;
        }


        $filename                           = "laporan-progress-kegiatan (" . date("Y-m-d H:i:s") . ")";

        $writer                             = new XlsxWriter($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
