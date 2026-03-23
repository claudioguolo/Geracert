<?php

/*
* Autenticação
*/


class Autenticacao{

    private $usuario;

    public function login(string $email, string $password){


        $usuario = new App\Models\UsuarioModel();


        $usuario = $usuarioModel->buscaUsuarioPorEmail();



    }





}