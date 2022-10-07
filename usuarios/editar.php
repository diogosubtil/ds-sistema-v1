<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Usuario;
use \App\Entity\Unidade;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//LISTA DAS UNIDADES
$unidades = Unidade::getUnidades();

//CONSULTA A UNIDADE
$obUsuario = Usuario::getUsuario($_GET['id']);

//VALIDAÇÃO DO POST
if (isset($_POST['nome'], $_POST['funcao'], $_POST['email'])) {

    $obUsuario->nome        = $_POST['nome'];
    $obUsuario->funcao      = $_POST['funcao'];
    $obUsuario->email       = $_POST['email'];
    $obUsuario->telefone    = $_POST['telefone'];
    $obUsuario->unidade     = $_POST['unidade'];

    $obUsuario->atualizar();

    header('location: /usuarios/listar.php?status=success');
    exit;
}

//INCLUI O CABEÇALHO
include __DIR__ . '/../includes/header.php';

?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Usuário</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Editar as informações</h3>
                        </div>

                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" value="<?php echo $obUsuario->nome ?>" id="nome" name="nome" placeholder="Nome" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="email" class="form-control" value="<?php echo $obUsuario->email ?>" id="email" name="email" placeholder="E-mail" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="telefone">Telefone</label>
                                            <input type="text" class="form-control" value="<?php echo $obUsuario->telefone ?>" id="telefone" name="telefone" placeholder="Telefone">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="funcao">Função</label>
                                            <select name="funcao" id="funcao" class="form-control">
                                                <option value="">Selecione...</option>
                                                <option value="1" <?php if ($obUsuario->funcao == '1') {
                                                                        echo 'selected';
                                                                    } ?>>Master</option>
                                                <option value="2" <?php if ($obUsuario->funcao == '2') {
                                                                        echo 'selected';
                                                                    } ?>>Gerente</option>
                                                <option value="3" <?php if ($obUsuario->funcao == '3') {
                                                                        echo 'selected';
                                                                    } ?>>Aplicador</option>
                                                <option value="4" <?php if ($obUsuario->funcao == '4') {
                                                                        echo 'selected';
                                                                    } ?>>Recepçãp/Vendedor</option>
                                                <option value="10" <?php if ($obUsuario->funcao == '10') {
                                                                        echo 'selected';
                                                                    } ?>>Cliente</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="unidade">Unidade</label>
                                            <select name="unidade" id="unidade" class="form-control">
                                                <option value="0">Selecione uma unidade...</option>
                                                <?php foreach ($unidades as $unidade) { ?>
                                                    <option value="<?php echo $unidade->id ?>" <?php if ($obUsuario->unidade == $unidade->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $unidade->bairro . ' - ' . $unidade->cidade; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Editar</button>
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
