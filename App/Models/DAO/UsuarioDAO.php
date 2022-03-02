<?php

namespace App\Models\DAO;

use App\Models\Entidades\Usuario;
use Exception;

class UsuarioDAO extends BaseDAO
{

    public function buscaUsuarioByID($id)
    {
        try {

            $resultado = $this->select(
                "SELECT idUsuario   AS idUsuario,
                        email       AS email,
                        senha       AS senha, 
                        nomeUsuario AS nomeUsuario
                    FROM usuarios 
                    WHERE idUsuario=$id"
            );

            return $resultado->fetchObject(Usuario::class);
        } catch (\Exception $e) {
            throw new Exception('Erro: ' . $e->getMessage());
        }
    }

    public function buscaUsuario(Usuario $usuario)
    {
        try {
            $usuarioNome = $usuario->getNomeUsuario();
            $usuarioSenha = $usuario->getSenha();

            $resultado = $this->select(
                "SELECT idUsuario   AS idUsuario,
                        email       AS email,
                        senha       AS senha, 
                        nomeUsuario AS nomeUsuario
                    FROM usuarios 
                    WHERE nomeUsuario='$usuarioNome' AND senha='$usuarioSenha'"
            );

            return $resultado->fetchObject(Usuario::class);
        } catch (\Exception $e) {
            throw new Exception('Erro: ' . $e->getMessage());
        }
    }

    public function verificaEmail(Usuario $usuario)
    {
        try {

            $usuarioEmail = $usuario->getEmail();

            $resultado = $this->select(
                "SELECT 
                        idUsuario   AS idUsuario,
                        email       AS email,
                        senha       AS senha, 
                        nomeUsuario AS nomeUsuario
                FROM usuarios 
                WHERE email='$usuarioEmail'
                "
            );

            return $resultado->rowCount();
        } catch (\Exception $e) {
            throw new Exception('Erro: ' . $e->getMessage());
        }
    }

    public function verificaNomeUsuario(Usuario $usuario)
    {
        try {

            $usuarioNome = $usuario->getNomeUsuario();

            $resultado = $this->select(
                "SELECT 
                        idusUario   AS idUsuario,
                        email       AS email,
                        senha       AS senha, 
                        nomeUsuario AS nomeUsuario
                FROM usuarios 
                WHERE nomeUsuario='$usuarioNome'
                "
            );

            return $resultado->rowCount();
        } catch (\Exception $e) {
            throw new Exception('Erro: ' . $e->getMessage());
        }
    }

    public function salvar(Usuario $usuario)
    {
        try {
            $usuarioNome    = $usuario->getNomeUsuario();
            $usuarioEmail   = $usuario->getEmail();
            $senha          = $usuario->getSenha();


            return $this->insert(
                'usuarios',
                ":email,:senha,:nomeUsuario",
                [
                    ':email'       => $usuarioEmail,
                    ':senha'       => $senha,
                    ':nomeUsuario' => $usuarioNome,
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception("Erro na gravação de dados: " . $e->getMessage(), 500);
        }
    }

    public function atualizar(Usuario $usuario)
    {
        try {
            $idusuario      = $usuario->getIdUsuario();
            $usuarioNome    = $usuario->getNomeUsuario();
            $usuarioEmail   = $usuario->getEmail();
            $senha          = $usuario->getSenha();

            return $this->update(
                'usuarios',
                "email = :email, senha = :senha, nomeUsuario = :nomeUsuario",
                [
                    ':idUsuario'   => $idusuario,
                    ':email'       => $usuarioEmail,
                    ':senha'       => $senha,
                    ':nomeUsuario' => $usuarioNome
                ],
                "idUsuario = :idUsuario"
            );
        } catch (\Exception $e) {
            throw new \Exception("Erro na gravação de dados: " . $e->getMessage(), 500);
        }
    }

    public function excluir(Usuario $usuario)
    {
        try {
            $id = $usuario->getIdUsuario();

            $this->delete('usuarios_cadastram_livros', "idUsuario = $id");

            $this->delete('usuarios_cadastram_categorias', "idUsuario = $id");

            return $this->delete('usuarios', "idUsuario = $id");
        } catch (\Exception $e) {

            throw new \Exception("Erro ao deletar: " . $e->getMessage(), 500);
        }
    }
}
