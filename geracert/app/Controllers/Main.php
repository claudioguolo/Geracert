<?php

namespace App\Controllers;

use App\Models\CertificadosModel;
use App\Models\ClubeModel;
use App\Services\CertificateIssuanceService;
use Config\App;

class Main extends BaseController
{
    private $clubeModel;
    private CertificateIssuanceService $certificateIssuanceService;

    // Instancia do base de dados para listagem dos clubes. 
    public function __construct()
    {
        $this->clubeModel = new ClubeModel();
        $this->certificateIssuanceService = new CertificateIssuanceService();
    }

    // index =) 
    public function index()
    {
        //retorno a os valores da consulta selecionada e manda pra tela. 
        return view('tablecerts_index', [
            'clubes' => $this->clubeModel->findAll()
        ]);
    }

    public function setLocale(string $locale)
    {
        $appConfig = config(App::class);

        if (! in_array($locale, $appConfig->supportedLocales, true)) {
            $locale = $appConfig->defaultLocale;
        }

        session()->set('locale', $locale);

        $referer = previous_url();
        if (empty($referer) || $referer === current_url()) {
            return redirect()->to(base_url());
        }

        return redirect()->to($referer);
    }

    //Gera tela principal de consulta
    public function tablecerts()
    {
        $getCall = $this->request->getGet('callsign');  // obtem o indicativo do form. 
        $getClube = $this->request->getGet('clube');  // obtem o indicativo do form. 

        helper("findIco");

        $modelo = new CertificadosModel();  // instacia do banco de dados


        if ($getCall):   // se vier o valor do indicativo procura com filtro
            $getClube = "";
            $sql = 'select * from certificados where (indicativo = ? or operator like ?) and (cod_clube is null or cod_clube = "")';
            $consulta = $modelo->db->query($sql, [$getCall, '%' . $getCall . '%'])->getResultObject();

            return view('hamcerts', [
                'clubes' => $this->clubeModel->findAll(),
                'consulta' => $consulta
            ]);

        elseif ($getClube):
            // se vier o valor do clube consulta pelo codigo do clube
            $getCall = "";
            $sql = 'select * from certificados where cod_clube = ?';
            $consulta = $modelo->db->query($sql, [$getClube])->getResultObject();

            return view('clubecerts', [
                'clubes' => $this->clubeModel->findAll(),
                'consulta' => $consulta
            ]);

        else:
            //se nada foi selecionado retorna a tela inicial

            return view('tablecerts_index', [
                'clubes' => $this->clubeModel->findAll()
            ]);

        endif;
    }

    // Faz consulta e pré formatação dos dados e chama o gerador de PDF. 
    // preciso fazer as funções para usar a tupla inteira, etc etc

    public function pregeracert($hash_cert)
    {
        helper("App_helper");
        $viewData = $this->certificateIssuanceService->buildCertificateViewData((string) $hash_cert);
        $html = view('cert_model', $viewData);

        domPdf(
            $html,
            $viewData['cert_vars']['$indicativo'],
            $viewData['cert_vars']['$concurso'],
            $viewData['cert_vars']['$ano']
        );
    }
}
