<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeleteColumn extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('progress_kegiatan', 'target');
    }

    public function down()
    {
        //
    }
}
