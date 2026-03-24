<?php

namespace App\Models;

use CodeIgniter\Model;

class ClubeModel extends Model
{
    protected $table                = 'clubes';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'codigo', 
        'indicativo', 
        'clube', 
        'categoria',
        'status'
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    protected $validationRules      = [
        'id'         => 'permit_empty|is_natural_no_zero',
        'codigo'     => 'required|max_length[4]',
        'indicativo' => 'permit_empty|max_length[10]',
        'clube'      => 'required|max_length[100]',
        'categoria'  => 'permit_empty|max_length[10]',
        'status'     => 'permit_empty|max_length[10]',
    ];
    protected $validationMessages   = [
        'codigo' => [
            'required'   => 'Codigo e obrigatorio.',
            'max_length' => 'Codigo excede o tamanho permitido.',
        ],
        'clube' => [
            'required'   => 'Nome do clube e obrigatorio.',
            'max_length' => 'Nome do clube excede o tamanho permitido.',
        ],
    ];


}
