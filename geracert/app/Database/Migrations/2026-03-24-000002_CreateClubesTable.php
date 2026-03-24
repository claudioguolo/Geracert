<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClubesTable extends Migration
{
    public function up()
    {
        $this->db->query(<<<'SQL'
CREATE TABLE `clubes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(4) NOT NULL,
  `indicativo` varchar(10) DEFAULT NULL,
  `clube` varchar(100) NOT NULL,
  `categoria` varchar(10) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
SQL);
    }

    public function down()
    {
        $this->forge->dropTable('clubes', true);
    }
}
