<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kecamatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode_kecamatan' => [
                'type'           => 'VARCHAR',
                'constraint'     => 7,
            ],
            'nama_kec' => [
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
        $this->forge->addKey('kode_kecamatan', true);
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropTable('kecamatan');
    }
}
