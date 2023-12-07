<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DaftarKegiatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_kegiatan' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tgl_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tgl_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tgl_input' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tgl_ubah' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('kode_kegiatan', true);
        $this->forge->createTable('daftar_kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('daftar_kegiatan');
    }
}
