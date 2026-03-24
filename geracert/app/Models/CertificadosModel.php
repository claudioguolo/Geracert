<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificadosModel extends Model
{
    protected $table                = 'certificados';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'indicativo',
        'concurso',
        'pontuacao',
        'nome',
        'ano',
        'clube',
        'tipo_evento',
        'geracao_data',
        'serial',
        'organizador',
        'modalidade',
        'categoria',
        'class_geral',
        'status',
        'operator',
        'km',
        'class_cont',
        'class_pais',
        'cod_clube',
        'clube_estacao',
        'identificador',
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'         => 'permit_empty|is_natural_no_zero',
        'indicativo' => 'required|max_length[50]',
        'concurso'   => 'required|max_length[50]',
        'pontuacao'  => 'permit_empty|max_length[50]',
        'nome'       => 'permit_empty|max_length[75]',
        'ano'        => 'permit_empty|exact_length[4]|numeric',
        'clube'      => 'permit_empty|max_length[50]',
        'tipo_evento'=> 'permit_empty|max_length[15]',
        'organizador'=> 'permit_empty|max_length[25]',
        'modalidade' => 'permit_empty|max_length[8]',
        'categoria'  => 'permit_empty|max_length[40]',
        'class_geral'=> 'permit_empty|max_length[30]',
        'status'     => 'permit_empty|max_length[10]',
        'operator'   => 'permit_empty|max_length[150]',
        'km'         => 'permit_empty|max_length[10]',
        'class_cont' => 'permit_empty|max_length[30]',
        'class_pais' => 'permit_empty|max_length[30]',
        'cod_clube'  => 'permit_empty|max_length[8]',
        'clube_estacao' => 'permit_empty|max_length[50]',
        'identificador' => 'permit_empty|max_length[512]',
    ];
    protected $validationMessages   = [
        'indicativo' => [
            'required'   => 'Indicativo e obrigatorio.',
            'max_length' => 'Indicativo excede o tamanho permitido.',
        ],
        'concurso' => [
            'required'   => 'Concurso e obrigatorio.',
            'max_length' => 'Concurso excede o tamanho permitido.',
        ],
        'ano' => [
            'exact_length' => 'Ano deve ter 4 digitos.',
            'numeric'      => 'Ano deve conter apenas numeros.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];
}
