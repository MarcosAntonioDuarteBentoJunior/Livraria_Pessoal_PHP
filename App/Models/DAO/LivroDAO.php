<?php

namespace App\Models\DAO;

use App\Lib\Sessao;
use App\Models\Entidades\Livro;

class LivroDAO extends BaseDAO
{

    public  function buscaComPaginacao($buscaLivro, $totalPorPagina, $paginaSelecionada)
    {

        //$paginaSelecionada = (!$paginaSelecionada) ? 1 : $paginaSelecionada;

        $inicio = (($paginaSelecionada - 1) * $totalPorPagina);

        $whereBuscaTotal  = " WHERE titulo LIKE '%$buscaLivro%' ";
        $whereBuscaSelect = " titulo LIKE '%$buscaLivro%' ";

        $resultadoTotal = $this->select(
            "SELECT COUNT(idLivro) as total FROM livros $whereBuscaTotal "
        );

        $resultado = $this->select(
            "SELECT 
                livros.idLivro           AS idLivro,
                livros.titulo            AS titulo,
                livros.autor             AS autor,
                livros.edicao            AS edicao,
                livros.editora           AS editora,
                categorias.nomeCategoria AS nomeCategoria
            FROM livros
            INNER JOIN categorias
            ON livros.idCategoria = categorias.idCategoria
            INNER JOIN usuarios_cadastram_livros
            ON livros.idLivro = usuarios_cadastram_livros.idLivro
            WHERE idUsuario = " . Sessao::retornaIdUsuario() . " AND 
            $whereBuscaSelect
            ORDER BY livros.titulo
            LIMIT $inicio,$totalPorPagina
            "
        );

        $dataSetlivros = $resultado->fetchAll();

        if ($dataSetlivros) {
            $livros = array();

            foreach ($dataSetlivros as $dataSetlivro) {
                $livro = new Livro();

                $livro->setIdLivro($dataSetlivro['idLivro']);
                $livro->setTitulo($dataSetlivro['titulo']);
                $livro->setEdicao($dataSetlivro['edicao']);
                $livro->setAutor($dataSetlivro['autor']);
                $livro->setEditora($dataSetlivro['editora']);
                $livro->getCategoria()->setIdCategoria($dataSetlivro['idCategoria']);
                $livro->getCategoria()->setNomeCategoria($dataSetlivro['nomeCategoria']);

                array_push($livros, $livro);
            }
        }

        $totalLinhas = $resultadoTotal->fetch()['total'];

        return [
            'paginaSelecionada' => $paginaSelecionada,
            'totalPorPagina'    => $totalPorPagina,
            'totalLinhas'       => $totalLinhas,
            'resultado'         => (!$livros) ? null : $livros
        ];
    }

    public  function getById($id)
    {
        $resultado = $this->select(
            "SELECT livros.idLivro           AS idLivro,
                    livros.titulo            AS titulo,
                    livros.autor             AS autor,
                    livros.edicao            AS edicao,
                    livros.editora           AS editora,
                    categorias.idCategoria   AS idCategoria,
                    categorias.nomeCategoria AS nomeCategoria
            FROM livros
            INNER JOIN categorias
            ON livros.idCategoria = categorias.idCategoria
            INNER JOIN usuarios_cadastram_livros
            ON livros.idLivro = usuarios_cadastram_livros.idLivro
            WHERE idUsuario = " . Sessao::retornaIdUsuario() . " AND livros.idLivro = $id"
        );

        //return $resultado->fetchObject(Livro::class);


        $dataSetlivros = $resultado->fetch();

        if ($dataSetlivros) {
            $livros = new Livro();

            $livros->setIdLivro($dataSetlivros['idLivro']);
            $livros->setTitulo($dataSetlivros['titulo']);
            $livros->setEdicao($dataSetlivros['edicao']);
            $livros->setAutor($dataSetlivros['autor']);
            $livros->setEditora($dataSetlivros['editora']);
            $livros->getCategoria()->setNomeCategoria($dataSetlivros['nomeCategoria']);
            $livros->getCategoria()->setIdCategoria($dataSetlivros['idCategoria']);

            return $livros;
        }

        return false;
    }

    public function getLastId()
    {
        $lastId = $this->select("SELECT LAST_INSERT_ID() AS lastId FROM livros LIMIT 1");

        return $lastId->fetch()['lastId'];
    }


    public function listar()
    {
        $resultado = $this->select(
            "SELECT 
                        livros.idLivro           AS idLivro,
                        livros.titulo            AS titulo,
                        livros.autor             AS autor,
                        livros.edicao            AS edicao,
                        livros.editora           AS editora,
                        categorias.idcategoria   AS idCategoria,
                        categorias.nomeCategoria AS nomeCategoria
                FROM livros
                INNER JOIN categorias
                ON livros.idCategoria = categorias.idCategoria
                ORDER BY livros.titulo
                "
        );

        $dataSetlivros = $resultado->fetchAll();

        if ($dataSetlivros) {
            $livros = array();

            foreach ($dataSetlivros as $dataSetlivro) {
                $livro = new Livro();

                $livro->setIdLivro($dataSetlivro['idLivro']);
                $livro->setTitulo($dataSetlivro['titulo']);
                $livro->setEdicao($dataSetlivro['edicao']);
                $livro->setAutor($dataSetlivro['autor']);
                $livro->setEditora($dataSetlivro['editora']);
                $livro->getCategoria()->setNomeCategoria($dataSetlivro['nomeCategoria']);
                $livro->getCategoria()->setIdCategoria($dataSetlivro['idcategoria']);

                array_push($livros, $livro);
            }
            return $livros;
        }
        return false;
    }

    public function verificaDuplicidade(Livro $livro)
    {

        $titulo    = $livro->getTitulo();
        $autor     = $livro->getAutor();
        $edicao    = $livro->getEdicao();
        $editora   = $livro->getEditora();
        $categoria = $livro->getCategoria()->getIdCategoria();

        $resultado = $this->select(
            "SELECT livros.idLivro           AS idLivro,
                    categorias.idCategoria   AS idCategoria
            FROM livros
            INNER JOIN categorias
            ON livros.idCategoria = categorias.idCategoria
            INNER JOIN usuarios_cadastram_livros
            ON livros.idLivro = usuarios_cadastram_livros.idLivro
            WHERE idUsuario = " . Sessao::retornaIdUsuario() . " AND titulo = '$titulo' AND autor = '$autor' AND edicao = '$edicao' AND editora = '$editora' AND categorias.idCategoria = '$categoria'"
        );

        return $resultado->rowCount();
    }

    public  function salvar(Livro $livro)
    {

        try {

            $titulo           = $livro->getTitulo();
            $edicao           = $livro->getEdicao();
            $editora          = $livro->getEditora();
            $autor            = $livro->getAutor();
            $idcategoria      = $livro->getCategoria()->getIdCategoria();


            $insert = $this->insert(
                'livros',
                ":titulo,:edicao,:editora,:autor,:idcategoria",
                [
                    ':titulo'      => $titulo,
                    ':edicao'      => $edicao,
                    ':editora'     => $editora,
                    ':autor'       => $autor,
                    ':idcategoria' => $idcategoria
                ]
            );

            echo $this->getLastId();

            //Sessao::gravaIdUsuario(1);
            //$lastId = $this->lastInsertId();

            //$this->select("SELECT COUNT(idLivro) FROM livros;");

            $insertAssoc = $this->insert(
                'usuarios_cadastram_livros',
                ":idUsuario,:idLivro",
                [
                    ':idUsuario' => Sessao::retornaIdUsuario(),
                    ':idLivro'   => $this->getLastId()
                ]
            );


            return ($insert && $insertAssoc);
        } catch (\Exception $e) {
            throw new \Exception("Erro na gravação de dados: " . $e->getMessage(), 500);
        }
    }

    public  function atualizar(Livro $livro)
    {
        try {

            $id               = $livro->getIdLivro();
            $titulo           = $livro->getTitulo();
            $edicao           = $livro->getEdicao();
            $editora          = $livro->getEditora();
            $autor            = $livro->getAutor();
            $idCategoria      = $livro->getCategoria()->getIdCategoria();

            return $this->update(
                'livros',
                "titulo = :titulo, edicao = :edicao, editora = :editora, autor = :autor, idCategoria = :idCategoria",
                [
                    ':idLivro'     => $id,
                    ':titulo'      => $titulo,
                    ':edicao'      => $edicao,
                    ':editora'     => $editora,
                    ':autor'       => $autor,
                    ':idCategoria' => $idCategoria,
                ],
                "idLivro = :idLivro"
            );
        } catch (\Exception $e) {
            throw new \Exception("Erro na atualizaçao de dados: " . $e->getMessage(), 500);
        }
    }

    public function excluir(Livro $livro)
    {
        try {
            $id = $livro->getIdLivro();

            $this->delete('usuarios_cadastram_livros', "idLivro = $id AND idUsuario = " . Sessao::retornaIdUsuario());

            return $this->delete('livros', "idLivro = $id");
        } catch (\Exception $e) {

            throw new \Exception("Erro ao deletar: " . $e->getMessage(), 500);
        }
    }
}
