<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Usuario;
use \App\Entity\Unidade;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBJETO UNIDADE
$obUsuario = new Usuario;

//LISTA DAS UNIDADES
$unidades = Unidade::getUnidades();

//VALIDAÇÃO DO POST
if (isset($_POST['nome'], $_POST['funcao'], $_POST['email'], $_POST['telefone'], $_POST['unidade'], $_POST['senha'])) {

    $obUsuario->senha       = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $obUsuario->nome        = $_POST['nome'];
    $obUsuario->funcao      = $_POST['funcao'];
    $obUsuario->email       = $_POST['email'];
    $obUsuario->usuario     = $_POST['usuario'];
    $obUsuario->telefone    = $_POST['telefone'];
    $obUsuario->unidade     = $_POST['unidade'];

    $obUsuario->cadastrar();

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
                    <h1 class="m-0">Cadastrar Usuário</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="card card-secondary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Insira as informações</h3>
                        </div>

                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="senha">Usuario</label>
                                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="senha">Senha</label>
                                            <input type="text" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="telefone">Telefone</label>
                                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="funcao">Função</label>
                                            <select name="funcao" id="funcao" class="form-control">
                                                <option value="">Selecione...</option>
                                                <option value="1">Master</option>
                                                <option value="2">Gerente</option>
                                                <option value="4">Recepção/Vendedor</option>
                                                <option value="10">Cliente</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="unidade">Unidade</label>
                                            <select name="unidade" id="unidade" class="form-control">
                                                <option value="0">Selecione uma unidade...</option>
                                                <?php foreach ($unidades as $unidade) { ?>
                                                    <option value="<?php echo $unidade->id ?>"><?php echo $unidade->bairro . ' - ' . $unidade->cidade; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary">Cadastrar</button>
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
