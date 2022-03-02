<?php

namespace App\Models\Validacao;

use \App\Models\Validacao\ResultadoValidacao;
use \App\Models\Entidades\Categoria;


class CategoriaValidador
{

    public function validar(Categoria $categoria)
    {
        $resultadoValidacao = new ResultadoValidacao();

        if (empty($categoria->getNomeCategoria())) {
            $resultadoValidacao->addErro('Categoria', "Este campo não pode ser vazio");
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $categoria->getNomeCategoria())) {
            $resultadoValidacao->addErro('Nome', "Somente letras e espaços em branco");
        }

        return $resultadoValidacao;
    }
}
