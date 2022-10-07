<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Venda;
use \App\Entity\Estoque;
use \App\Entity\Caixa;
use \App\Entity\Servicos;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//VALIDAÇÃO DO ID
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: /caixa/painelcaixa.php?status=error');
    exit;
}

//CONSULTA O AREA
$obCaixa = Caixa::getCaixaID($_GET['id']);

//VALIDAÇÃO DA AREA DO CAIXA
if (!$obCaixa instanceof Caixa) {
    header('location: /caixa/painelcaixa.php?status=error');
    exit;
}

if (!empty($obCaixa->idvenda)){
    $obVenda = Venda::getVenda($obCaixa->idvenda);
    if (!empty($obEstoque = Estoque::getProduto($obVenda->idproduto))){
        $obEstoque = Estoque::getProduto($obVenda->idproduto);
        $obEstoque->quantidade = $obEstoque->quantidade+$obVenda->quantidade;
        $obEstoque->totalvalor = $obEstoque->totalvalor+$obVenda->valortotal;
        $obEstoque->atualizar();
    }
    $obVenda->excluir();
} elseif (!empty($obCaixa->idservico)) {
    $obServico = Servicos::getServicoID($obCaixa->idservico);
    $obServico->excluir();
}

//EXCLUI AREA
$obCaixa->excluir();
header('location: /caixa/painelcaixa.php?status=success');
