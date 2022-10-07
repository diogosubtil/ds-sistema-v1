<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Venda;
use \App\Entity\Estoque;
use \App\Entity\Caixa;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//VALIDAÇÃO DO ID
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: /vendas/painelvendas.php?status=error');
    exit;
}

//CONSULTA O AREA
$obVenda = Venda::getVenda($_GET['id']);

//VALIDAÇÃO DA AREA
if (!$obVenda instanceof Venda) {
    header('location: /vendas/painelvendas.php?status=error');
    exit;
}

//ATUALIZA O ESTOQUE
if (!empty($obEstoque = Estoque::getProduto($obVenda->idproduto))) {
    $obEstoque = Estoque::getProduto($obVenda->idproduto);
    $obEstoque->quantidade = $obEstoque->quantidade + $obVenda->quantidade;
    $obEstoque->totalvalor = $obEstoque->totalvalor + $obVenda->valortotal;
    $obEstoque->atualizar();
}
//EXCLUI O REGISTRO DO CAIXA
$obCaixa = Caixa::getVendaCaixa($obVenda->id);
$obCaixa->excluir();


//EXCLUI AREA
$obVenda->excluir();
header('location: /vendas/painelvendas.php?status=success');
