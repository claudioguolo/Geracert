<?php

namespace App\Controllers;

use App\Models\ClubeModel;
use App\Models\Clubes;
use SebastianBergmann\Timer\Duration;

class Clube extends BaseController
{

    ########################################################################

    private $clubeModel;

    public function __construct()
    {

        $this->clubeModel = new ClubeModel();
    }

    ########################################################################

    public function index()
    {

        //$clubes = $this->clubeModel->findAll();
        return view('clubes', [
            'clubes' => $this->clubeModel->paginate(15),
            'pager' => $this->clubeModel->pager

        ]);
    }

    ########################################################################

    public function delete($id)
    {

        if ($this->clubeModel->delete($id)) {

            echo view('messages', [
                'message' => 'Clube Excluido com sucesso'
            ]);
        } else {
            echo "Erro";
        }
    }

    ########################################################################

    public function create()
    {
        return view('clubeform');
    }

    ########################################################################

    public function store()
    {
        if ($this->clubeModel->save($this->request->getPost())) {

            return view("messages", [
                'message' => 'Novo Clube salvo com sucesso!',
                'redirect' =>  'clube'
            ]);
        } else {
            echo "Ocorreu um erro ao salvar.";
        }
    }

    ########################################################################

    public function edit($id) {

        return view('clubeform', [
            'clube' => $this->clubeModel->find($id)
        ]);
    }
}
