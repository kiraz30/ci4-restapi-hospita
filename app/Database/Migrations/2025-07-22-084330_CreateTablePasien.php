<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'nama_pasien' => [
                'type' => 'VARCHAR',
                'constraint'=>300,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'constraint'=>300,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint'=>300,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint'=>14,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint'=>300,
            ],
            'created_at datetime default current_timestamp' ,
            'updated_at datetime default current_timestamp on update current_timestamp' ,

        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pasien');
    }

    public function down()
    {
        $this->forge->dropTable('pasien');
    }
}
