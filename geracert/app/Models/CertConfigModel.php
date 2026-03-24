<?php


namespace App\Models;

use CodeIgniter\Model;

class CertConfigModel extends Model
{
    protected $table                = 'certformat';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'html',
        'texto_text',
        'concurso',
        'organizador',
        'ano',
        'imagem',
        'serial_text',
        'datetime_text',
        'size_h1',
        'size_h2',
        'size_h3',
        'size_h4',
        'size_h5',
        'size_h6',
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id'            => 'permit_empty|is_natural_no_zero',
        'concurso'      => 'required|max_length[50]',
        'ano'           => 'permit_empty|exact_length[4]|numeric',
        'organizador'   => 'permit_empty|max_length[50]',
        'imagem'        => 'permit_empty|max_length[100]',
        'html'          => 'permit_empty',
        'texto_text'    => 'permit_empty',
        'serial_text'   => 'permit_empty',
        'datetime_text' => 'permit_empty',
        'size_h1'       => 'permit_empty',
        'size_h2'       => 'permit_empty',
        'size_h3'       => 'permit_empty',
        'size_h4'       => 'permit_empty',
        'size_h5'       => 'permit_empty',
        'size_h6'       => 'permit_empty',
    ];
    protected $validationMessages   = [
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
