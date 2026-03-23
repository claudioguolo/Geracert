<?php

namespace App\Controllers;
use App\Models\Certificados;

class Extra extends BaseController{

    public function geracert($hash_cert){
        
        echo $hash_cert;
    }
}

?>