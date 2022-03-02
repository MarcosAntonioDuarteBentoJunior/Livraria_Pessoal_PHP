<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\DAO\CategoriaDAO;
use App\Models\Entidades\Categoria;
use App\Models\Validacao\CategoriaValidador;

class CategoriaController extends Controller
{
    public function index()
    {
        $categoriaDAO = new CategoriaDAO();

        self::setViewParam('listaCategorias', $categoriaDAO->listar());

        $this->render('/categoria/index');

        Sessao::limpaMensagem();
    }

    public function cadastro()
    {
        $this->render('/categoria/cadastro');

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }

    public function salvar()
    {
        $categoria = new Categoria();

        $categoria->setNomeCategoria($_POST['categoria']);
        $categoria->setDescricao($_POST['descricao']);

        Sessao::gravaFormulario($_POST);

        $categoriaValidador = new CategoriaValidador();
        $resultadoValidacao = $categoriaValidador->validar($categoria);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/categoria/cadastro');
        }

        $categoriaDAO = new CategoriaDAO();

        if ($categoriaDAO->verificaDuplicidade($categoria)) {
            Sessao::gravaMensagem("Não é permitido ter mais de uma categoria com o mesmo nome");
            $this->redirect('/categoria/cadastro');
        }

        $categoriaDAO->salvar($categoria);

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/categoria');
    }

    public function edicao($params)
    {
        $id = $params[0];

        $categoriaDAO = new CategoriaDAO();

        $categoria = $categoriaDAO->getById($id);

        if (!$categoria) {
            Sessao::gravaMensagem("categoria inexistente");
            $this->redirect('/categoria');
        }

        self::setViewParam('categoria', $categoria);

        $this->render('categoria/editar');

        Sessao::limpaMensagem();
    }

    public function atualizar()
    {

        $categoria = new Categoria();
        $categoria->setIdCategoria($_POST['id']);
        $categoria->setNomeCategoria($_POST['categoria']);
        $categoria->setDescricao($_POST['descricao']);

        Sessao::gravaFormulario($_POST);

        $categoriaValidador = new CategoriaValidador();
        $resultadoValidacao = $categoriaValidador->validar($categoria);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/categoria/editar');
        }

        $categoriaDAO = new CategoriaDAO();

        if ($categoriaDAO->verificaDuplicidade($categoria)) {
            Sessao::gravaMensagem("Não é permitido ter mais de uma categoria com o mesmo nome");
            $this->redirect('/categoria/cadastro');
        }

        $categoriaDAO->atualizar($categoria);

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/categoria');
    }

    public function exclusao($params)
    {
        $id = $params[0];

        $categoriaDAO = new CategoriaDAO();

        $categoria = $categoriaDAO->getById($id);

        if (!$categoria) {
            Sessao::gravaMensagem("categoria inexistente");
            $this->redirect('categoria');
        }

        self::setViewParam('categoria', $categoria);

        $this->render('categoria/exclusao');

        Sessao::limpaMensagem();
    }

    public function excluir()
    {
        $categoria = new Categoria();
        $categoria->setIdCategoria($_POST['idcategoria']);

        $categoriaDAO = new CategoriaDAO();

        if ($categoriaDAO->getLivrosNaCategoria($categoria->getIdCategoria())) {
            Sessao::gravaMensagem("Esta categoria nao pode ser excluida. Existem " .
                $categoriaDAO->getLivrosNaCategoria($categoria->getIdCategoria()) . " livros associados a ela.");

            $this->redirect('/categoria');
        }

        if (!$categoriaDAO->excluir($categoria)) {
            Sessao::gravaMensagem("Categoria inexistente");
            $this->redirect('/categoria');
        }

        Sessao::gravaMensagem("categoria excluido com sucesso!");

        $this->redirect('/categoria');
    }
}
