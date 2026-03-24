<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Auth implements FilterInterface
{


//---------------------------------------------------------------------------------------------------------------

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ((bool) $session->isLoggedIn !== true) {
            return redirect()->to('/login');
        }

        $authorization = Services::authorization();
        $permissions = (string) $session->get('permissoes');

        if ($arguments === null || $arguments === []) {
            if ($authorization->can($permissions, 'admin.dashboard')) {
                return;
            }

            $session->setFlashdata('msg', 'Usuário sem permissão administrativa.');
            $session->destroy();
            return redirect()->to('/login');
        }

        foreach ($arguments as $ability) {
            if (! $authorization->can($permissions, (string) $ability)) {
                return redirect()->to(base_url('/'));
            }
        }
    }

//---------------------------------------------------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
