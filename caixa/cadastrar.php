<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Caixa;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBTEM OS REGISTROS
$listaCaixa = Caixa::getCaixa('','id desc','10');

//OBJETO UNIDADE
$obCaixa = new Caixa;

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

    $obCaixa->cadastrar();

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
                    <h1 class="m-0">Cadastro do Caixa</h1>
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
                                            <input  type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição da Movimentação"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="idade">Tipo</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="entrada">Entrada</option>
                                                <option value="saida">Saida</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valor" name="valor" placeholder="Valor da movimentção" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data (opcional)</label>
                                            <input  type="date" class="form-control" id="data" name="data" >
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
                            <h3 class="card-title">Ultimos Registros</h3>
                        </div>
                        <?php

                        $resultados = '';
                        foreach ($listaCaixa as $lista){
                            if ($lista->tipo === 'Saida'){
                                $cor = 'red';
                            }else{
                                $cor = 'green';
                            }
                            $editar = '';
                            $excluir = '';
                            if (empty($lista->idvenda) && empty($lista->idservico)){
                                $editar = '<a href="/caixa/editar.php?id='.$lista->id.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>';
                                $excluir = '<a href="/caixa/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" id="excluirconfirm" type="button " class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>';
                            } elseif (!empty($lista->idvenda)){
                                $editar = '<a href="/vendas/editar.php?id='.$lista->idvenda.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>';
                                $excluir = '<a href="/caixa/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" id="excluirconfirm" type="button " class="btn btn-danger toastrDefaultSuccess"><i class="fas fa-trash"></i></button></a>';
                            } elseif (!empty($lista->idservico)){
                                $editar = '<a href="/servicos/editar.php?id='.$lista->idservico.'"><button type="button" class="btn btn-primary toastrDefaultSuccess"><i class="fas fa-pen"></i></button></a>';
                                $excluir = '<a href="/caixa/excluir.php?id='.$lista->id.'"><button onclick="return excluir()" id="excluirconfirm" type="button " class="btn btn-danger toastrDefaultSuccess " ><i class="fas fa-trash"></i></button></a>';
                            }
                            $resultados .= '<tr>
                                                <td>'.$lista->usuario.'</td>
                                                <td>'.$lista->descricao.'</td>
                                                <td>'.$lista->tipo.'</td>
                                                <td style="color: '.$cor.'">'.number_format($lista->valor,2,',', '.').'</td>
                                                <td>'.date('d/m/Y',strtotime($lista->data)).'</td>
                                                <td>
                                                 '.$editar.' '.$excluir.'
                                                <td>
                                            </tr>';
                        }
                        ?>
                        <div class="col-12" style="text-align: center">
                            <div class="" style="margin: 5px">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap"  >
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
                                    <div style="font-size: 20px">
                                        <?php if (empty($listaCaixa)){
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


