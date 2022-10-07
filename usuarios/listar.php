<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../includes/Funcoes.php';

use \App\Login\Login;
use \App\Entity\Usuario;
use \App\Entity\Unidade;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

// LISTA DE UNIDADES DO BANCO
$usuarios = Usuario::getUsuarios('ativo="s"');

//INCLUI O CABEÇALHO
include __DIR__ . '/../includes/header.php';
?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Usuários</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <a href="/usuarios/cadastrar.php" class="btn btn-lg bg-primary mb-3">Cadastrar Usuário</a>

            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="list" class="list table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Função</th>
                                <th>Unidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $usuario) { ?>
                                <tr>
                                    <td><?php echo $usuario->nome ?></td>
                                    <td><?php echo $usuario->email ?></td>
                                    <td><?php echo '<strong>' . funcao($usuario->funcao) . '</strong>'; ?></td>
                                    <td><?php echo Unidade::getTitleUnidade($usuario->unidade); ?></td>
                                    <td>
                                        <a href="/usuarios/editar.php?id=<?php echo $usuario->id ?>">
                                            <button type="button" class="btn btn-primary">Editar</button>
                                        </a>
                                        <a href="/usuarios/alterar-senha.php?id=<?php echo $usuario->id ?>">
                                            <button type="button" class="btn btn-warning">Alterar Senha</button>
                                        </a>
                                        <?php
                                        /**
                                         * Master, Gerente
                                         */
                                        if (Login::requireFuncao('1,2')) {
                                            if ($_SESSION['usuario']['funcao'] == '1' && $_SESSION['usuario']['funcao'] !== $usuario->funcao ) {
                                            ?>
                                            <a href="/usuarios/excluir.php?id=<?php echo $usuario->id ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir?');">
                                                Excluir
                                            </a>
                                        <?php } elseif ($_SESSION['usuario']['funcao'] == '2' && $usuario->funcao == '4' || $usuario->funcao == '10' ) {?>
                                                <a href="/usuarios/excluir.php?id=<?php echo $usuario->id ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir?');">
                                                    Excluir
                                                </a>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>

                            <?php } ?>

                            <?php if (empty($usuarios)) { ?>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Nenhum usuário encontrado
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Função</th>
                                <th>Unidade</th>
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
