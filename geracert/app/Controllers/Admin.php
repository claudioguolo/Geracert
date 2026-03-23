<?php

namespace App\Controllers;

use App\Models\Clubes;
use App\Models\Concursos;
use App\Models\Usuarios;

/* 

joao - abc123
carlos - abc456

*/

class Admin extends BaseController
{

    public function index()
    {

        return view("admin");
    }

    public function lista_concursos()
    {
        $modelo = new Concursos();

        //

        $concursos = $modelo->findAll();

        return view("lista_concursos", ['concursos' => $concursos]);
    }

    // ###########################################################################
    // Abre os dados do concurso para edição

    public function edita_concurso($id_concurso)
    {

        //echo "Edita Conteste  - $id_concurso";

        $modelo = new Concursos();

        $concurso = $modelo->where('id', $id_concurso)->first();


        return view("edita_concurso", ['concurso' => $concurso]);
    }

    // ###########################################################################
    // Submete os dados editados para serem salvos

    public function update_concurso($id = null)
    {

        $db = new Concursos();

        //Obtem os dados atualizados

        $id = $this->request->getPost('cert_id');
        $cert_html = $this->request->getPost('cert_html_corpo');
        $cert_concurso = $this->request->getPost('cert_concurso');
        $cert_ano = $this->request->getPost('cert_ano');
        $cert_organizador = $this->request->getPost('cert_organizador');
        $cert_imagem = $this->request->getPost('cert_imagem');
        $cert_serial_text = $this->request->getPost('cert_serial_text');
        $cert_texto_text = $this->request->getPost('cert_texto_text');
        $cert_datetime_text = $this->request->getPost('cert_datetime_text');
        $cert_size_h1 = $this->request->getPost('cert_size_h1');
        $cert_size_h2 = $this->request->getPost('cert_size_h2');
        $cert_size_h3 = $this->request->getPost('cert_size_h3');
        $cert_size_h4 = $this->request->getPost('cert_size_h4');
        $cert_size_h5 = $this->request->getPost('cert_size_h5');
        $cert_size_h6 = $this->request->getPost('cert_size_h6');

        $sql = "update certformat set html = ?, concurso = ?, ano = ?, organizador = ?, imagem = ?, serial_text = ?, texto_text = ?, datetime_text = ?, size_h1 = ?, size_h2 = ?, size_h3 = ?, size_h4 = ?, size_h5 = ?, size_h6 = ?  where id = ?";

        //     printData($this->request->getPost());

        $db->query($sql, [ltrim($cert_html), $cert_concurso, $cert_ano, $cert_organizador, $cert_imagem, $cert_serial_text, $cert_texto_text, $cert_datetime_text, $cert_size_h1, $cert_size_h2, $cert_size_h3, $cert_size_h4, $cert_size_h5, $cert_size_h6, $id]);


        //redirect to contest list
        return redirect()->to(base_url() . '/lista_concursos');
    }


    public function new_concurso()
    {
        return view('new_concurso');
    }


    public function insert_concurso($id = null)
    {

        $db = new Concursos();

        //Obtem os dados atualizados

        //id, html, concurso, ano, imagem, serial_text, texto_text, datetime_text, size_h1, size_h2, size_h3, size_h4, size_h5, size_h6 

        $id = 0;
        $cert_html = $this->request->getPost('cert_html_corpo');
        $cert_concurso = $this->request->getPost('cert_concurso');
        $cert_ano = $this->request->getPost('cert_ano');
        $cert_organizador = $this->request->getPost('cert_organizador');
        $cert_imagem = $this->request->getPost('cert_imagem');
        $cert_serial_text = $this->request->getPost('cert_serial_text');
        $cert_texto_text = $this->request->getPost('cert_texto_text');
        $cert_datetime_text = $this->request->getPost('cert_datetime_text');
        $cert_size_h1 = $this->request->getPost('cert_size_h1');
        $cert_size_h2 = $this->request->getPost('cert_size_h2');
        $cert_size_h3 = $this->request->getPost('cert_size_h3');
        $cert_size_h4 = $this->request->getPost('cert_size_h4');
        $cert_size_h5 = $this->request->getPost('cert_size_h5');
        $cert_size_h6 = $this->request->getPost('cert_size_h6');

        $sql = "insert into certformat  (html, concurso, ano, organizador, imagem, serial_text, texto_text, datetime_text, size_h1, size_h2, size_h3, size_h4, size_h5, size_h6) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
        //html = ?, concurso = ?, ano = ?, imagem = ?, serial_text = ?, texto_text = ?, datetime_text = ?, size_h1 = ?, size_h2 = ?, size_h3 = ?, size_h4 = ?, size_h5 = ?, size_h6 = ?  where id = ?";

        //     printData($this->request->getPost());

        $db->query($sql, [ltrim($cert_html), $cert_concurso, $cert_ano, $cert_organizador, $cert_imagem, $cert_serial_text, $cert_texto_text, $cert_datetime_text, $cert_size_h1, $cert_size_h2, $cert_size_h3, $cert_size_h4, $cert_size_h5, $cert_size_h6]);

        //echo ($sql);

        //redirect to contest list
        return redirect()->to(base_url() . '/lista_concursos');
    }

}


