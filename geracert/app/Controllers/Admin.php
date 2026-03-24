<?php

namespace App\Controllers;

use App\Models\CertConfigModel;
use App\Models\CertificadosModel;
use App\Models\ClubeModel;
use App\Models\UsuarioModel;

class Admin extends BaseController
{
    public function index()
    {
        $certConfigModel   = new CertConfigModel();
        $certificadosModel = new CertificadosModel();
        $clubeModel        = new ClubeModel();
        $usuarioModel      = new UsuarioModel();

        return view('admin', [
            'stats' => [
                'concursos'    => $certConfigModel->countAllResults(),
                'certificados' => $certificadosModel->countAllResults(),
                'clubes'       => $clubeModel->countAllResults(),
                'usuarios'     => $usuarioModel->countAllResults(),
            ],
        ]);
    }
}


