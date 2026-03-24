<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCiSessionsTable extends Migration
{
    public function up()
    {
        $this->db->query(<<<'SQL'
CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL);
    }

    public function down()
    {
        $this->forge->dropTable('ci_sessions', true);
    }
}
