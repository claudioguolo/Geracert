<?php

namespace App\Controllers;

use App\Models\CertificadosModel;
use SebastianBergmann\Timer\Duration;

class Certificado extends BaseController
{

    ########################################################################

    private $certificadoModel;

    public function __construct()
    {

        $this->certificadoModel = new CertificadosModel();
    }

    ########################################################################

    public function index()
    {

        $certificados = $this->certificadoModel->findAll();

//        dd($certificados);
        return view('certificados', [
            'certificados' => $this->certificadoModel->paginate(15),
            'pager' => $this->certificadoModel->pager

        ]);
    }

    ########################################################################

    public function delete($id)
    {

        if ($this->certificadoModel->delete($id)) {

            echo view('messages', [
                'message' => 'certificado Excluido com sucesso'
            ]);
        } else {
            echo "Erro";
        }
    }


    ########################################################################

    public function create()
    {
        return view('certificadoform');
    }

    ########################################################################

    public function store()
    {
        if ($this->certificadoModel->save($this->request->getPost())) {

            return view("messages", [
                'message' => 'Novo certificado salvo com sucesso!',
                'redirect' =>  'certificado'
            ]);
        } else {
            echo "Ocorreu um erro ao salvar.";
        }
    }

    ########################################################################

    public function edit($id) {

        return view('certificadoform', [
            'certificado' => $this->certificadoModel->find($id)
        ]);
    }

    public function import() {

        echo 'teste'; 
    }
}
