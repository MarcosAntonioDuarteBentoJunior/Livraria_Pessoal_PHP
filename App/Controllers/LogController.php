<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Models\DAO\LogDAO;

class LogController extends Controller
{
    public function index()
    {
        $UsuarioLog = new LogDAO();

        $usuario_info = $UsuarioLog->retornaEstatisticas(Sessao::retornaIdUsuario());

        self::setViewParam('info', $usuario_info);

        $this->render('log/index');
    }
}
