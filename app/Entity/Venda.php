<?php

namespace App\Entity;

use \PDO;
use \App\Db\Database;

class Venda
{
    public $id;
    public $nomevendedor;
    public $nomecliente;
    public $tipo;
    public $idproduto;
    public $unidade;
    public $quantidade;
    public $valorproduto;
    public $valortotal;
    public $data;


    // FUNÇÃO PARA CADASTRAR NO BANCO
    public function cadastrar(){

        //INSERIR NA TABELA
        $obDatabase = new Database('venda');
        $this->id = $obDatabase->insert([
            'nomevendedor' => $this->nomevendedor,
            'nomecliente' => $this->nomecliente,
            'tipo' => $this->tipo,
            'idproduto' => $this->idproduto,
            'unidade' => $this->unidade,
            'quantidade' => $this->quantidade,
            'valorproduto' => $this->valorproduto,
            'valortotal' => $this->valortotal,
            'data' => $this->data,
        ]);
    }

    // FUNÇÃO PARA ATUALIZAR NO BANCO
    public function atualizar()
    {
        return (new Database('venda'))->update('id = ' . $this->id, [
            'nomevendedor' => $this->nomevendedor,
            'nomecliente' => $this->nomecliente,
            'tipo' => $this->tipo,
            'idproduto' => $this->idproduto,
            'unidade' => $this->unidade,
            'quantidade' => $this->quantidade,
            'valorproduto' => $this->valorproduto,
            'valortotal' => $this->valortotal,
            'data' => $this->data,
        ]);
    }

    //METODO RESPONSAVEL POR OBTER OS REGISTROS
    public static function getVendas ($where = null, $order = null, $limit = null){
        return (new Database('venda'))->select($where,$order,$limit)
            ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    //METODO RESPONSAVEL POR OBTER VENDA POR ID
    public static function getVenda($id)
    {
        return (new Database('venda'))->select('id = ' . $id)->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBETER TOTAL DE VANDAS
    public static function getQtdValorVenda($where = null, $order = null, $limit = null)
    {
        return (new Database('venda'))->select($where, $order, $limit, 'sum(valortotal) as qtd')->fetchObject()->qtd;
    }

    //METODO RESPONSAVEL POR OBETER TOTAL DE PRODUTOS VENDIDOS
    public static function getQtdProdutosVendidos($where = null, $order = null, $limit = null)
    {
        return (new Database('venda'))->select($where, $order, $limit, 'sum(quantidade) as qtd')->fetchObject()->qtd;
    }

    //METODO RESPONSAVEL POR OBETER QUANTIDADE DE VENDAS
    public static function getQtdVendas($where = null, $order = null, $limit = null)
    {
        return (new Database('venda'))->select($where, $order, $limit, 'COUNT(*) as qtd ')->fetchObject()->qtd;
    }


     //Método responsável por excluir
    public function excluir()
    {
        return (new Database('venda'))->delete('id = ' . $this->id);
    }

}