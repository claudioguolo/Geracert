<?php

namespace App\Controllers;

#use App\Models\ClubeModel;
#use App\Models\Tools;
use SebastianBergmann\Timer\Duration;

class Tools extends BaseController
{

    ########################################################################

    private $clubeModel;

    public function __construct()
    {

#        $this->clubeModel = new ClubeModel();
    }

    ########################################################################

    public function index()
    {

        //$clubes = $this->clubeModel->findAll();
        return view('tools');
    }

}
