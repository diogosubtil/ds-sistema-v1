<?php

namespace App\Login;

class Login
{

    /**
     * Método responsável por iniciar a sessão
     */
    private static function init()
    {
        //VERIFICA STATUS DA SESSÃO
        if (session_status() !== PHP_SESSION_ACTIVE) {
            //INICIA A SESSÃO
            session_start();
        }
    }

    /**
     * Método responsável por retornar os dados do usuário logado
     * @return array
     */
    public static function getUsuarioLogado()
    {
        //INICIA A SESSÃO
        self::init();

        //RETORNA DADOS DO USUÁRIO
        return self::isLogged() ? $_SESSION['usuario'] : null;
    }

    /**
     * Método responsável por logar o usuário
     * @param Usuario $obUsuario
     */
    public static function logar($obUsuario)
    {
        //INICIA A SESSÃO
        self::init();

        //SESSÃO DO USUÁRIO
        $_SESSION['usuario'] = [
            'id'           => $obUsuario->id,
            'funcao'       => $obUsuario->funcao,
            'nome'         => $obUsuario->nome,
            'email'        => $obUsuario->email,
            'telefone'     => $obUsuario->telefone,
            'unidade'      => $obUsuario->unidade,
            'dataCadastro' => $obUsuario->dataCadastro
        ];

        //REDIRECIONA PARA O INDEX
        header('Location: /painel.php');
        exit;
    }

    /**
     * Método responsável por deslogar o usuário
     */
    public static function logout()
    {
        //INICIA A SESSÃO
        self::init();

        //REMOVE A SESSÃO DO USUÁRIO
        unset($_SESSION['usuario']);

        //REDIRECIONA USUÁRIO PARA O LOGIN
        header('Location: /index.php');
        exit;
    }

    /**
     * Método responsável por verificar se o usuário está logado
     * @return boolean
     */
    public static function isLogged()
    {
        //INICIA A SESSÃO
        self::init();

        //VALIDAÇÃO DA SESSÃO
        return isset($_SESSION['usuario']['id']);
    }

    /**
     * Método responsável por obrigar o usuário estar logado
     */
    public static function requireLogin()
    {
        if (!self::isLogged()) {
            header('Location: /11index.php');
            exit;
        }
    }

    /**
     * Método responsável por verificar a função do usuário
     */
    public static function requireFuncao($funcao)
    {
        $funcoesUsuario = explode(',', $_SESSION['usuario']['funcao']);
        $funcoes        = explode(',', $funcao);
        foreach ($funcoes as $funcao) {
            if (in_array($funcao, $funcoesUsuario)) {
                return true;
            }
        }
    }

    /**
     * Método responsável por obrigar o usuário estar deslogado
     */
    public static function requireLogout()
    {
        if (self::isLogged()) {
            header('Location: /painel.php');
            exit;
        }
    }
}
