<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProgressTarget extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_kegiatan' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'target' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'tgl_input' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tgl_update' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // Correct foreign key references based on the provided `daftar_kegiatan` migration
        $this->forge->addForeignKey('kode_kegiatan', 'daftar_kegiatan', 'kode_kegiatan', 'CASCADE', 'CASCADE');

        try {
            // Attempt to create the table
            $this->forge->createTable('progress_target');
        } catch (\Exception $e) {
            // Print any additional information about the exception
            die($e->getMessage());
        }
    }

    public function down()
    {
        $this->forge->dropTable('progress_target');
    }
}
