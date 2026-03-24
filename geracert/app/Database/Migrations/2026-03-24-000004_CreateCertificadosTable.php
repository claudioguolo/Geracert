<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCertificadosTable extends Migration
{
    public function up()
    {
        $this->db->query(<<<'SQL'
CREATE TABLE `certificados` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `indicativo` varchar(50) NOT NULL,
  `concurso` varchar(50) NOT NULL,
  `pontuacao` varchar(50) DEFAULT NULL,
  `nome` varchar(75) DEFAULT NULL,
  `ano` varchar(4) DEFAULT NULL,
  `clube` varchar(50) DEFAULT NULL,
  `tipo_evento` varchar(15) DEFAULT NULL,
  `geracao_data` varchar(16) DEFAULT NULL,
  `serial` varchar(20) DEFAULT NULL,
  `organizador` varchar(25) DEFAULT NULL,
  `modalidade` varchar(8) DEFAULT NULL,
  `categoria` varchar(40) DEFAULT NULL,
  `class_geral` varchar(30) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `operator` varchar(150) DEFAULT NULL,
  `km` varchar(10) DEFAULT NULL,
  `class_cont` varchar(30) DEFAULT NULL,
  `class_pais` varchar(30) DEFAULT NULL,
  `cod_clube` varchar(8) DEFAULT NULL,
  `clube_estacao` varchar(50) DEFAULT NULL,
  `identificador` varchar(512) DEFAULT NULL,
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
        $this->forge->dropTable('certificados', true);
    }
}
