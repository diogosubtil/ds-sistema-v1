<?php
require __DIR__.'/vendor/autoload.php';

use \App\Entity\Usuario;
use \App\Login\Login;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogout();

//MENSAGENS DE ALERTA DO FORMULÁRIO
$alertaLogin = '';

//VALIDAÇÃO DO POST
if (isset($_POST['email'], $_POST['senha'])) {

    //BUSCA USUÁRIO POR E-MAIL
    $obUsuario = Usuario::getUserByEmail($_POST['email']);

    //VALIDA A INSTANCIA E A SENHA
    if (!$obUsuario instanceof Usuario || !password_verify($_POST['senha'], $obUsuario->senha)) {
        $alertaLogin = 'E-mail ou senha inválidos';
    } else {
        //LOGA O USUÁRIO
        Login::logar($obUsuario);
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Gestão</title>
    <link rel="shortcut icon" type="imagex/png" href="/assets/img/icons/DSicone.ico">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/css/adminlte.min.css">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fff">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Depilação a laser, definitiva e sem dor!">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="assets/img/icone-icelaser.png">
    <meta name="msapplication-TileColor" content="#fff">

</head>
<body class="hold-transition bg-primary login-page">
            <p class="login-box-msg"><b>Email:</b> admin@admin.com.br - <b>Senha:</b> admin</p>
<div class="login-box">

    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center" style="color: silver">
            <a href="#" class="h1"><b>DS </b>Sistema</a>
        </div>
        <div class="card-body  login-card-body">

            <p class="login-box-msg">Faça login para iniciar sua sessão</p>


            <?php echo $alertaLogin = strlen($alertaLogin) ? '<div class="alert alert-danger">'.$alertaLogin.'</div>' : ''; ?>

            <form action="" method="POST">

                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control" placeholder="E-mail">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-at"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="senha" class="form-control" placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Acessar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.min.js"></script>
</body>
</html>
