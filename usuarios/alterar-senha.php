<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Usuario;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//CONSULTA O CLIENTE
$obUsuario = Usuario::getUsuario($_GET['id']);

$senhaInvalida = '';

//VALIDAÇÃO DO POST
if (isset($_POST['senha-antiga'], $_POST['nova-senha'])) {

    //VALIDA A SENHA ANTIGA
    if (!password_verify($_POST['senha-antiga'], $obUsuario->senha)) {
        $senhaInvalida = 'Senha antiga inválida.';
    } else {
        //SE TIVER TUDO CERTO, CADASTRA A NOVA SENHA
        $obUsuario->senha = password_hash($_POST['nova-senha'], PASSWORD_DEFAULT);
        $obUsuario->atualizar();

        header('location: /usuarios/listar.php?status=success');
        exit;
    }
}

//INCLUI O CABEÇALHO
include __DIR__ . '/../includes/header.php';
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Alterar Senha</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <?php echo $senhaInvalida = strlen($senhaInvalida) ? '<div class="alert alert-danger">' . $senhaInvalida . '</div>' : ''; ?>

            <div class="row">
                <div class="col">

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title"><strong><?php echo $obUsuario->nome ?></strong></h3>
                        </div>

                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="senha-antiga">Senha Antiga</label>
                                            <input type="password" class="form-control" id="senha-antiga" name="senha-antiga" value="" placeholder="Senha Antiga">
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="nova-senha">Nova Senha</label>
                                            <input type="password" class="form-control" id="nova-senha" name="nova-senha" value="" placeholder="Nova Senha">
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Editar</button>
                                <a href="/usuarios/listar.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<?php

//INCLUI O FOOTER
include __DIR__ . '/../includes/footer.php';
