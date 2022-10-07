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
    header('location: /estoque/painelestoque.php?status=error');
    exit;
}

//CONSULTA O AREA
$obEstoque = Estoque::getProduto($_GET['id']);

//VALIDAÇÃO DA AREA DO CAIXA
if (!$obEstoque instanceof Estoque) {
    header('location: /estoque/painelestoque.php?status=error');
    exit;
}

//EXCLUI AREA
$obEstoque->excluir();
header('location: /estoque/painelestoque.php?status=success');
