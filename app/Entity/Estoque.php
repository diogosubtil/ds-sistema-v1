<?php

namespace App\Entity;

use \PDO;
use \App\Db\Database;

class Estoque
{
    public $id;
    public $nome;
    public $tipo;
    public $descricao;
    public $valor;
    public $quantidade;
    public $valorvenda;
    public $unidade;
    public $totalvalor;
    public $data;

    //METODO PARA CADASTRAR NA TABELA
    public function cadastrar(){

        //DEFINIR A DATA
        $this->data = date('Y-m-d H:i:s');

        //INSERIR NA TABELA
        $obDatabase = new Database('estoque');
        $this->id = $obDatabase->insert([
            'nome' => $this->nome,
            'tipo' => $this->tipo,
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'quantidade' => $this->quantidade,
            'valorvenda' => $this->valorvenda,
            'unidade' => $this->unidade,
            'totalvalor' => $this->totalvalor,
            'data' => $this->data,
        ]);
    }

    // FUNÇÃO PARA ATUALIZAR NO BANCO
    public function atualizar()
    {
        return (new Database('estoque'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'tipo' => $this->tipo,
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'quantidade' => $this->quantidade,
            'valorvenda' => $this->valorvenda,
            'unidade' => $this->unidade,
            'totalvalor' => $this->totalvalor,
        ]);
    }

    //METODO PARA OBTER NOME DO PRODUTO
    public static function getNomedoProduto($id)
    {
        $obNomeProduto = (new Database('estoque'))->select('id = "' . $id . '"')->fetchObject(self::class);
        $NomeProduto = $obNomeProduto->id.' - '.$obNomeProduto->nome;
        return $NomeProduto;
    }

    //METODO RESPONSAVEL POR OBTER LISTA DO ESTOQUE
    public static function getEstoque ($where = null, $order = null, $limit = null){
        return (new Database('estoque'))->select($where,$order,$limit)
            ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    //METODO RESPONSAVEL POR OBTER PRODUTO POR ID
    public static function getProduto($id)
    {
        return (new Database('estoque'))->select('id = ' . $id)->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBETER QUANTIDADE DE PRODUTO NO ESTOQUE
    public static function getQtdProdutosEstoque($where = null, $order = null, $limit = null)
    {
        return (new Database('estoque'))->select($where, $order, $limit, 'COUNT(*) as qtd ')->fetchObject()->qtd;
    }

    //METODO RESPONSAVEL POR OBETER VALOR DO ESTOQUE
    public static function getQtdValorEstoque($where = null, $order = null, $limit = null)
    {
        return (new Database('estoque'))->select($where, $order, $limit, 'sum(totalvalor) as qtd')->fetchObject()->qtd;
    }

    //METODO RESPONSAVEL POR OBETER QUANTIDADE DE ITENS NO ESTOQUE
    public static function getQtdItensEstoque($where = null, $order = null, $limit = null)
    {
        return (new Database('estoque'))->select($where, $order, $limit, 'sum(quantidade) as qtd')->fetchObject()->qtd;
    }

    //METODO PARA DAR EXCLUIR DA TABELA
    public function excluir()
    {
        return (new Database('estoque'))->delete('id = ' . $this->id);
    }


}