<?php

namespace App\Entity;

use \PDO;
use \App\Db\Database;

class Unidade
{

    /**
     * Identificador único da unidade
     * @var integer
     */
    public $id;

    /**
     * CEP da unidade
     * @var string
     */
    public $cep;

    /**
     * Bairro da unidade
     * @var string
     */
    public $bairro;

    /**
     * Cidade da unidade
     * @var string
     */
    public $cidade;

    /**
     * Estado da unidade
     * @var string
     */
    public $estado;

    /**
     * Data de abertura da unidade
     * @var date
     */
    public $dataAbertura;

    /**
     * Meta do Mês da unidade
     * @var string
     */
    public $meta;

    /**
     * Gerente da unidade
     * @var integer
     */
    public $gerente;

    /**
     * Endereço da unidade
     * @var string
     */
    public $endereco;

    /**
     * Timezone da unidade
     * @var string
     */
    public $timezone;

    /**
     * Data do cadastro
     * @var datetime
     */
    public $dataCadastro;

    /**
     * Método responsável por cadastrar uma nova unidade no banco
     * @return boolean
     */
    public function cadastrar()
    {
        //DEFINIR A DATA
        $this->dataCadastro = date('Y-m-d H:i:s');

        //INSERIR O CLIENTE NO BANCO
        $obDatabase = new Database('unidades');
        $this->id = $obDatabase->insert([
            'cep'          => $this->cep,
            'bairro'       => $this->bairro,
            'cidade'       => $this->cidade,
            'estado'       => $this->estado,
            'dataAbertura' => $this->dataAbertura,
            'meta'         => $this->meta,
            'gerente'      => $this->gerente,
            'whatsapp'     => $this->whatsapp,
            'endereco'     => $this->endereco,
            'numero'       => $this->numero,
            'timezone'     => $this->timezone,
            'dataCadastro' => $this->dataCadastro
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    // FUNÇÃO PARA ATUALIZAR NO BANCO
    public function atualizar()
    {
        return (new Database('unidades'))->update('id = ' . $this->id, [
            'cep'          => $this->cep,
            'bairro'       => $this->bairro,
            'cidade'       => $this->cidade,
            'estado'       => $this->estado,
            'dataAbertura' => $this->dataAbertura,
            'meta'         => $this->meta,
            'gerente'      => $this->gerente,
            'whatsapp'     => $this->whatsapp,
            'endereco'     => $this->endereco,
            'numero'       => $this->numero,
            'timezone'     => $this->timezone
        ]);
    }

    /**
     * Método responsável por buscar usuário pelo e-mail
     * @return Bairro
     * @return Cidade
     * @return Estado
     */
    public static function getTitleUnidade($id)
    {
        $obUnidade = (new Database('unidades'))->select('id = "' . $id . '"')->fetchObject(self::class);
        $unidade = $obUnidade->bairro . ' - ' . $obUnidade->cidade . ' - ' . $obUnidade->estado;
        return $unidade;
    }

    /**
     * Método responsável por obter as unidades do banco de dados
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @return array
     */
    public static function getUnidades($where = null, $order = null, $limit = null)
    {
        return (new Database('unidades'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por buscar uma unidade com base em seu ID
     * @param  integer $id
     * @return Cliente
     */
    public static function getUnidade($id)
    {
        return (new Database('unidades'))->select('id = ' . $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por excluir a unidade do banco
     * @return boolean
     */
    public function excluir()
    {
        //return (new Database('clientes'))->delete('id = ' . $this->id);
        return (new Database('unidades'))->update('id = ' . $this->id, [
            'ativo' => 'n',
        ]);
    }
}
