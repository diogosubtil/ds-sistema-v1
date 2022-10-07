<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Estoque;
use \App\Entity\Caixa;
use \App\Entity\Servicos;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//VALIDAÇÃO DO ID
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: /servicos/painelservicos.php?status=error');
    exit;
}

//CONSULTA O AREA
$obServicos = Servicos::getServicoID($_GET['id']);

//VALIDAÇÃO DA AREA
if (!$obServicos instanceof Servicos) {
    header('location: /servicos/painelservicos.php?status=error');
    exit;
}

$obCaixa = Caixa::getServicoCaixa($obServicos->id);
$obCaixa->excluir();

//EXCLUI AREA
$obServicos->excluir();
header('location: /servicos/painelservicos.php?status=success');
