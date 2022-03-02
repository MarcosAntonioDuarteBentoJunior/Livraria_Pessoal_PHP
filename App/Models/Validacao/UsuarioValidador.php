<?php

namespace App\Models\Validacao;

use App\Controllers\Controller;
use \App\Models\Validacao\ResultadoValidacao;
use \App\Models\Entidades\Usuario;


class UsuarioValidador
{

    public function validar(Usuario $usuario)
    {
        $resultadoValidacao = new ResultadoValidacao();

        if (empty($usuario->getNomeUsuario())) {
            $resultadoValidacao->addErro('Nome de Usuario', "Este campo nao pode ser vazio");
        }

        if (empty($usuario->getEmail())) {
            $resultadoValidacao->addErro('Email', "Este campo não pode ser vazio");
        }

        if (!empty($usuario->getEmail()) && !filter_var($usuario->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $resultadoValidacao->addErro('Email', "Email invalido");
        }

        if (empty($usuario->getSenha())) {
            $resultadoValidacao->addErro('Senha', "Este Campo nao pode ser vazio");
        }

        return $resultadoValidacao;
    }
}
