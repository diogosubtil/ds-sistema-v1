<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Servicos;
use \App\Entity\Caixa;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBTEM OS REGISTROS
$listaServicos = Servicos::getServicos('','id desc','10');

//OBJETO UNIDADE VENDA
$obServicos = Servicos::getServicoID($_GET['id']);

//OBJETO UNIDADE CAIXA
$obCaixa = Caixa::getServicoCaixa($_GET['id']);

//VALIDAÇÃO DO POST
if (isset($_POST['nomecliente'], $_POST['pagamento'], $_POST['servico'], $_POST['custo'], $_POST['valor'])) {

    $obServicos->nomevendedor        = $_SESSION['usuario']['nome'];
    $obServicos->nomecliente        = $_POST['nomecliente'];
    $obServicos->pagamento      = $_POST['pagamento'];
    $obServicos->servico        = $_POST['servico'];
    $obServicos->custo        = $_POST['custo'];
    $obServicos->valor        = $_POST['valor'];
    $obServicos->unidade        = $_SESSION['usuario']['unidade'];
    if (empty($_POST['data'])){
        $obServicos->data    = date('Y-m-d');
    } else {
        $obServicos->data = $_POST['data'];
    }
    $obServicos->atualizar();

    $obCaixa->idservico        = $obServicos->id;
    $obCaixa->usuario        = $_SESSION['usuario']['nome'];
    $obCaixa->unidade        = $_SESSION['usuario']['unidade'];
    $obCaixa->descricao        = 'Serviço';
    $obCaixa->tipo      = 'entrada';
    $obCaixa->valor       = $_POST['valor'];
    if (empty($_POST['data'])){
        $obCaixa->data    = date('Y-m-d');
    } else {
        $obCaixa->data = $_POST['data'];
    }
    $obCaixa->atualizar();

    header('location: /servicos/cadastrar.php?status=success');
    exit;
}

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Serviço - Cliente: <?php echo $obServicos->nomecliente ?></h1>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nome">Nome do Cliente</label>
                                            <input  type="text" class="form-control" id="nomecliente" name="nomecliente" placeholder="Nome do Cliente"  value="<?php echo $obServicos->nomecliente ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idade">Forma de Pagamento</label>
                                            <select  name="pagamento" id="pagamento" class="form-control" required>
                                                <option value="" <?=$obServicos->pagamento == '' ? 'selected' : ''?>>Selecione</option>
                                                <option value="D" <?=$obServicos->pagamento == 'D' ? 'selected' : ''?>>Dinheiro</option>
                                                <option value="CD" <?=$obServicos->pagamento == 'CD' ? 'selected' : ''?>>Cartão de Debito</option>
                                                <option value="CC" <?=$obServicos->pagamento == 'CC' ? 'selected' : ''?>>Cartão de Crédito</option>
                                                <option value="Pix" <?=$obServicos->pagamento == 'Pix' ? 'selected' : ''?>>Pix</option>
                                                <option value="TB" <?=$obServicos->pagamento == 'TB' ? 'selected' : ''?>>Transferências Bancaria</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Serviço</label>
                                            <input  type="text" class="form-control" id="servico" name="servico" placeholder="Serviço realizado" value="<?php echo $obServicos->servico ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Custo do Serviço</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="custo" name="custo" placeholder="Valor dos custos" value="<?php echo $obServicos->custo ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor Total do Serviço</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valor" name="valor" placeholder="Valor total do serviço" value="<?php echo $obServicos->valor ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data (opcional)</label>
                                            <input  type="date" class="form-control" id="data" value="<?php echo $obServicos->data ?>" name="data" >
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
<script>
    let idproduto = window.document.getElementById('idproduto')
    idproduto.addEventListener('change',  function (e){
        e.preventDefault();
        const quantidade = window.document.getElementById('quantidade');
        quantidade.value = 1;
        const valuequantidade = quantidade.value;
        const valor = window.document.getElementById('valorproduto');
        const valuevalor = valor.value;
        const somar = valuequantidade*valuevalor;
        const valortotal = window.document.getElementById('valortotal');
        valortotal.value = somar;
    })
    let quantidade = window.document.getElementById('quantidade')
    quantidade.addEventListener('blur',  function (e){
        e.preventDefault();
        const quantidade = window.document.getElementById('quantidade');
        const valuequantidade = quantidade.value;
        const valor = window.document.getElementById('valorproduto');
        const valuevalor = valor.value;
        const somar = valuequantidade*valuevalor;
        const valortotal = window.document.getElementById('valortotal');
        valortotal.value = somar;
    })
    let valorproduto = window.document.getElementById('valorproduto')
    valorproduto.addEventListener('blur',  function (e){
        e.preventDefault();
        const quantidade = window.document.getElementById('quantidade');
        const valuequantidade = quantidade.value;
        const valor = window.document.getElementById('valorproduto');
        const valuevalor = valor.value;
        const somar = valuequantidade*valuevalor;
        const valortotal = window.document.getElementById('valortotal');
        valortotal.value = somar;
    })
</script>

