<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Unidade;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//VALIDAÇÃO DO ID
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: /unidades/listar.php?status=error');
    exit;
}

//CONSULTA O UNIDADE
$obUnidade = Unidade::getUnidade($_GET['id']);

//VALIDAÇÃO DA UNIDADE
if (!$obUnidade instanceof Unidade) {
    header('location: /unidades/listar.php?status=error');
    exit;
}

//EXCLUI A UNIDADE
$obUnidade->excluir();
header('location: /unidades/listar.php?status=success');
