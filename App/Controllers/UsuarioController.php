<?php

namespace App\Controllers;

use App\Models\Entidades\Usuario;
use App\Models\DAO\UsuarioDAO;
use App\Models\DAO\LogDAO;
use App\Lib\Sessao;
use App\Models\Validacao\LoginValidador;
use App\Models\Validacao\UsuarioValidador;

class UsuarioController extends Controller
{
    protected $app;

    public function index()
    {
        $this->redirect('/');
    }

    public function login()
    {
        $usuario = new Usuario();
        $usuarioDAO = new UsuarioDAO();
        $log = new LogDAO();
        $loginvalidador = new LoginValidador();

        $usuario->setNomeUsuario($_POST['nomeUsuario']);
        $usuario->setSenha($_POST['senha']);

        $resultadoValidacao = $loginvalidador->validar($usuario);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/');
        }

        $Usuario = $usuarioDAO->buscaUsuario($usuario);

        if (!$Usuario) {
            Sessao::gravaMensagem('Usuario ou senha incorretos. Cadastre-se ou tente novamente.');
            $this->redirect('/');
        }

        Sessao::usuarioLogado($Usuario->getNomeUsuario());
        Sessao::gravaIdUsuario($Usuario->getIdUsuario());
        Sessao::limpaMensagem();

        $log->gravarLOGIN($Usuario);

        $this->render('usuario/index');
    }

    public function cadastro()
    {
        $this->render('usuario/cadastro');

        Sessao::limpaMensagem();
    }

    public function salvar()
    {
        $usuario = new Usuario();
        $usuarioDAO = new UsuarioDAO();
        $usuarioValidador = new UsuarioValidador();

        $usuario->setNomeUsuario($_POST['nomeUsuario']);
        $usuario->setEmail($_POST['email']);
        $usuario->setSenha($_POST['senha']);

        Sessao::gravaFormulario($_POST);

        $resultadoValidacao = $usuarioValidador->validar($usuario);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/usuario/cadastro');
        }

        if ($usuarioDAO->verificaEmail($usuario)) {
            Sessao::gravaMensagem('Email ja existente');
            $this->redirect('/usuario/cadastro');
        }

        if ($usuarioDAO->verificaNomeUsuario($usuario)) {
            Sessao::gravaMensagem('Nome de usuario ja existente');
            $this->redirect('/usuario/cadastro');
        }

        if (!$usuarioDAO->salvar($usuario)) {
            Sessao::gravaMensagem('Erro ao cadastrar');
            $this->redirect('/usuario/cadastro');
        }

        $Usuario = $usuarioDAO->buscaUsuario($usuario);

        Sessao::gravaMensagem('Usuario cadastrado com sucesso');
        Sessao::gravaIdUsuario($Usuario->getIdUsuario());
        Sessao::usuarioLogado($Usuario->getNomeUsuario());

        $this->render('home/index');
    }

    public function edicao($params)
    {
        $id = $params[0];

        if ($id != Sessao::retornaIdUsuario()) {
            Sessao::gravaMensagem("Identificador diferente do usuario logado. Sessao encerrada");
            unset($_SESSION['usuarioLogado']);
            unset($_SESSION['idUsuarioAtual']);

            $this->redirect('/');
        }

        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscaUsuarioByID($id);

        self::setViewParam('usuario', $usuario);

        $this->render('usuario/editar');

        Sessao::limpaMensagem();
    }

    public function atualizar()
    {
        $usuario = new Usuario();
        $usuarioDAO = new UsuarioDAO();
        $usuarioValidador = new UsuarioValidador();

        $usuario->setIdUsuario($_POST['idusuario']);
        $usuario->setNomeUsuario($_POST['nomeUsuario']);
        $usuario->setEmail($_POST['email']);
        $usuario->setSenha($_POST['senha']);

        $Usuario = $usuarioDAO->buscaUsuarioByID($_POST['idusuario']);

        //Sessao::gravaFormulario($_POST);

        $resultadoValidacao = $usuarioValidador->validar($usuario);

        if ($resultadoValidacao->getErros()) {
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/usuario/edicao/' . $_POST['idusuario']);
        }

        if ($usuarioDAO->verificaEmail($usuario) && $usuario->getEmail() != $Usuario->getEmail()) {
            Sessao::gravaMensagem('Email ja existente');
            $this->redirect('/usuario/edicao/' . $_POST['idusuario']);
        }

        if ($usuarioDAO->verificaNomeUsuario($usuario) && $usuario->getNomeUsuario() != $Usuario->getNomeUsuario()) {
            Sessao::gravaMensagem('Nome de usuario ja existente');
            $this->redirect('/usuario/edicao/' . $_POST['idusuario']);
        }

        if (!$usuarioDAO->atualizar($usuario)) {
            Sessao::gravaMensagem('Usuario identico');
            $this->redirect('/usuario/edicao/' . $_POST['idusuario']);
        }

        Sessao::gravaMensagem('Dados atualizados com sucesso');
        Sessao::usuarioLogado($usuario->getNomeUsuario());

        $this->render('usuario/index');
    }

    public function exclusao($params)
    {
        $id = $params[0];

        if ($id != Sessao::retornaIdUsuario()) {
            Sessao::gravaMensagem("Identificador diferente do usuario logado. Sessao encerrada");
            unset($_SESSION['usuarioLogado']);

            $this->redirect('/');
        }

        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscaUsuarioByID($id);

        if (!$usuario) {
            Sessao::gravaMensagem("Usuario inexistente");
            $this->redirect('/usuario/index');
        }

        self::setViewParam('usuario', $usuario);

        $this->render('/usuario/exclusao');

        Sessao::limpaMensagem();
    }

    public function excluir()
    {
        $usuario = new Usuario();
        $usuario->setIdUsuario($_POST['idusuario']);

        $usuarioDAO = new UsuarioDAO();

        if (!$usuarioDAO->excluir($usuario)) {
            Sessao::gravaMensagem("Erro ao excluir usuario");
            $this->redirect('/');
        }

        session_destroy();

        $this->redirect('/');
    }

    public function logout($params)
    {
        $id = $params[0];

        $log = new LogDAO();
        $usuario = new UsuarioDAO();

        $log->gravarLOGOUT($usuario->buscaUsuarioByID($id));

        session_destroy();

        $this->redirect('/');
    }
}
