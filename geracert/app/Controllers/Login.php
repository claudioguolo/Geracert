<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use Config\Services;

class Login extends BaseController
{
    private UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

	
    public function index()
    {

        return view('login');
    }

    public function signIn()
    {
        $email = $this->request->getPost('inputEmail');
        $nome = $this->request->getPost('inputName');
        $password = $this->request->getPost('inputPassword');

        $dadosUsuario = $this->usuarioModel->getByEmail($email);

        if (count($dadosUsuario) > 0) {

            $hashUsuario = $dadosUsuario['senha'];
            if ($this->validatePassword($password, $hashUsuario, (int) $dadosUsuario['id'])) {
                $permissoes = strtolower(trim((string) ($dadosUsuario['permissoes'] ?? '')));
                $authorization = Services::authorization();
                $roles = $authorization->rolesFromString($permissoes);
                $abilities = $authorization->abilitiesForRoles($roles);

                if (! $authorization->can($permissoes, 'admin.dashboard')) {
                    session()->setFlashdata('msg', lang('UI.adminAccessDenied'));
                    return redirect()->to('/login');
                }

                session()->set('isLoggedIn', true);
                session()->set('user_id', (int) $dadosUsuario['id']);
                session()->set('nome', $dadosUsuario['nome']);
                session()->set('permissoes', $permissoes);
                session()->set('roles', $roles);
                session()->set('abilities', $abilities);
                return redirect()->to(base_url('admin'));
            } else {
                session()->setFlashdata('msg', lang('UI.invalidCredentials'));
                return redirect()->to('/login');
            }
        } else {

            session()->setFlashdata('msg', lang('UI.invalidCredentials'));
            return redirect()->to('/login');
        }
    }

    private function validatePassword(string $password, string $storedHash, int $userId): bool
    {
        if (password_verify($password, $storedHash)) {
            if (password_needs_rehash($storedHash, PASSWORD_DEFAULT)) {
                $this->usuarioModel->update($userId, [
                    'senha' => password_hash($password, PASSWORD_DEFAULT),
                ]);
            }

            return true;
        }

        // Compatibilidade com base legada que ainda armazena senha em MD5.
        if (preg_match('/^[a-f0-9]{32}$/i', $storedHash) && hash_equals(strtolower($storedHash), md5($password))) {
            $this->usuarioModel->update($userId, [
                'senha' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            return true;
        }

        return false;
    }


    public function signOut(){

        session()->destroy();
        return redirect()->to(base_url());
    }
}
