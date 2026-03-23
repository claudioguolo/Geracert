<?php namespace App\Libraries;

use App\Controllers\BaseController;

class Formatador extends BaseController
{

    public function montaHTML($html): string
    {
        $html = '<h1>'.$html.'</h1>';
        
        return $html;

    }


}


?>