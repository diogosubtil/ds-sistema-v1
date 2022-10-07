<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Venda;
use \App\Entity\Estoque;
use \App\Entity\Caixa;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBTEM LISTA DO ESTOQUE
$listaEstoque = Estoque::getEstoque();

//OBTEM OS REGISTROS
$listaVenda = Venda::getVendas('','id desc','10');


//OBJETO UNIDADE VENDA
$obVenda = Venda::getVenda($_GET['id']);

//OBJETO UNIDADE CAIXA
$obCaixa = Caixa::getVendaCaixa($obVenda->id);


//VALIDAÇÃO DO POST
if (isset($_POST['nomecliente'], $_POST['tipo'], $_POST['idproduto'], $_POST['quantidade'], $_POST['valorproduto'], $_POST['valortotal'])) {

    //ATUALIZA O ESTOQUE CASO OUVER TROCA DE PRODUTO
    if (!empty($obEstoque = Estoque::getProduto($obVenda->idproduto))){
    $obEstoque = Estoque::getProduto($obVenda->idproduto);
    $obEstoque->quantidade = $obEstoque->quantidade+$obVenda->quantidade;
    $obEstoque->totalvalor = $obEstoque->totalvalor+$obVenda->quantidade*$obVenda->valorproduto;
    $obEstoque->atualizar();
    }
    //ATUALIZA A VENDA
    $obVenda->nomevendedor        = $_SESSION['usuario']['nome'];
    $obVenda->nomecliente        = $_POST['nomecliente'];
    $obVenda->tipo      = $_POST['tipo'];
    $obVenda->idproduto      = $_POST['idproduto'];
    $obVenda->unidade        = $_SESSION['usuario']['unidade'];
    $obVenda->quantidade        = $_POST['quantidade'];
    $obVenda->valorproduto        = $_POST['valorproduto'];
    $obVenda->valortotal        = $_POST['valortotal'];
    if (empty($_POST['data'])){
        $obVenda->data    = date('Y-m-d');
    } else {
        $obVenda->data = $_POST['data'];
    }
    $obVenda->atualizar();

    //ATUALIZA O CAIXA
    $obCaixa->idvenda        = $obVenda->id;
    $obCaixa->usuario        = $_SESSION['usuario']['nome'];
    $obCaixa->unidade        = $_SESSION['usuario']['unidade'];
    $obCaixa->descricao      = 'Venda';
    $obCaixa->tipo           = 'entrada';
    $obCaixa->valor          = $_POST['valortotal'];
    if (empty($_POST['data'])){
        $obCaixa->data       = date('Y-m-d');
    } else {
        $obCaixa->data = $_POST['data'];
    }
    $obCaixa->atualizar();

    //ATUALIZA O ESTOQUE COM O NOVO PRODUTO
    $obEstoque = Estoque::getProduto($obVenda->idproduto);
    $obEstoque->quantidade = $obEstoque->quantidade-$_POST['quantidade'];
    $obEstoque->totalvalor = $obEstoque->totalvalor-$_POST['quantidade']*$_POST['valorproduto'];
    $obEstoque->atualizar();

    header('location: /vendas/cadastrar.php?status=success');
    exit;
}

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Venda - Cliente: <?php echo $obVenda->nomecliente ?></h1>
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
                                            <input  type="text" class="form-control" id="nomecliente" name="nomecliente" placeholder="Nome do Cliente" value="<?php echo $obVenda->nomecliente ?>"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idade">Forma de Pagamento</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="" <?=$obVenda->tipo == '' ? 'selected' : ''?>>Selecione</option>
                                                <option value="D" <?=$obVenda->tipo == 'D' ? 'selected' : ''?>>Dinheiro</option>
                                                <option value="CD" <?=$obVenda->tipo == 'CD' ? 'selected' : ''?>>Cartão de Debito</option>
                                                <option value="CC" <?=$obVenda->tipo == 'CC' ? 'selected' : ''?>>Cartão de Crédito</option>
                                                <option value="Pix" <?=$obVenda->tipo == 'Pix' ? 'selected' : ''?>>Pix</option>
                                                <option value="TB" <?=$obVenda->tipo == 'TB' ? 'selected' : ''?>>Transferências Bancaria</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data (opcional)</label>
                                            <input  type="date" class="form-control" id="data" value="<?php echo $obVenda->data ?>" name="data" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="idade">Produto</label>
                                            <select  name="idproduto" id="idproduto" class="form-control">
                                                <option value=""></option>
                                                <?php
                                                $valorProduto = '';
                                                foreach ($listaEstoque as $lista){  ?>
                                                    <option value="<?php echo $lista->id ?>" <?=$obVenda->idproduto == $lista->id ? 'selected' : ''?>><?php echo $lista->id.' - '.$lista->nome.' ('.$lista->descricao.')'?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor do Produto</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valorproduto" name="valorproduto" placeholder="Valor do Produto" value="<?php echo $obVenda->valorproduto ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Quantidade</label>
                                            <input  type="number" class="form-control"  min="0" id="quantidade" name="quantidade" placeholder="Quantidade de produtos" value="<?php echo $obVenda->quantidade ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor Total</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valortotal" name="valortotal" value="<?php echo $obVenda->valortotal ?>" placeholder="Valor total da venda" required>
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
<script type='text/javascript'>
    $(document).ready(function(){
        $("select[name='idproduto']").change(function(){
            let $valor = $("input[name='valorproduto']");
            $.getJSON('buscavalorestoque.php',{
                idproduto: $( this ).val()
            },function( json ){
                $valor.val( json.valorproduto );
            });
        });
    });
</script>
<script>
    let idproduto = window.document.getElementById('idproduto')
    idproduto.addEventListener('blur',  function (e){
        e.preventDefault();
        const quantidade = window.document.getElementById('quantidade');
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

