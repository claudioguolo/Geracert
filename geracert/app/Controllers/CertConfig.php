<?php

namespace App\Controllers;

use App\Models\CertConfigModel;
use SebastianBergmann\Timer\Duration;

class CertConfig extends BaseController
{


    ########################################################################

    private $certconfigModel;

    public function __construct()
    {

        $this->certconfigModel = new CertConfigModel();
    }


    ########################################################################

    public function index()
    {

    //dd($this->certFormatModel->findAll());
    
        return view('certconfig', [
            'certconfigs' => $this->certconfigModel->paginate(15),
            'pager' => $this->certconfigModel->pager

        ]);
    }

    ########################################################################

    public function delete($id)
    {

        if ($this->certconfigModel->delete($id)) {

            echo view('messages', [
                'message' => 'certconfig Excluido com sucesso',
                'redirect' =>  'certconfig'
            ]);
        } else {
            echo "Erro";
        }
    }


    ########################################################################

    public function create()
    {
        return view('certconfigform');
    }

    ########################################################################

    public function store()
    {
        if ($this->certconfigModel->save($this->request->getPost())) {

            $id= ($this->request->getPost('id'));

            return view("messages", [
               'message' => ' ID' . $id. 'com sucesso!',
                'redirect' => 'certconfig'

            ]);
        } else {
            echo "Ocorreu um erro ao salvar.";
        }
    }

    ########################################################################

    public function edit($id) {

        //dd($this->certconfigModel->find($id));

        return view('certconfigform', [
            'certconfig' => $this->certconfigModel->find($id),
            //'function' => 'edit'
        ]);
    }

    public function copy($id) {

        return view('certconfigform', [
            'certconfig' => $this->certconfigModel->find($id),
            'function' => 'copy'
        ]);
    }

}
