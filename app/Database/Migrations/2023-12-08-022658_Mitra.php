<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mitra extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mitra' => [
                'type'           => 'CHAR',
                'constraint'     => 16,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'role' => [
                'type'           => 'CHAR',
                'constraint'     => 3,
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
        $this->forge->addKey('id_mitra', true);
        $this->forge->createTable('mitra');
    }

    public function down()
    {
        $this->forge->dropTable('mitra');
    }
}
