<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestDataSeeder extends Seeder
{
    private const HASH = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

    public function run()
    {
        $this->db->table('usuarios')->truncate();
        $this->db->table('usuarios')->insertBatch([
            [
                'nome' => 'Administrador',
                'email' => 'admin@geracert.local',
                'permissoes' => 'admin',
                'senha' => password_hash('admin123456', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'nome' => 'Editor',
                'email' => 'editor@geracert.local',
                'permissoes' => 'editor',
                'senha' => password_hash('editor123456', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
        ]);

        $this->db->table('certificados')->truncate();

        $rows = [
            [
                'indicativo' => 'PY9TEST',
                'concurso' => 'CQWS',
                'pontuacao' => '150',
                'nome' => 'Operador Teste',
                'ano' => '2022',
                'clube' => '',
                'tipo_evento' => 'contest',
                'geracao_data' => '24-03-2026 11:00',
                'serial' => 'TESTSERIAL2026',
                'organizador' => 'UEB',
                'modalidade' => 'CW',
                'categoria' => 'SINGLE',
                'class_geral' => '1 Lugar Geral',
                'status' => 'd',
                'operator' => 'Operador Teste',
                'km' => '0',
                'class_cont' => '1',
                'class_pais' => '1',
                'cod_clube' => '',
                'clube_estacao' => '',
                'identificador' => self::HASH,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'indicativo' => 'PP0CLUB',
                'concurso' => 'CQWS',
                'pontuacao' => '99',
                'nome' => '',
                'ano' => '2022',
                'clube' => '16 GRUPO ESCOTEIRO ANHANGA',
                'tipo_evento' => 'contest',
                'geracao_data' => null,
                'serial' => null,
                'organizador' => 'UEB',
                'modalidade' => 'SSB',
                'categoria' => 'CLUBE',
                'class_geral' => 'Top Clube',
                'status' => 'd',
                'operator' => 'Radio Clube',
                'km' => '0',
                'class_cont' => '1',
                'class_pais' => '1',
                'cod_clube' => '001',
                'clube_estacao' => '16 GRUPO ESCOTEIRO ANHANGA',
                'identificador' => str_repeat('b', 64),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
        ];

        $this->db->table('certificados')->insertBatch($rows);
    }
}
