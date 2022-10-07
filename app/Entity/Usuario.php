<?php

namespace App\Entity;

use \PDO;
use \App\Db\Database;

class Usuario
{

    /**
     * Identificador único do usuario
     * @var integer
     */
    public $id;

    /**
     * Função do usuario
     * @var integer
     */
    public $funcao;

    /**
     * Nome do usuario
     * @var string
     */
    public $nome;

    /**
     * E-mail do usuario
     * @var string
     */
    public $email;

    /**
     * Usuario do usuario
     * @var string
     */
    public $usuario;

    /**
     * Senha do usuario
     * @var string
     */
    public $senha;

    /**
     * Telefone do usuario
     * @var string
     */
    public $telefone;

    /**
     * Unidade do usuario
     * @var integer
     */
    public $unidade;

    /**
     * Se o usuário ta em treinamento
     * @var string
     */
    public $treinamento;

    /**
     * Data do cadastro
     * @var datetime
     */
    public $dataCadastro;

    /**
     * Método responsável por cadastrar um novo usuário no banco
     * @return boolean
     */
    public function cadastrar()
    {
        //DEFINIR A DATA
        $this->dataCadastro = date('Y-m-d H:i:s');

        //INSERIR O CLIENTE NO BANCO
        $obDatabase = new Database('usuarios');
        $this->id = $obDatabase->insert([
            'nome'          => $this->nome,
            'funcao'        => $this->funcao,
            'email'         => $this->email,
            'usuario'       => $this->usuario,
            'senha'         => $this->senha,
            'telefone'      => $this->telefone,
            'unidade'       => $this->unidade,
            'dataCadastro'   => $this->dataCadastro,
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar o usuário no banco
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('usuarios'))->update('id = ' . $this->id, [
            'nome'          => $this->nome,
            'funcao'        => $this->funcao,
            'email'         => $this->email,
            'usuario'       => $this->usuario,
            'senha'         => $this->senha,
            'telefone'      => $this->telefone,
            'unidade'       => $this->unidade,
            'treinamento'   => $this->treinamento
        ]);
    }

    /**
     * Método responsável por obter os usuários do banco de dados
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @return array
     */
    public static function getUsuarios($where = null, $order = null, $limit = null)
    {
        return (new Database('usuarios'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por buscar usuário pelo e-mail
     * @return Usuario
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar usuário pelo usuario
     * @return Usuario
     */
    public static function getUserByUsuario($usuario)
    {
        return (new Database('usuarios'))->select('usuario = "' . $usuario . '"')->fetchObject(self::class);
    }

    /**
     * Método responsável por buscar usuário pelo id
     * @return Usuario
     */
    public static function getUsuario($id)
    {
        $obUnidade = (new Database('usuarios'))->select('id = "' . $id . '"')->fetchObject(self::class);
        return $obUnidade;
    }

    /**
     * Método responsável por mostrar nome do usuário pelo id
     * @return Nome
     */
    public static function getTitleUsuario($id)
    {
        $obUsuario = (new Database('usuarios'))->select('id = "' . $id . '"')->fetchObject(self::class);
        return $obUsuario->nome;
    }

    /**
     * Método responsável por excluir um usuário
     * @return boolean
     */
    public function excluir()
    {
        //return (new Database('clientes'))->delete('id = ' . $this->id);
        return (new Database('usuarios'))->update('id = ' . $this->id, [
            'ativo' => 'n',
        ]);
    }
}
