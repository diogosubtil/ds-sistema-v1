<?php

namespace App\Entity;

use \PDO;
use \App\Db\Database;

class Servicos
{
    public $id;
    public $nomevendedor;
    public $nomecliente;
    public $pagamento;
    public $servico;
    public $custo;
    public $valor;
    public $data;
    public $unidade;


    // FUNÇÃO PARA CADASTRAR NO BANCO
    public function cadastrar(){

        //INSERIR NA TABELA
        $obDatabase = new Database('servicos');
        $this->id = $obDatabase->insert([
            'nomevendedor' => $this->nomevendedor,
            'nomecliente' => $this->nomecliente,
            'pagamento' => $this->pagamento,
            'servico' => $this->servico,
            'custo' => $this->custo,
            'valor' => $this->valor,
            'data' => $this->data,
            'unidade' => $this->unidade,
        ]);
    }

    // FUNÇÃO PARA ATUALIZAR NO BANCO
    public function atualizar()
    {
        return (new Database('servicos'))->update('id = ' . $this->id, [
            'nomevendedor' => $this->nomevendedor,
            'nomecliente' => $this->nomecliente,
            'pagamento' => $this->pagamento,
            'servico' => $this->servico,
            'custo' => $this->custo,
            'valor' => $this->valor,
            'data' => $this->data,
            'unidade' => $this->unidade,
        ]);
    }

    //METODO RESPONSAVEL POR OBTER OS REGISTROS
    public static function getServicos ($where = null, $order = null, $limit = null){
        return (new Database('servicos'))->select($where,$order,$limit)
            ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    //METODO RESPONSAVEL POR OBTER SERVICO POR ID
    public static function getServicoID($id)
    {
        return (new Database('servicos'))->select('id = ' . $id)->fetchObject(self::class);
    }

    //METODO RESPONSAVEL POR OBETER TOTAL DE VALOR DOS SERVICOS
    public static function getQtdValorServicos($where = null, $order = null, $limit = null)
    {
        return (new Database('servicos'))->select($where, $order, $limit, 'sum(valor) as qtd')->fetchObject()->qtd;
    }

    //METODO RESPONSAVEL POR OBETER TOTAL DE CUSTOS DOS SERVICOS
    public static function getQtdValorCustos($where = null, $order = null, $limit = null)
    {
        return (new Database('servicos'))->select($where, $order, $limit, 'sum(custo) as qtd')->fetchObject()->qtd;
    }

    //METODO RESPONSAVEL POR OBETER QUANTIDADE DE SERVICOS REALIZADOS
    public static function getQtdServicos($where = null, $order = null, $limit = null)
    {
        return (new Database('servicos'))->select($where, $order, $limit, 'COUNT(*) as qtd ')->fetchObject()->qtd;
    }

    //Método responsável por excluir
    public function excluir()
    {
        return (new Database('servicos'))->delete('id = ' . $this->id);
    }
}