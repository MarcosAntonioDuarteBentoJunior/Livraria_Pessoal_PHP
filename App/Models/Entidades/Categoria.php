<?php

namespace App\Models\Entidades;

class Categoria
{
    private $idCategoria;
    private $nomeCategoria;
    private $descricao;

    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    public function setIdCategoria($id)
    {
        $this->idCategoria = $id;
    }

    public function getNomeCategoria()
    {
        return $this->nomeCategoria;
    }

    public function setNomeCategoria($categoria)
    {
        $this->nomeCategoria = $categoria;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
}
