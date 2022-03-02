<?php

namespace App\Models\DAO;

use App\Lib\Sessao;
use App\Models\Entidades\Categoria;

class CategoriaDAO extends BaseDAO
{

    public  function getById($id)
    {
        $resultado = $this->select(
            "SELECT categorias.idCategoria             AS idCategoria,
                        nomeCategoria                      AS nomeCategoria,
                        IFNULL(descricao, 'SEM DESCRICAO') AS descricao
            FROM categorias       
            INNER JOIN usuarios_cadastram_categorias
            ON categorias.idCategoria = usuarios_cadastram_categorias.idcategoria
            WHERE idUsuario = " . Sessao::retornaIdUsuario() . " AND categorias.idCategoria = $id
            "
        );

        return $resultado->fetchObject(Categoria::class);

        /*
        $dataSetcategorias = $resultado->fetch();

        if ($dataSetcategorias) {
            $categorias = new Categoria();

            $categorias->setIdCategoria($dataSetcategorias['idCategoria']);
            $categorias->setNomeCategoria($dataSetcategorias['nomecategoria']);
            $categorias->setDescricao($dataSetcategorias['descricao']);

            return $categorias;
        }

        return false;
        */
    }

    public function getLastId()
    {
        $lastId = $this->select("SELECT LAST_INSERT_ID() AS lastId FROM categorias LIMIT 1");

        return $lastId->fetch()['lastId'];
    }

    public function verificaDuplicidade(Categoria $categoria)
    {

        $nomeCategoria = $categoria->getNomeCategoria();

        $resultado = $this->select(
            "SELECT  categorias.idCategoria AS idCategoria
            FROM categorias       
            INNER JOIN usuarios_cadastram_categorias
            ON categorias.idCategoria = usuarios_cadastram_categorias.idcategoria
            WHERE idUsuario = " . Sessao::retornaIdUsuario() . " AND categorias.nomeCategoria = '$nomeCategoria'
            "
        );

        return $resultado->rowCount();
    }

    public function listar()
    {

        //$ids = $this->select("SELECT idCategoria AS idCategoria FROM categorias");

        $resultado = $this->select(
            "SELECT     categorias.idCategoria             AS idCategoria,
                        nomeCategoria                      AS nomeCategoria,
                        IFNULL(descricao, 'SEM DESCRICAO') AS descricao
                FROM categorias       
                INNER JOIN usuarios_cadastram_categorias
                ON categorias.idCategoria = usuarios_cadastram_categorias.idcategoria
                WHERE idUsuario = " . Sessao::retornaIdUsuario() . "
                "
        );

        //$dataSetIds = $ids->fetchAll();
        $dataSetcategorias = $resultado->fetchAll();

        if ($dataSetcategorias) {

            $categorias = array();

            foreach ($dataSetcategorias as $dataSetcategoria) {

                $categoria = new Categoria();

                $categoria->setIdCategoria($dataSetcategoria['idCategoria']);
                $categoria->setNomeCategoria($dataSetcategoria['nomeCategoria']);
                $categoria->setDescricao($dataSetcategoria['descricao']);

                array_push($categorias, $categoria);
            }

            return $categorias;
        }
        return false;
    }

    public function getLivrosNaCategoria($id)
    {
        $livrosNaCategoria = $this->select("SELECT COUNT(livros.idLivro) AS livrosNaCategoria
                                            FROM livros
                                            INNER JOIN categorias
                                            ON livros.idCategoria = categorias.idCategoria
                                            WHERE categorias.idCategoria = $id
                                        ");

        return $livrosNaCategoria->fetch()['livrosNaCategoria'];
    }

    public  function salvar(Categoria $categoria)
    {
        try {

            $nomeCategoria = $categoria->getNomeCategoria();
            $descricao     = $categoria->getDescricao();

            $insert = $this->insert(
                'categorias',
                ":nomeCategoria, :descricao",
                [
                    ':nomeCategoria' => $nomeCategoria,
                    ':descricao'     => $descricao
                ]
            );

            //Sessao::gravaIdUsuario(1);

            $this->insert(
                'usuarios_cadastram_categorias',
                ":idUsuario, :idCategoria",
                [
                    ':idUsuario'    => Sessao::retornaIdUsuario(),
                    ':idCategoria'  => $this->getLastId()
                ]
            );

            return $insert;
        } catch (\Exception $e) {
            throw new \Exception("Erro na gravação de dados: " . $e->getMessage(), 500);
        }
    }

    public  function atualizar(Categoria $categoria)
    {
        try {

            $id             = $categoria->getIdCategoria();
            $nomeCategoria  = $categoria->getNomeCategoria();
            $descricao      = $categoria->getDescricao();


            return $this->update(
                'categorias',
                "nomeCategoria = :nomeCategoria, descricao = :descricao",
                [
                    ':idcategoria'   => $id,
                    ':nomeCategoria' => $nomeCategoria,
                    ':descricao'     => $descricao
                ],
                "idCategoria = :idcategoria"
            );
        } catch (\Exception $e) {
            throw new \Exception("Erro na atualizaçao de dados: " . $e->getMessage(), 500);
        }
    }

    public function excluir(Categoria $categoria)
    {
        try {
            $id = $categoria->getIdCategoria();

            $this->delete('usuarios_cadastram_categorias', "idCategoria = $id AND idUsuario = " . Sessao::retornaIdUsuario());

            return $this->delete('categorias', "idCategoria = $id");
        } catch (\Exception $e) {

            throw new \Exception("Erro ao deletar: " . $e->getMessage(), 500);
        }
    }
}
