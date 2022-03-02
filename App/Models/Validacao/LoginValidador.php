<?php

namespace App\Models\Validacao;

use App\Controllers\Controller;
use \App\Models\Validacao\ResultadoValidacao;
use \App\Models\Entidades\Usuario;


class LoginValidador
{

    public function validar(Usuario $usuario)
    {
        $resultadoValidacao = new ResultadoValidacao();

        if (empty($usuario->getNomeUsuario())) {
            $resultadoValidacao->addErro('Nome de Usuario', "Este campo nao pode ser vazio");
        }

        if (empty($usuario->getSenha())) {
            $resultadoValidacao->addErro('Senha', "Este Campo nao pode ser vazio");
        }

        return $resultadoValidacao;
    }
}
