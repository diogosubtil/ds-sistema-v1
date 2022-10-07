<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Venda;
use \App\Entity\Servicos;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//BUSCA
$nomecliente      = filter_input(INPUT_GET, 'nomecliente', FILTER_SANITIZE_STRING);
$pagamento      = filter_input(INPUT_GET, 'pagamento', FILTER_SANITIZE_STRING);
$mes      = filter_input(INPUT_GET, 'mes', FILTER_SANITIZE_STRING);
$datainicio = filter_input(INPUT_GET, 'datainicio', FILTER_SANITIZE_STRING);
$datafim = filter_input(INPUT_GET, 'datafim', FILTER_SANITIZE_STRING);

//OBTEM O MES ATUAL
if (empty($mes)){
    $mesAtual = '-'.date('m').'-';
} else {
    $mesAtual = $mes;
}

// CONDIÇÕES WHERE
$condicoes = [
    strlen($nomecliente) ? 'nomecliente LIKE "%' . $nomecliente . '%"' : 'nomecliente LIKE "%%"',
    strlen($pagamento) ? 'pagamento LIKE "%' . $pagamento . '%"' : 'pagamento LIKE "%%"',
    strlen($datainicio) ? 'data BETWEEN "' . $datainicio . '" AND "' . $datafim . '"' : 'data LIKE "%'.$mesAtual.'%"',
    'unidade LIKE ' . $_SESSION['usuario']['unidade']
];
$where = implode(' AND ', $condicoes);

//BUSCA A QUANTIDADE DE SERVICOS
$qtdServicos = Servicos::getQtdServicos($where);
//BUSCA O TOTAL DE VALOR DOS SERVICOS
$ValorTotalServicos = Servicos::getQtdValorServicos($where);
//BUSCA O TOTAL DE CUSTOS DOS SERVICOS
$ValorTotalCustos = Servicos::getQtdValorCustos($where);

//OBTEM OS REGISTROS
$listaServicos = Servicos::getServicos($where, 'id desc');

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-auto">
                <div class="col-sm-6 col-6">
                    <h1 class="m-0">Painel de Serviços</h1>
                </div>
                <div class="col-sm-1 col-6">
                    <h1 class="m-0">Mês :</h1>
                </div>
                <div class="col-sm-2 col-9">
                    <form method="get">
                        <div class="">
                            <div class="form-group">
                                <select  name="mes" id="mes" class="form-control" >
                                    <option value="">Mês atual</option>
                                    <option value="-01-"<?=$mesAtual == '-01-' ? 'selected' : ''?>>Janeiro</option>
                                    <option value="-02-"<?=$mesAtual == '-02-' ? 'selected' : ''?>>Fevereiro</option>
                                    <option value="-03-"<?=$mesAtual == '-03-' ? 'selected' : ''?>>Março</option>
                                    <option value="-04-"<?=$mesAtual == '-04-' ? 'selected' : ''?>>Abril</option>
                                    <option value="-05-"<?=$mesAtual == '-05-' ? 'selected' : ''?>>Maio</option>
                                    <option value="-06-"<?=$mesAtual == '-06-' ? 'selected' : ''?>>Junho</option>
                                    <option value="-07-"<?=$mesAtual == '-07-' ? 'selected' : ''?>>Julho</option>
                                    <option value="-08-"<?=$mesAtual == '-08-' ? 'selected' : ''?>>Agosto</option>
                                    <option value="-09-"<?=$mesAtual == '-09-' ? 'selected' : ''?>>Setembro</option>
                                    <option value="-10-"<?=$mesAtual == '-10-' ? 'selected' : ''?>>Outubro</option>
                                    <option value="-11-"<?=$mesAtual == '-11-' ? 'selected' : ''?>>Novembro</option>
                                    <option value="-12-"<?=$mesAtual == '-12-' ? 'selected' : ''?>>Dezembro</option>
                                    <option value="-"<?=$mesAtual == '-' ? 'selected' : ''?>>Todos</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="col-sm-1 col-3">
                    <button type="submit" class="btn bg-primary">Filtrar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php if (empty($qtdServicos)){
                                    echo "0";
                                } else {
                                    echo $qtdServicos;
                                } ?></h3>
                            <p>Serviços</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-screwdriver"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php if (empty($ValorTotalCustos)){
                                    echo "0";
                                } else {
                                    echo number_format($ValorTotalCustos,2,',', '.');
                                } ?></h3>
                            <p>Total de Custos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-12">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php if (empty($ValorTotalServicos)){
                                    echo "0";
                                } else {
                                    echo number_format($ValorTotalServicos,2,',', '.');
                                } ?></h3>
                            <p>Valor Total de Serviços</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="#" class="small-box-footer">

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-secondary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Pesquise</h3>
                        </div>
                        <form action="" method="GET">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nome">Nome do Cliente</label>
                                            <input  type="text" class="form-control" id="nomecliente" name="nomecliente" placeholder="Nome do Cliente" value="<?= $nomecliente?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="idade">Forma de Pagamento</label>
                                            <select  name="pagamento" id="pagamento" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="D" <?=$pagamento == 'D' ? 'selected' : ''?>>Dinheiro</option>
                                                <option value="CD" <?=$pagamento == 'CD' ? 'selected' : ''?>>Cartão de Debito</option>
                                                <option value="CC" <?=$pagamento == 'CC' ? 'selected' : ''?>>Cartão de Crédito</option>
                                                <option value="Pix" <?=$pagamento == 'Pix' ? 'selected' : ''?>>Pix</option>
                                                <option value="TB" <?=$pagamento == 'TB' ? 'selected' : ''?>>Transferências Bancaria</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data Inicio</label>
                                            <input  type="date" class="form-control" id="datainicio" name="datainicio" value="<?= $datainicio?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data Fim</label>
                                            <input  type="date" class="form-control" id="datafim" name="datafim" value="<?= $datafim?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary">Pesquisar</button>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Registros</h3>
                        </div>
                        <?php
                        $FormPag = '';
                        $resultados = '';
                        foreach ($listaServicos as $lista){
                            if ($lista->pagamento == 'D'){
                                $FormPag = 'Dinheiro';
                            } elseif ($lista->pagamento == 'CD') {
                                $FormPag = 'Cartão de Debito';
                            } elseif ($lista->pagamento == 'CC') {
                                $FormPag = 'Cartão de Crédito';
                            } elseif ($lista->pagamento == 'Pix') {
                                $FormPag = 'Pix';
                            } elseif ($lista->pagamento == 'TB') {
                                $FormPag = 'Tranferência Bancaria';
                            }
                            $resultados .= '<tr>
                                                <td>'.$lista->nomecliente.'</td>
                                                <td>'.$lista->nomevendedor.'</td>
                                                <td>'.$lista->servico.'</td>          
                                                <td>'.$FormPag.'</td>                                  
                                                <td>'.number_format($lista->custo,2,',', '.').'</td>
                                                <td>'.number_format($lista->valor,2,',', '.').'</td>                                               
                                                <td>'.date('d/m/Y',strtotime($lista->data)).'</td>
                                                <td>
                                                 <a href="/servicos/editar.php?id='.$lista->id.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>
                                                 <a href="/servicos/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" type="button" class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>                                             
                                                </td>
                                            </tr>';
                        }?>
                        <!-- /.card-header -->
                        <div class="card-body ">
                            <table id="example1" class="table table-bordered table-striped" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>Nome do Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Serviço</th>
                                    <th>Forma de Pagamento</th>
                                    <th>Custo do Serviço</th>
                                    <th>Valor do Serviço</th>
                                    <th>Data</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?=$resultados?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<?php
include __DIR__.'/../includes/footer.php';

?>
<!-- DataTables  & Plugins -->
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/assets/plugins/jszip/jszip.min.js"></script>
<script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,"ordering": false,
            "buttons": ["excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    //DESABILITA INPUT DEPENDENDO DA SELEÇÃO

    $('#datainicio').on("change", function() {
        $("#datafim").attr('required', '') ;
        $("#mes").attr('disabled', '') ;

    });

    $('#datafim').on("change", function() {
        $("#datainicio").attr('required', '') ;
        $("#mes").attr('disabled', '') ;

    });

    $('#mes').on("change", function() {
        $("#datainicio").attr('disabled', '') ;
        $("#datafim").attr('disabled', '') ;

    });
</script>
<style>
    #example1_filter{
        float: right;
    }
    #example1_paginate {
        float: right;
    }
</style>
