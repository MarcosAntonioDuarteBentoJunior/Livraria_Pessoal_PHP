<?php

namespace App\Models\DAO;

use App\Lib\Sessao;
use App\Models\Entidades\Usuario;
use App\Models\Entidades\Log;

class LogDAO extends BaseDAO
{
    public function gravarLOGIN(Usuario $usuario)
    {
        $nome = $usuario->getNomeUsuario();
        $email = $usuario->getEmail();

        return $this->insert(
            'estatisticas',
            ':usuario,:email,:acao,:idlogado',
            [
                ":usuario"  => $nome,
                ":email"    => $email,
                ":acao"     => "LOGIN",
                ":idlogado" => Sessao::retornaIdUsuario()
            ]
        );
    }

    public function gravarLOGOUT(Usuario $usuario)
    {
        $nome = $usuario->getNomeUsuario();
        $email = $usuario->getEmail();

        return $this->insert(
            'estatisticas',
            ':usuario,:email,:acao,:idlogado',
            [
                ":usuario"  => $nome,
                ":email"    => $email,
                ":acao"     => "LOGOUT",
                ":idlogado" => Sessao::retornaIdUsuario()
            ]
        );
    }

    public function retornaEstatisticas($idLogado)
    {

        $resultado = $this->select(
            "SELECT estatisticas.idLog   AS idLog,
                    estatisticas.usuario AS usuario, 
                    estatisticas.email   AS email, 
                    estatisticas.acao    AS acao, 
                    estatisticas.horario AS horario 
            FROM estatisticas
            WHERE idlogado = $idLogado
            ORDER BY horario DESC
            "
        );

        return $resultado->fetchAll(\PDO::FETCH_CLASS, Log::class);
    }
}
