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

//OBJETO UNIDADE CAIXA
$obCaixa = new Caixa;

//OBJETO UNIDADE VENDA
$obVenda = new Venda;

//VALIDAÇÃO DO POST
if (isset($_POST['nomecliente'], $_POST['tipo'], $_POST['idproduto'], $_POST['quantidade'], $_POST['valorproduto'], $_POST['valortotal'])) {

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
    $obVenda->cadastrar();

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

    $obCaixa->cadastrar();

    $obEstoque = Estoque::getProduto($_POST['idproduto']);
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
                    <h1 class="m-0">Cadastro de Vendas</h1>
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
                                            <input  type="text" class="form-control" id="nomecliente" name="nomecliente" placeholder="Nome do Cliente"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idade">Forma de Pagamento</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="D">Dinheiro</option>
                                                <option value="CD">Cartão de Debito</option>
                                                <option value="CC">Cartão de Crédito</option>
                                                <option value="Pix">Pix</option>
                                                <option value="TB">Transferências Bancaria</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data (opcional)</label>
                                            <input  type="date" class="form-control" id="data" name="data" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="idade">Produto</label>
                                            <select  name="idproduto" id="idproduto" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <?php
                                                $valorProduto = '';
                                                foreach ($listaEstoque as $lista){  ?>
                                                    <option value="<?php echo $lista->id ?>"><?php echo $lista->id.' - '.$lista->nome.' ('.$lista->descricao.')'?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor do Produto</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valorproduto" name="valorproduto" placeholder="Valor do Produto" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Quantidade</label>
                                            <input  type="number" class="form-control"  min="0" id="quantidade" name="quantidade" placeholder="Quantidade de produtos" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor Total</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valortotal" name="valortotal" placeholder="Valor total da venda" required>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
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
                            <h3 class="card-title">Ultimas Vendas</h3>
                        </div>
                        <?php
                        $FormPag = '';
                        $resultados = '';
                        foreach ($listaVenda as $lista){
                            if ($lista->tipo == 'D'){
                                $FormPag = 'Dinheiro';
                            } elseif ($lista->tipo == 'CD') {
                                $FormPag = 'Cartão de Debito';
                            } elseif ($lista->tipo == 'CC') {
                                $FormPag = 'Cartão de Crédito';
                            } elseif ($lista->tipo == 'Pix') {
                                $FormPag = 'Pix';
                            } elseif ($lista->tipo == 'TB') {
                                $FormPag = 'Tranferência Bancaria';
                            }
                            $resultados .= '
                                        <tr>
                                                <td>'.$lista->nomecliente.'</td>
                                                <td>'.$lista->nomevendedor.'</td>
                                                <td>'.Estoque::getNomedoProduto($lista->idproduto).'</td>
                                                <td>'.$lista->quantidade.'</td>          
                                                <td>'.$FormPag.'</td>                                  
                                                <td>'.number_format($lista->valorproduto,2,',', '.').'</td>
                                                <td style="color: green">'.number_format($lista->valortotal,2,',', '.').'</td>                                               
                                                <td>'.date('d/m/Y',strtotime($lista->data)).'</td>
                                                <td>
                                                <a href="/vendas/editar.php?id='.$lista->id.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>
                                                <a href="/vendas/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" type="button" class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>
                                                </td>
                                        </tr>';
                        }?>
                        <div class="col-12" style="text-align: center">
                            <div class="" style="margin: 5px">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Nome do Cliente</th>
                                            <th>Vendedor</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Forma de Pagamento</th>
                                            <th>Valor do Produto</th>
                                            <th>Valor total da Venda</th>
                                            <th>Data</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?=$resultados?>
                                        </tbody>
                                    </table>
                                    <div style="font-size: 20px">
                                    <?php if (empty($listaVenda)){
                                        echo 'Nenhum registro encontrado!';
                                    } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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

