<?php

namespace App\Controllers;

use App\Lib\Sessao;

abstract class Controller
{
    protected $app;
    private $viewVar = array();

    public function __construct($app)
    {
        $this->setViewParam('nameController', $app->getControllerName());
        $this->setViewParam('nameAction'    , $app->getAction());

        if (!$this->verificaPermiossaoDeAcesso()) {
            $this->redirect('/');
        }
    }

    public function render($view)
    {
        $viewVar   = $this->getViewVar();
        $Sessao    = Sessao::class;

        require_once PATH . '/App/Views/layouts/header.php';
        require_once PATH . '/App/Views/layouts/menu.php';
        require_once PATH . '/App/Views/' . $view . '.php';
        require_once PATH . '/App/Views/layouts/footer.php';

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();
    }

    public function redirect($view)
    {
        header('Location: http://' . APP_HOST . $view);
        exit;
    }

    public function getViewVar()
    {
        return $this->viewVar;
    }

    public function setViewParam($varName, $varValue)
    {
        if ($varName != "" && $varValue != "") {
            $this->viewVar[$varName] = $varValue;
        }
    }

    public function verificaPermiossaoDeAcesso()
    {
        if (!Sessao::retornaUsuarioLogado()) {
            if ($this->viewVar['nameController'] != 'HomeController') {
                if ($this->viewVar['nameController'] == 'UsuarioController') {
                    if (
                        $this->viewVar['nameAction'] == 'login' ||
                        $this->viewVar['nameAction'] == 'cadastro' ||
                        $this->viewVar['nameAction'] == 'salvar'
                    ) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    }
}
