<?php

namespace App\Controllers;

use App\Libraries\Formatador;
use App\Models\CertClubes;
use App\Models\CertificadosModel;
use App\Models\ClubeModel;
use App\Models\consulta;
use Dompdf\Dompdf;
use Dompdf\Options;
use Kint\Renderer\Renderer;

use function PHPSTORM_META\type;

class Main extends BaseController
{
    private $clubeModel;

    // Instancia do base de dados para listagem dos clubes. 
    public function __construct()
    {
        $this->clubeModel = new ClubeModel();
    }

    // index =) 
    public function index()
    {
        $clubeModel = new ClubeModel();
        //retorno a os valores da consulta selecionada e manda pra tela. 
        return view('tablecerts_index', [

            'clubes' => $this->clubeModel->findAll()
        ]);
    }

    //Gera tela principal de consulta
    public function tablecerts(){

        
    helper("genIdent");

        $clubeModel = new ClubeModel();

        $getCall = $this->request->getGet('callsign');  // obtem o indicativo do form. 
        $getClube = $this->request->getGet('clube');  // obtem o indicativo do form. 
	
	helper("findIco");

        $modelo = new CertificadosModel();  // instacia do banco de dados


        if($getCall):   // se vier o valor do indicativo procura com filtro
            $getClube = "";
            $sql = 'select * from certificados where (indicativo = "'.$getCall.'" or operator like "%'.$getCall.'%") and (cod_clube is null or cod_clube = "")';
            $consulta = $modelo->db->query($sql)->getResultObject();

            return view('hamcerts', [
                'clubes' => $this->clubeModel->findAll(),
                'consulta' => $consulta
            ]);

        elseif($getClube):       
            // se vier o valor do clube consulta pelo codigo do clube
            $getCall = "";
            $sql = 'select * from certificados where cod_clube = "'.$getClube.'"';
            $consulta = $modelo->db->query($sql)->getResultObject();

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
//        $getId = $this->request->getGet('identificador'); 
        $getId = $hash_cert; 
        $modelo = new CertificadosModel(); //instacia do banco de dados. 
    	helper("App_helper");
        serialData($getId); 

        //se vier a sinalização de consulta do ham
           $sql = 'select * from certificados where identificador = "'.$getId.'"';
           $consulta = $modelo->db->query($sql)->getResultObject();

           //carregando os valores da consulta do banco nas variáveis. 
           //todas as variaveis de banco serão carregadas para que possam
           //ser usadas na formação do certificado. 
           //as que serão usadas são estanciadas nas variáveis no html de cada 
           //certificado, mas estarão disponiveis mesmo não sendo usadas. 
         
           $cert_vars = array(
                '$id' => $consulta[0]->id,
                '$indicativo' => $consulta[0]->indicativo,
                '$indicativo-' => '- '.$consulta[0]->indicativo.' -',
                '$nome+indicativo' => substr($consulta[0]->nome, 0, 40).' - '.$consulta[0]->indicativo.' -',
                '$concurso' => $consulta[0]->concurso,
                '$pontuacao' => $consulta[0]->pontuacao,
                '$ano' => $consulta[0]->ano,
                '$cod_clube' => $consulta[0]->clube,
                '$tipo_evento' => $consulta[0]->tipo_evento,
                'geracao_data' => $consulta[0]->geracao_data,
                'serial' => $consulta[0]->serial,
                '$organizador' => $consulta[0]->organizador,
                '$modalidade' => $consulta[0]->modalidade,
                '$categoria' => $consulta[0]->categoria,
                '$class_geral' => $consulta[0]->class_geral,
                '$status' => $consulta[0]->status,
                '$operador' => $consulta[0]->operator,
                '$km' => $consulta[0]->km,
                '$class_pais' => $consulta[0]->class_pais,
                '$class_cont' => $consulta[0]->class_cont,
                '$clube' => $consulta[0]->clube
            );

            if ($consulta[0]->nome == ""):
                $cert_vars['$nome'] = $consulta[0]->clube;
            else:
                $cert_vars['$nome'] = substr($consulta[0]->nome, 0, 40);            
            endif;

        
            // Monta a consulta para obter o dados de CSS e formatação para a geração do certificado
            $sql = 'select * from certformat
                    where concurso = "'.$consulta[0]->concurso.'" and ano = 
                    "'.$consulta[0]->ano.'"';

            // Realiza a consulta no banco procurando o CSS
            $consulta = $modelo->db->query($sql)->getResultObject();
      

            $format_vars = array(
                'texto_text' => $consulta[0]->texto_text,
                'serial_text' => $consulta[0]->serial_text,
                'datetime_text' => $consulta[0]->datetime_text,
                'imagem' => base_url().'/images/contest/'.$consulta[0]->imagem,
                '$div_texto' => strtr($consulta[0]->html, $cert_vars),
                'size_h1'=> $consulta[0]->size_h1,
                'size_h2'=> $consulta[0]->size_h2,
                'size_h3'=> $consulta[0]->size_h3,
                'size_h4'=> $consulta[0]->size_h4,
                'size_h5'=> $consulta[0]->size_h5,
                'size_h6'=> $consulta[0]->size_h6
            );

            $html = view('cert_model', ['format_vars' => $format_vars, 'cert_vars' => $cert_vars]);

            
            ////////////////////////////////////////
            //  como fazer com multi operador??? //
            ///////////////////////////////////////
                        
            //seta o valor de variáveis para o valor do certcontent
            
            //substitui os as variaveis dentro do CSS/HTML salvos no certcontent
            //$html = strtr($html, $cert_vars);

            //envia o html para gerar o certificado no domPdf
            //echo $format_vars['$div_texto'];
            //echo $html;
            domPdf($html, $cert_vars['$indicativo'], $cert_vars['$concurso'], $cert_vars['$ano']);
    }
}
