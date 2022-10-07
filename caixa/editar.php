<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Caixa;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBTEM OS REGISTROS
$listaCaixa = Caixa::getCaixa('','id desc','10');

//OBJETO UNIDADE
$obCaixa = Caixa::getCaixaID($_GET['id']);

//VALIDAÇÃO DO POST
if (isset($_POST['descricao'], $_POST['tipo'], $_POST['valor'], $_POST['data'])) {

    $obCaixa->usuario        = $_SESSION['usuario']['nome'];
    $obCaixa->unidade        = $_SESSION['usuario']['unidade'];
    $obCaixa->descricao        = $_POST['descricao'];
    $obCaixa->tipo      = $_POST['tipo'];

    if ($_POST['tipo'] === 'saida'){
        $obCaixa->valor       = '-'.$_POST['valor'];
    } else {
        $obCaixa->valor       = $_POST['valor'];
    }

    if (empty($_POST['data'])){
        $obCaixa->data    = date('Y-m-d');
    } else {
        $obCaixa->data = $_POST['data'];
    }

    $obCaixa->atualizar();

    header('location: /caixa/cadastrar.php?status=success');
    exit;
}

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Caixa - Registro: <?php echo $obCaixa->descricao  ?></h1>
                </div>

            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-secondary">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Insira as informações</h3>
                        </div>
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nome">Motivo da Movimentação</label>
                                            <input  type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição da Movimentação" value="<?php echo $obCaixa->descricao  ?>"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="idade">Tipo</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="" <?=$obCaixa->tipo == '' ? 'selected' : ''?>>Selecione</option>
                                                <option value="entrada" <?=$obCaixa->tipo == 'Entrada' ? 'selected' : ''?>>Entrada</option>
                                                <option value="saida" <?=$obCaixa->tipo == 'Saida' ? 'selected' : ''?>>Saida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor</label>
                                            <input type="number" class="form-control" step="0.010" min="0" id="valor" name="valor" value="<?php  echo $obCaixa->tipo == 'Saida' ?  substr($obCaixa->valor, '1','100') : $obCaixa->valor   ?>" placeholder="Valor da movimentção" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data (opcional)</label>
                                            <input  type="date" class="form-control" id="data" value="<?php echo $obCaixa->data  ?>"  name="data" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary">Editar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include __DIR__.'/../includes/footer.php';

?>


