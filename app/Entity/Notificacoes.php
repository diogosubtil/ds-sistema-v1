<?php

namespace App\Entity;

use App\Db\Database;
use PDO;

class Notificacoes
{
    public $id;
    public $title;
    public $idusuario;
    public $tipo;
    public $unidade;
    public $descricao;
    public $lido;
    public $data;


    public function cadastrar(){
        //INSERIR NA TABELA
        $obDatabase = new Database('notificacoes');
        $this->id = $obDatabase->insert([
            'title' => $this->title,
            'idusuario' => $this->idusuario,
            'tipo' => $this->tipo,
            'unidade' => $this->unidade,
            'descricao' => $this->descricao,
            'lido' => $this->lido,
            'data' => $this->data,
        ]);
    }

    // FUNÇÃO PARA ATUALIZAR NO BANCO
    public function atualizar()
    {
        return (new Database('notificacoes'))->update('id = ' . $this->id, [
            'title' => $this->title,
            'idusuario' => $this->idusuario,
            'tipo' => $this->tipo,
            'unidade' => $this->unidade,
            'descricao' => $this->descricao,
            'lido' => $this->lido,
            'data' => $this->data,
        ]);
    }

    //METODO RESPONSAVEL POR OBTER AS NOTIFICAÇÕES
    public static function getNotificacoes ($where = null, $order = null, $limit = null){
        return (new Database('notificacoes'))->select($where,$order,$limit)
            ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    //METODO RESPONSAVEL POR OBTER NOTIFICAÇÕES POR ID
    public static function getNotificacoesID($id)
    {
        return (new Database('notificacoes'))->select('id = ' . $id)->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBTER NOTIFICAÇÕES POR LIDO
    public static function getNotificacoesLido()
    {
        return (new Database('notificacoes'))->select('lido = "n"')->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBETER QUANTIDADE DE NOTIFICAÇÕES
    public static function getQtdNotificacoes($where = null, $order = null, $limit = null)
    {
        return (new Database('notificacoes'))->select($where, $order, $limit, 'COUNT(*) as qtd ')->fetchObject()->qtd;
    }

    //Método responsável por excluir
    public function excluir()
    {
        return (new Database('notificacoes'))->delete('id = ' . $this->id);
    }
}