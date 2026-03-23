<?php

use App\Models\Certificados;
use App\Models\CertificadosModel;
use PhpCsFixer\Tokenizer\Analyzer\Analysis\SwitchAnalysis;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\Switch_;
use Dompdf\Dompdf;
use Dompdf\Options;

// Função para debug, faz print na tela do $data formatado como coleção. 
// printData($data, '', 'sql-etc')

function printData($data, $die = true)
{
   echo '<pre>';

   if (is_object($data) || is_array($data)) {
      print_r($data);
   } else {
      echo $data;
   }

   if ($die) {
      die('terminado - ' . "");
   }
}

// Função que gera o icone e o link no final da linha 
// nas tabelas das consultas

function findIco($status, $serial, $id)
{

   if ($serial) :
      $btn = "red";
   else :
      $btn = "blue";
   endif;


   if (!$id) :
      $certIcom = 'fa fa-spinner';
      $link = "";
      $btn = "blue";
   else :


      switch ($status) {
         case "d":
            $certIcom = 'fa fa-file-pdf-o';
            //         $link = '<a href="pregeracert?identificador='.$id.'&'.$func.'" target="blank">';
            $link = '<a href="pregeracert/' . $id . '" target="blank">';
            break;
         case "i":
            $certIcom = 'fa fa-spinner';
            $btn = "red";
            $link = "";
            break;
         case "c":
            $certIcom = 'fa fa-times-circle';
            $link = "";
            break;
         case "":
            $certIcom = 'fa fa-times-circle';
            $link = "";
            break;
      }

   endif;

   $status = '<td class="w3-center">' . $link . '<i class=" ' . $certIcom . '" style="font-size:20px;color:' . $btn . '"></i></a>';
   return $status;
}


// Classe para gerar o PDF usando DomPdf - Passar o HTML formatado

function domPdf($html, $call, $contest, $year)
{
   $options = new Options();
   $chroot = defined('FCPATH') ? rtrim(FCPATH, DIRECTORY_SEPARATOR) : __DIR__;
   $options->setChroot($chroot);
   //$options->setIsRemoteEnabled(true);
   $options->set('isRemoteEnabled', TRUE);
   $dompdf = new Dompdf($options);
   $dompdf->loadHtml($html);
   $dompdf->setPaper('A4', 'landscape');
   $dompdf->render();
   header('Content-type: application/pdf');
   $dompdf->stream($call . "-" . $contest . "-" . $year . ".pdf");
}


// Obter dados do qrz.com

function get_QRZ($call, $LOGIN_QRZ, $PASS_QRZ)
{

   $url_key = 'http://xmldata.qrz.com/xml/?username=' . $LOGIN_QRZ . ';password=' . $PASS_QRZ;
   $xml = file_get_contents($url_key);
   $xml = simplexml_load_string($xml);
   $key = "{$xml->Session->Key}";
   $url_get_name = 'http://xmldata.qrz.com/xml/current/?s=' . $key . ';callsign=' . $call;
   $xml = file_get_contents($url_get_name);
   $xml = simplexml_load_string($xml);
   $qrz_name = "{$xml->Callsign->fname} {$xml->Callsign->name}";

   return $qrz_name;
};

//Função que gera e insere no banco de dados o serial e geracao_data caso não houver
//Este função é executada no momento que o certificado é gerado a primeira vez

function serialData($Id)
{

   $modelo = new CertificadosModel();

   $sql = 'select * from certificados where identificador = "' . $Id . '"';
   $certificados = $modelo->db->query($sql)->getResultObject();

   if (!$certificados[0]->geracao_data) {

      date_default_timezone_set('UCT');
      $date = date('d-m-Y H:i');
      $serial = $certificados[0]->organizador . str_pad($Id, 5, "0", STR_PAD_LEFT) . date('y');
      $sqlinsert = 'UPDATE certificados SET serial= "' . $serial . '", geracao_data = "' . $date . '", nome = "' . $certificados[0]->nome . '" where identificador = "' . $Id . '"';
      $modelo->query($sqlinsert);
   }
}



#generate and update identificator field where is null

function genIdent()
{

   $modelo = new CertificadosModel();
   $sql = 'UPDATE certificados SET identificador = SHA2(CONCAT(NOW(),nome, ano, class_geral, clube, concurso, RAND()),512) WHERE identificador IS null or identificador = ""';
   $modelo->query($sql);
}
