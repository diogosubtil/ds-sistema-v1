<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../includes/Funcoes.php';

use \App\Login\Login;
use \App\Entity\Notificacoes;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBJETO NOTIFICAÇÃO

while (!empty($obNotificacao = Notificacoes::getNotificacoesLido())){
    $obNotificacao = Notificacoes::getNotificacoesLido();
    $obNotificacao->lido = 's';
    $obNotificacao->atualizar();
}

header('Location: /painel.php');
