<?php

require __DIR__.'/vendor/autoload.php';

use \App\Login\Login;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();


include __DIR__.'/includes/header.php';
include __DIR__.'/includes/dashboard.php';
include __DIR__.'/includes/footer.php';