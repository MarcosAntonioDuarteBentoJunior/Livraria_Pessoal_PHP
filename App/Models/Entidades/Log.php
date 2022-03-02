<?php

namespace App\Models\Entidades;

use DateTime;

class Log
{
    private $idLog;
    private $usuario;
    private $email;
    private $acao;
    private $horario;
    private $idlogado;

    public function getIdLog()
    {
        return $this->idLog;
    }

    public function setIdLog($id)
    {
        $this->idLog = $id;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAcao()
    {
        return $this->acao;
    }

    public function setAcao($acao)
    {
        $this->acao = $acao;
    }

    public function getHorario()
    {
        $horario = new DateTime($this->horario);

        return $horario->format('d/m/Y H:i');
    }

    public function setHorario($horario)
    {
        $this->horario = $horario;
    }

    public function getIdLogado()
    {
        return $this->idlogado;
    }

    public function setIdLogado($id)
    {
        $this->idlogado = $id;
    }
}
