<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kelurahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_kelurahan' => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
            ],
            'kode_kecamatan' => [
                'type'           => 'VARCHAR',
                'constraint'     => 7,
            ],
            'nama_kel_des' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('kode_kelurahan', true);
        $this->forge->addForeignKey('kode_kecamatan', 'kecamatan', 'kode_kecamatan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelurahan');
    }

    public function down()
    {
        $this->forge->dropTable('kelurahan');
    }
}
