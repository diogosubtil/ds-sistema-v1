<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Estoque;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//BUSCA
$nome      = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
$tipo      = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_GET, 'descricao', FILTER_SANITIZE_STRING);
$datainicio = filter_input(INPUT_GET, 'datainicio', FILTER_SANITIZE_STRING);
$datafim = filter_input(INPUT_GET, 'datafim', FILTER_SANITIZE_STRING);


// CONDIÇÕES WHERE
$condicoes = [
    strlen($datainicio) ? 'data BETWEEN "' . $datainicio . '" AND "' . $datafim . '"' : 'data LIKE "%%"',
    strlen($nome) ? 'nome LIKE "%' . $nome . '%"' : 'nome LIKE "%%"',
    strlen($tipo) ? 'tipo LIKE "%' . $tipo . '%"' : 'tipo LIKE "%%"',
    strlen($descricao) ? 'descricao LIKE "%' . $descricao . '%"' : 'tipo LIKE "%%"',
    'unidade LIKE ' . $_SESSION['usuario']['unidade']
];
$where = implode(' AND ', $condicoes);

//BUSCA A QUANTIDADE PRODUTOS NO ESTOQUE
$qtdProdutosEstoque = Estoque::getQtdProdutosEstoque($where);
//BUSCA A VALOR TOTAL DO ESTOQUE
$qtdValorEstoque = Estoque::getQtdValorEstoque($where);
//BUSCA A QUANTIDADE DE ITENS NO ESTOQUE
$qtdItensEstoque = Estoque::getQtdItensEstoque($where);

//OBTEM OS REGISTROS
$listaEstoque = Estoque::getEstoque($where, 'id desc');

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-auto">
                <div class="col-sm-6 col-6">
                    <h1 class="m-0">Painel do Estoque</h1>
                </div>

            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $qtdProdutosEstoque ?></h3>
                            <p>Produtos em Estoque</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php if (empty($qtdItensEstoque)){
                                    echo "0";
                                } else {
                                    echo $qtdItensEstoque;
                                } ?></h3>
                            <p>Itens em Estoque</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-12">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php if (empty($qtdValorEstoque)){
                                    echo "0";
                                } else {
                                    echo number_format($qtdValorEstoque,2,',', '.');
                                } ?></h3>
                            <p>Valor total do Estoque</p>
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
                                            <label for="nome">Nome do produto</label>
                                            <input  type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Produto" value="<?php echo $nome ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="idade">Categoria</label>
                                            <select  name="tipo" id="tipo" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="capa" <?=$tipo == 'capa' ? 'selected' : ''?>>Capa para Celular</option>
                                                <option value="fonedeouvido" <?=$tipo == 'fonedeouvido' ? 'selected' : ''?>>Fone de Ouvido</option>
                                                <option value="carregador" <?=$tipo == 'carregador' ? 'selected' : ''?>>Carregador</option>
                                                <option value="caixadesom" <?=$tipo == 'caixadesom' ? 'selected' : ''?>>Caixa de Som</option>
                                                <option value="celular" <?=$tipo == 'celular' ? 'selected' : ''?>>Celular</option>
                                                <option value="acessorios" <?=$tipo == 'acessorios' ? 'selected' : ''?>>Acessorios</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nome">Descrição</label>
                                            <input  type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Produto" value="<?php echo $descricao ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data Inicio</label>
                                            <input  type="date" class="form-control" id="datainicio" name="datainicio" value="<?= $datainicio?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
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
                            <h3 class="card-title">Lista de Produtos</h3>
                        </div>
                        <?php
                        $resultados = '';
                        foreach ($listaEstoque as $lista){
                            $tipo = '';
                            if($lista->tipo == 'capa'){
                                $tipo = 'Capa para Celular';
                            } elseif ($lista->tipo == 'fonedeouvido') {
                                $tipo = 'Fone de Ouvido';
                            } elseif ($lista->tipo == 'carregador'){
                                $tipo = 'Carregador';
                            } elseif ($lista->tipo == 'caixadesom'){
                                $tipo = 'Caixa de Som';
                            } elseif ($lista->tipo == 'celular'){
                                $tipo = 'Celular';
                            } elseif ($lista->tipo == 'acessorios'){
                                $tipo = 'Acessórios';
                            }

                            $resultados .= '<tr>
                                                <td>'.$lista->nome.'</td>
                                                <td>'.$tipo.'</td>
                                                <td>'.$lista->descricao.'</td>                                         
                                                <td>'.number_format($lista->valor,2,',', '.').'</td>
                                                <td>'.number_format($lista->valorvenda,2,',', '.').'</td>
                                                <td>'.$lista->quantidade.'</td> 
                                                <td>
                                                <a href="/estoque/editar.php?id='.$lista->id.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>
                                                <a href="/estoque/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" type="button" class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>                                             
                                                </td> 
                                                </tr>';
                        }
                        ?>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Descrição</th>
                                    <th>Custo</th>
                                    <th>Venda</th>
                                    <th>Quantidade</th>
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
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    //DESABILITA IMPUT DEPENDENDO DA SELEÇÃO

    $('#datainicio').on("change", function() {
        $("#datafim").attr('required', '') ;
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
