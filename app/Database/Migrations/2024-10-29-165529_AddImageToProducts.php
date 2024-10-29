<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'quantity' // Place it after the quantity column
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'image');
    }
}
