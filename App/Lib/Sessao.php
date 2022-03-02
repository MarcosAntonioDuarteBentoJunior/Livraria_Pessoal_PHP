<?php

namespace App\Lib;

class Sessao
{
    public static function gravaMensagem($mensagem)
    {
        $_SESSION['mensagem'] = $mensagem;
    }

    public static function limpaMensagem()
    {
        unset($_SESSION['mensagem']);
    }

    public static function retornaMensagem()
    {
        return ($_SESSION['mensagem']) ? $_SESSION['mensagem'] : "";
    }

    public static function usuarioLogado($usuario)
    {
        $_SESSION['usuarioLogado'] = $usuario;
    }

    public static function retornaUsuarioLogado()
    {
        return ($_SESSION['usuarioLogado']) ? $_SESSION['usuarioLogado'] : "";
    }

    public static function gravaIdUsuario($id)
    {
        $_SESSION['idUsuarioAtual'] = $id;
    }

    public static function retornaIdUsuario()
    {
        return ($_SESSION['idUsuarioAtual']) ? $_SESSION['idUsuarioAtual'] : "";
    }

    public static function limpaUsuario()
    {
        unset($_SESSION['usuarioLogado']);
    }

    public static function gravaFormulario($form)
    {
        $_SESSION['form'] = $form;
    }

    public static function limpaFormulario()
    {
        unset($_SESSION['form']);
    }

    public static function retornaValorFormulario($key)
    {
        return (isset($_SESSION['form'][$key])) ? $_SESSION['form'][$key] : "";
    }

    public static function existeFormulario()
    {
        return (isset($_SESSION['form'])) ? $_SESSION['form'] : "";
    }

    public static function gravaErro($erros)
    {
        $_SESSION['erro'] = $erros;
    }

    public static function retornaErro()
    {
        return (isset($_SESSION['erro'])) ? $_SESSION['erro'] : false;
    }

    public static function limpaErro()
    {
        unset($_SESSION['erro']);
    }
}
