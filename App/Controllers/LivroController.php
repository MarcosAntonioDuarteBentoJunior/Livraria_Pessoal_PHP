<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Lib\Paginacao;
use App\Models\DAO\LivroDAO;
use App\Models\DAO\CategoriaDAO;
use App\Models\Entidades\Livro;
use App\Models\Validacao\LivroValidador;

class LivroController extends Controller
{
    public function index()
    {
        $livroDAO = new LivroDAO();
        $totalPorPagina = TOTAL_POR_PAGINA;

        $paginaSelecionada  = isset($_GET['paginaSelecionada']) ? $_GET['paginaSelecionada'] : 1;
        $totalPorPagina     = isset($_GET['totalPorPagina']) ? $_GET['totalPorPagina'] : 5;

        if (isset($_GET['buscaLivro'])) {

            $listaLivros = $livroDAO->buscaComPaginacao($_GET['buscaLivro'], $totalPorPagina, $paginaSelecionada);

            $paginacao = new Paginacao($listaLivros);

            self::setViewParam('buscaLivro', $_GET['buscaLivro']);
            self::setViewParam('paginacao', $paginacao->criandoLink($_GET['buscaLivro']));
            self::setViewParam('queryString', Paginacao::criandoQuerystring($_GET['paginaSelecionada'], $_GET['buscaLivro']));

            self::setViewParam('listaLivros', $listaLivros['resultado']);
        }

        $this->render('/livro/index');

        Sessao::limpaMensagem();
    }

    public function cadastro()
    {
        $categoriaDAO = new CategoriaDAO();

        self::setViewParam('listaCategorias', $categoriaDAO->listar());

        $this->render('livro/cadastro');

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }

    public function salvar()
    {
        $livro = new Livro();

        $livro->setTitulo($_POST['titulo']);
        $livro->setEdicao($_POST['edicao']);
        $livro->setEditora($_POST['editora']);
        $livro->setAutor($_POST['autor']);
        $livro->getCategoria()->setIdCategoria($_POST['idcategoria']);

        Sessao::gravaFormulario($_POST);

        $livroValidador = new LivroValidador();
        $resultadoValidacao = $livroValidador->validar($livro);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/livro/cadastro');
        }

        $livroDAO = new LivroDAO();

        if ($livroDAO->verificaDuplicidade($livro)) {
            Sessao::gravaMensagem("Livro já cadastrado");
            $this->redirect('/livro');
        }

        $livroDAO->salvar($livro);

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/livro');
    }

    public function edicao($params)
    {
        $id = $params[0];

        $livroDAO = new LivroDAO();
        $categoriaDAO = new CategoriaDAO();

        $livro = $livroDAO->getById($id);

        if (!$livro) {
            Sessao::gravaMensagem("Livro inexistente");
            $this->redirect('/livro');
        }

        self::setViewParam('livro', $livro);
        self::setViewParam('listaCategorias', $categoriaDAO->listar());

        $this->render('/livro/editar');

        Sessao::limpaMensagem();
    }

    public function atualizar()
    {

        $livro = new Livro();
        $livro->setIdLivro($_POST['id']);
        $livro->setTitulo($_POST['titulo']);
        $livro->setEdicao($_POST['edicao']);
        $livro->setEditora($_POST['editora']);
        $livro->setAutor($_POST['autor']);
        $livro->getCategoria()->setIdCategoria($_POST['idcategoria']);

        //Sessao::gravaFormulario($_POST);

        $livroValidador = new LivroValidador();
        $resultadoValidacao = $livroValidador->validar($livro);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/livro/edicao/' . $_POST['id']);
        }

        $livroDAO = new LivroDAO();

        if ($livroDAO->verificaDuplicidade($livro)) {
            Sessao::gravaMensagem("Esse livro já esta cadastrado no banco de dados");
            $this->redirect('/livro/edicao/' . $_POST['id']);
        }

        $livroDAO->atualizar($livro);

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/livro');
    }

    public function exclusao($params)
    {
        $id = $params[0];

        $livroDAO = new LivroDAO();

        $livro = $livroDAO->getById($id);

        if (!$livro) {
            Sessao::gravaMensagem("Livro inexistente");
            $this->redirect('/livro');
        }

        self::setViewParam('livro', $livro);

        $this->render('/livro/exclusao');

        Sessao::limpaMensagem();
    }

    public function excluir()
    {
        $livro = new Livro();
        $livro->setIdLivro($_POST['idlivro']);

        $livroDAO = new LivroDAO();

        if (!$livroDAO->excluir($livro)) {
            Sessao::gravaMensagem("Livro inexistente");
            $this->redirect('/produto');
        }

        Sessao::gravaMensagem("Livro excluido com sucesso!");

        $this->redirect('/livro');
    }
}
