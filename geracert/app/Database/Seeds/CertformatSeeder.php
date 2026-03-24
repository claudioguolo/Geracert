<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CertformatSeeder extends Seeder
{
    private const TEMPLATES = [
        [
            'concurso' => 'CVA-CW',
            'ano' => '2021',
            'organizador' => null,
            'imagem' => 'cva-2021.png',
            'html' => "<h4>Conferimos o presente certificado a</h4>\n<h3>\$nome  - \$indicativo</h3>\n<h4>\$class_geral</h4>\n<h3>\$categoria - \$modalidade</h3>\n<h4>\$pontuacao  pontos</h4>\n<h5>\$operador</h5>",
            'serial_text' => "position: fixed;\n  color: grey;\n  top: -13px;\n  left: -15px;\n  text-align: left;\n  border: solid 0px;\n  width: 20%;\n  height: 20%;",
            'texto_text' => 'position: fixed; top: 250px; text-align: center; left: 5%; vertical-align: middle;border: solid 0px;width: 90%;',
            'datetime_text' => "position: fixed;\n  color:grey;\n  top: -13px;\n  right: -25px;\n  text-align: left;\n  border: solid 0px;\n  width: 30%;\n  height: 6%;",
            'size_h1' => 'color: black;  text-align: center;  font-size: 45px;  line-height: 1;',
            'size_h2' => 'color: black;  text-align: center;  font-size: 35px;  line-height: 0.3;',
            'size_h3' => 'color: black;  text-align: center;  font-size: 30px;  line-height: 0.2;',
            'size_h4' => 'color: black;  text-align: center;  font-size: 25px;  line-height: 0.9;',
            'size_h5' => 'color: black;  text-align: center;  font-size: 23px;  line-height: 0.0;',
            'size_h6' => 'color: grey;  text-align: center;  font-size: 15px;  line-height: 0.2;',
        ],
        [
            'concurso' => 'CQWS',
            'ano' => '2022',
            'organizador' => null,
            'imagem' => 'cqws2022.png',
            'html' => "<h2> \$indicativo </h2>\n<h3> - \$nome - </h3>\n<h5>\$class_geral - \$categoria - \$modalidade com \$pontuacao pontos </h5>",
            'serial_text' => 'position: fixed;  color: grey;  bottom: -110px;  left: 0px;  text-align: left;  border: solid 0px;  width: 20%;  height: 20%;',
            'texto_text' => 'position: fixed;  top: 22.6rem;  right: 34%;  text-align: center;  vertical-align: middle;  border: solid 0px; width: 63%;',
            'datetime_text' => 'position: fixed;  color:grey;  bottom: -11px;  left: 450px;  text-align: left;  border: solid 0px;  width: 30%;  height: 6%;',
            'size_h1' => 'color: black;  text-align: center;  font-size: 45px;  line-height: 0.3;',
            'size_h2' => 'color: black;  text-align: center;  font-size: 36px;  line-height: 0.2;',
            'size_h3' => 'color: black;  text-align: center;  font-size: 26px;  line-height: 0.1;',
            'size_h4' => 'color: black;  text-align: center;  font-size: 25px;  line-height: 0.2;',
            'size_h5' => 'color: black;  text-align: center;  font-size: 20px;  line-height: 0.1;',
            'size_h6' => 'color: grey;  text-align: center;  font-size: 15px;  line-height: 0.5;',
        ],
    ];

    public function run()
    {
        foreach (self::TEMPLATES as $template) {
            $existing = $this->db->table('certformat')
                ->where('concurso', $template['concurso'])
                ->where('ano', $template['ano'])
                ->get()
                ->getRowArray();

            if ($existing !== null) {
                $this->db->table('certformat')
                    ->where('id', $existing['id'])
                    ->update(array_merge($template, ['updated_at' => date('Y-m-d H:i:s'), 'deleted_at' => null]));

                continue;
            }

            $this->db->table('certformat')->insert(array_merge($template, [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'deleted_at' => null,
            ]));
        }
    }
}
