<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KegiatanController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Daftar Kegiatan',
            'daftar_kegiatan' => $this->KegiatanModel->orderBy('id_kegiatan', 'DESC')->findAll()

        ];
        return view('admin/kegiatan/index', $data);
    }
    public function store()
    {
        $nama_kegiatan = $this->request->getPost('nama_kegiatan');
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        $tgl_selesai = $this->request->getPost('tgl_selesai');

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

        ];
        $this->KegiatanModel->insert($data);
        return redirect()->back()->with('success', 'Data Kegiatan Berhasil Ditambahkan.');
    }
    public function update($id_kegiatan)
    {
        $nama_kegiatan = $this->request->getPost('nama_kegiatan');
        $tgl_mulai = $this->request->getPost('tgl_mulai');
        $tgl_selesai = $this->request->getPost('tgl_selesai');

        // Check if $nama_kegiatan is not null and is a string
        if (!is_null($nama_kegiatan) && is_string($nama_kegiatan)) {
            $slug = url_title($nama_kegiatan, '-', TRUE);
            // Continue with the rest of your code
        } else {
            // Handle the case where $nama_kegiatan is null or not a string
            // You can return an error message or perform other actions here.
        }
        $data = [
            'nama_kegiatan' => esc($nama_kegiatan),
            'slug_kegiatan' => $slug,
            'tgl_mulai' => $tgl_mulai,
            'tgl_selesai' => $tgl_selesai,

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
}
