<?php

namespace App\Entity;

use \PDO;
use \App\Db\Database;

class Caixa
{
    public $id;
    public $idvenda;
    public $idservico;
    public $usuario;
    public $unidade;
    public $tipo;
    public $descricao;
    public $valor;
    public $data;


    // FUNÇÃO PARA CADASTRAR NO BANCO
    public function cadastrar(){

        //INSERIR NA TABELA
        $obDatabase = new Database('caixa');
        $this->id = $obDatabase->insert([
            'idvenda' => $this->idvenda,
            'idservico' => $this->idservico,
            'usuario' => $this->usuario,
            'unidade' => $this->unidade,
            'tipo' => $this->tipo,
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'data' => $this->data
        ]);
    }

    // FUNÇÃO PARA ATUALIZAR NO BANCO
    public function atualizar()
    {
        return (new Database('caixa'))->update('id = ' . $this->id, [
            'idvenda' => $this->idvenda,
            'idservico' => $this->idservico,
            'usuario' => $this->usuario,
            'unidade' => $this->unidade,
            'tipo' => $this->tipo,
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'data' => $this->data
        ]);
    }

    //METODO RESPONSAVEL POR OBTER OS REGISTROS
    public static function getCaixa ($where = null, $order = null, $limit = null){
        return (new Database('caixa'))->select($where,$order,$limit)
            ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    //METODO RESPONSAVEL POR OBTER CAIXA POR ID
    public static function getCaixaID($id)
    {
        return (new Database('caixa'))->select('id = ' . $id)->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBTER REGISTRO POR IDVENDA
    public static function getVendaCaixa($id)
    {
        return (new Database('caixa'))->select('idvenda = ' . $id)->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBTER REGISTRO POR IDVENDA
    public static function getServicoCaixa($id)
    {
        return (new Database('caixa'))->select('idservico = ' . $id)->fetchObject(self::class);
    }

    //METODO PARA OBTER QUANTIDADE DE REGISTRO NO CAIXA
    public static function getQtdRegistros($where = null, $order = null, $limit = null)
    {
        return (new Database('caixa'))->select($where, $order, $limit, 'COUNT(*) as qtd ')->fetchObject()->qtd;
    }

    //METODO PARA OBTER O VALOR TOTAL, ENTRADA E SAIDA DO CAIXA
    public static function getQtdValor($where = null, $order = null, $limit = null)
    {
        return (new Database('caixa'))->select($where, $order, $limit, 'sum(valor) as qtd')->fetchObject()->qtd;
    }

    //Método responsável por excluir
    public function excluir()
    {
        return (new Database('caixa'))->delete('id = ' . $this->id);
    }
}