<?php

namespace App\Models\Entidades;

class Livro
{
    private $idLivro;
    private $titulo;
    private $autor;
    private $edicao;
    private $editora;
    private $categoria;

    public function __construct()
    {
        $this->categoria = new Categoria();
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getIdLivro()
    {
        return $this->idLivro;
    }

    public function setIdLivro($id)
    {
        $this->idLivro = $id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    public function getEdicao()
    {
        return $this->edicao;
    }

    public function setEdicao($edicao)
    {
        $this->edicao = $edicao;
    }

    public function getEditora()
    {
        return $this->editora;
    }

    public function setEditora($editora)
    {
        $this->editora = $editora;
    }
}
