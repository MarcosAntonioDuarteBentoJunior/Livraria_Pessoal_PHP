<?php

namespace App\Models\Validacao;

use \App\Models\Validacao\ResultadoValidacao;
use \App\Models\Entidades\Livro;


class LivroValidador
{

    public function validar(Livro $livro)
    {
        $resultadoValidacao = new ResultadoValidacao();

        if (empty($livro->getTitulo())) {
            $resultadoValidacao->addErro('Titulo', "Este campo não pode ser vazio");
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $livro->getTitulo())) {
            $resultadoValidacao->addErro('Titulo', "Somente letras e espaços em branco");
        }

        if (empty($livro->getEdicao())) {
            $resultadoValidacao->addErro('Ediçao', "Este campo não pode ser vazio");
        }

        if (!empty($livro->getEdicao()) && (!is_numeric($livro->getEdicao()) || $livro->getEdicao() <= 0)) {
            $resultadoValidacao->addErro('Ediçao', "Deve ser um numero maior que zero");
        }

        if (empty($livro->getEditora())) {
            $resultadoValidacao->addErro('Editora', "Este campo não pode ser vazio");
        }

        return $resultadoValidacao;
    }
}
