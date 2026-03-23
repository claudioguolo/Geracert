<?php


namespace App\Models;

use CodeIgniter\Model;

class CertConfigModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'certformat';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = true;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id',
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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
