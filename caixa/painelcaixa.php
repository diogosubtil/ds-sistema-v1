<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Caixa;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//BUSCA
$descricao      = filter_input(INPUT_GET, 'descricao', FILTER_SANITIZE_STRING);
$tipo      = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);
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
    strlen($descricao) ? 'descricao LIKE "%' . $descricao . '%"' : 'descricao LIKE "%%"',
    strlen($datainicio) ? 'data BETWEEN "' . $datainicio . '" AND "' . $datafim . '"' : 'data LIKE "%'.$mesAtual.'%"',
    strlen($tipo) ? 'tipo LIKE "%' . $tipo . '%"' : 'tipo LIKE "%%"',
    'unidade LIKE ' . $_SESSION['usuario']['unidade']
];
$where = implode(' AND ', $condicoes);

//BUSCA A QUANTIDADE DE REGISTROS
$qtdRegistros = Caixa::getQtdRegistros($where);
//BUSCA A QUANTIDADE DE ENTRADAS
$qtdEntrada = Caixa::getQtdValor($where.' and tipo = "Entrada"');
//BUSCA A QUANTIDADE DE SAIDAS
$qtdSaida = Caixa::getQtdValor($where.' and tipo = "Saida"');
//BUSCA A QUANTIDADE TOTAL EM CAIXA
$qtdTotalCaixa = Caixa::getQtdValor($where);

//OBTEM OS REGISTROS
$listaCaixa = Caixa::getCaixa($where, 'id desc');

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-auto">
                <div class="col-sm-6 col-6">
                    <h1 class="m-0">Painel do Caixa</h1>
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
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $qtdRegistros ?></h3>
                            <p>Registros</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php if (empty($qtdTotalCaixa)){
                                echo "0";
                                } else {
                                echo number_format($qtdTotalCaixa,2,',', '.');
                                } ?></h3>
                            <p>Balanço do Caixa</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php if (empty($qtdEntrada)){
                                    echo "0";
                                } else {
                                    echo number_format($qtdEntrada,2,',', '.');
                                } ?></h3>
                            <p>Entradas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="#" class="small-box-footer">

                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php if (empty($qtdSaida)){
                                    echo "0";
                                } else {
                                    echo number_format($qtdSaida,2,',', '.');
                                } ?></h3>
                            <p>Saidas</p>
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="idade">Descrição</label>
                                            <input  type="text" class="form-control" id="descricao" name="descricao" value="<?= $descricao?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="idade">Tipo</label>
                                            <select  name="tipo" id="tipo" class="form-control" >
                                                <option value="">Selecione</option>
                                                <option value="entrada"<?=$tipo == 'entrada' ? 'selected' : ''?>>Entrada</option>
                                                <option value="saida"<?=$tipo == 'saida' ? 'selected' : ''?>>Saida</option>
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
                        $cofirme = 'Deseja realmente excluir?';
                        $resultados = '';
                        foreach ($listaCaixa as $lista){
                            if ($lista->tipo === 'Saida'){
                                $cor = 'red';
                            }else{
                                $cor = 'green';
                            }
                            $editar = '';
                            $excluir = '';
                            $confirma = 'tem certeza disso?';
                            if (empty($lista->idvenda) && empty($lista->idservico)){
                                $editar = '<a href="/caixa/editar.php?id='.$lista->id.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>';
                                $excluir = '<a  href="/caixa/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" id="excluirconfirm" type="button " class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>';
                            } elseif (!empty($lista->idvenda)){
                                $editar = '<a href="/vendas/editar.php?id='.$lista->idvenda.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>';
                                $excluir = '<a  href="/caixa/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" id="excluirconfirm" type="button " class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>';
                            } elseif (!empty($lista->idservico)){
                                $editar = '<a href="/servicos/editar.php?id='.$lista->idservico.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>';
                                $excluir = '<a  href="/caixa/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" id="excluirconfirm" type="button " class="btn btn-danger toastrDefaultSuccess" ><i class="fas fa-trash"></i></button></a>';
                            }
                            $resultados .= '<tr>
                                                <td>'.$lista->usuario.'</td>
                                                <td>'.$lista->descricao.'</td>
                                                <td>'.$lista->tipo.'</td>
                                                <td style="color: '.$cor.'">'.number_format($lista->valor,2,',', '.').'</td>
                                                <td>'.date('d/m/Y',strtotime($lista->data)).'</td>
                                                <td>
                                                '.$editar.' '.$excluir.'
                                                </td>
                                            </tr>';
                        }
                        ?>
                        <!-- /.card-header -->
                        <div class="card-body" >
                            <table id="example1" class="table table-bordered table-striped" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>Vendedor</th>
                                    <th>Descrição</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
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
