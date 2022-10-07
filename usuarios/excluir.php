<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Usuario;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//VALIDAÇÃO DO ID
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: /unidades/listar.php?status=error');
    exit;
}

//CONSULTA O AREA
$obUsuario = Usuario::getUsuario($_GET['id']);

//VALIDAÇÃO DA AREA
if (!$obUsuario instanceof Usuario) {
    header('location: /usuarios/listar.php?status=error');
    exit;
}

//EXCLUI AREA
$obUsuario->excluir();
header('location: /usuarios/listar.php?status=success');
