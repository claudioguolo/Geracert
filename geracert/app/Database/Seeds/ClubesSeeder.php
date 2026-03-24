<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClubesSeeder extends Seeder
{
    private const CLUBES = [
        ['codigo' => '001', 'indicativo' => null, 'clube' => '16 GRUPO ESCOTEIRO ANHANGA', 'categoria' => null, 'status' => null],
        ['codigo' => '002', 'indicativo' => null, 'clube' => '101GE/RJ', 'categoria' => null, 'status' => null],
        ['codigo' => '003', 'indicativo' => null, 'clube' => '144ZORIO', 'categoria' => null, 'status' => null],
        ['codigo' => '004', 'indicativo' => null, 'clube' => '24/RS SOCEPE', 'categoria' => null, 'status' => null],
        ['codigo' => '005', 'indicativo' => null, 'clube' => '599 DX GROUP', 'categoria' => null, 'status' => null],
        ['codigo' => '006', 'indicativo' => null, 'clube' => '69SC GRUPO ESCOTEIRO HELIODORO MUNIZ', 'categoria' => null, 'status' => null],
        ['codigo' => '007', 'indicativo' => null, 'clube' => '86 GRUPO ESCOTEIRO DAVID BARROS', 'categoria' => null, 'status' => null],
        ['codigo' => '008', 'indicativo' => null, 'clube' => 'ABRA', 'categoria' => null, 'status' => null],
        ['codigo' => '009', 'indicativo' => null, 'clube' => 'AFRR', 'categoria' => null, 'status' => null],
        ['codigo' => '010', 'indicativo' => null, 'clube' => 'APRE-ASSOCIACAO PAULISTA DE RADIOAMADORES ESCOTEIROS', 'categoria' => null, 'status' => null],
    ];

    public function run()
    {
        foreach (self::CLUBES as $clube) {
            $existing = $this->db->table('clubes')
                ->where('codigo', $clube['codigo'])
                ->get()
                ->getRowArray();

            if ($existing !== null) {
                $this->db->table('clubes')
                    ->where('id', $existing['id'])
                    ->update(array_merge($clube, ['updated_at' => date('Y-m-d H:i:s'), 'deleted_at' => null]));

                continue;
            }

            $this->db->table('clubes')->insert(array_merge($clube, [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ]));
        }
    }
}
