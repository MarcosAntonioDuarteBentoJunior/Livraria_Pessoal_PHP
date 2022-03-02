<?php

namespace App\Controllers;

use App\Models\Entidades\Usuario;
use App\Models\DAO\UsuarioDAO;
use App\Lib\Sessao;

class HomeController extends Controller
{
    public function index()
    {
        if (Sessao::retornaUsuarioLogado()) {
            $this->render('usuario/index');
        } else {
            $this->render('home/index');
        }
    }
}
