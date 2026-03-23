<?php


namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    //protected $DBGroup              = 'default';
    protected $table                = 'usuarios';
    //protected $primaryKey           = 'id';
    //protected $useAutoIncrement     = true;
   // protected $insertID             = 0;
   // protected $returnType           = 'object';
   // protected $useSoftDeletes       = true;
    //protected $protectFields        = true;
    protected $allowedFields        = [

        'nome',
        'email',
        'senha',
        'permissoes'
    ];

    // Dates
    //protected $useTimestamps        = false;
    //protected $dateFormat           = 'datetime';
    //protected $createdField         = 'created_at';
    //protected $updatedField         = 'updated_at';
    //protected $deletedField         = 'deleted_at';



    public function getByEmail(string $email) : array {

        
        $rq = $this->where('email', $email)->first();
        
        return !is_null($rq) ? $rq : [];
    }

    public function getByName(string $nome) : array {

        
        $rq = $this->where('nome', $nome)->first();

        //dd($rq);
        
        return !is_null($rq) ? $rq : [];
    }

}
