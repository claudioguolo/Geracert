<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertformatTable extends Migration
{
    public function up()
    {
        $this->db->query(<<<'SQL'
CREATE TABLE `certformat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `html` longtext,
  `concurso` varchar(50) DEFAULT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `serial_text` longtext,
  `texto_text` longtext,
  `datetime_text` longtext,
  `size_h1` longtext,
  `size_h2` longtext,
  `size_h3` longtext,
  `size_h4` longtext,
  `size_h5` longtext,
  `size_h6` longtext,
  `organizador` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
SQL);
    }

    public function down()
    {
        $this->forge->dropTable('certformat', true);
    }
}
