<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../includes/Funcoes.php';

use \App\Login\Login;
use \App\Entity\Unidade;
use \App\Entity\Usuario;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

// LISTA DE unidades DO BANCO
$unidades = Unidade::getUnidades();

//INCLUI O CABEÇALHO
include __DIR__ . '/../includes/header.php';
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lojas</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <a href="/unidades/cadastrar.php" class="btn btn-primary mb-3">Cadastrar Loja</a>

            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Gerente</th>
                                <th>Bairro</th>
                                <th>Cidade</th>
                                <th>UF</th>
                                <th>Endereço</th>
                                <th>Número</th>
                                <th>Whatsapp</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($unidades as $unidade) { ?>
                                <tr>
                                    <td><?php $obUsuario = Usuario::getUsuario($unidade->gerente);
                                        echo $obUsuario->nome; ?></td>
                                    <td><?php echo $unidade->bairro ?></td>
                                    <td><?php echo $unidade->cidade ?></td>
                                    <td><?php echo $unidade->estado ?></td>
                                    <td><?php echo $unidade->endereco ?></td>
                                    <td><?php echo $unidade->numero ?></td>
                                    <td><?php echo $unidade->whatsapp ?></td>

                                    <td>
                                        <a href="/unidades/editar.php?id=<?php echo $unidade->id ?>">
                                            <button type="button" class="btn btn-primary">Editar</button>
                                        </a>

                                        <?php
                                        /**
                                         * Master, Gerente
                                         */
                                        if (Login::requireFuncao('1,2')) { ?>
                                            <a href="/unidades/excluir.php?id=<?php echo $unidade->id ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir?');">
                                                Excluir
                                            </a>
                                        <?php } ?>

                                    </td>
                                </tr>

                            <?php } ?>

                            <?php if (empty($unidades)) { ?>
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Nenhuma unidade encontrada
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Gerente</th>
                                <th>Bairro</th>
                                <th>Cidade</th>
                                <th>UF</th>
                                <th>Endereço</th>
                                <th>Número</th>
                                <th>Whatsapp</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
    </div>

</div>

<?php

//INCLUI O FOOTER
include __DIR__ . '/../includes/footer.php';
