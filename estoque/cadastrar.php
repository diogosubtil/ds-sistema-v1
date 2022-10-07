<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Estoque;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBTEM OS REGISTROS
$listaEstoque = Estoque::getEstoque('','id desc','10');

//OBJETO UNIDADE
$obEstoque = new Estoque;

//VALIDAÇÃO DO POST
if (isset($_POST['nome'], $_POST['tipo'], $_POST['valor'], $_POST['valorvenda'], $_POST['quantidade'])) {

    $obEstoque->nome        = $_POST['nome'];
    $obEstoque->tipo        = $_POST['tipo'];
    $obEstoque->descricao        = $_POST['descricao'];
    $obEstoque->valor      = $_POST['valor'];
    $obEstoque->valorvenda      = $_POST['valorvenda'];
    $obEstoque->quantidade      = $_POST['quantidade'];
    $obEstoque->unidade      = $_SESSION['usuario']['unidade'];
    $obEstoque->totalvalor      = $_POST['quantidade']*$_POST['valorvenda'];
    $obEstoque->cadastrar();

    header('location: /estoque/cadastrar.php?status=success');
    exit;
}

include __DIR__.'/../includes/header.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cadastro do Estoque</h1>
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
                                            <label for="nome">Nome do produto</label>
                                            <input  type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Produto"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idade">Categoria</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="capa">Capa para Celular</option>
                                                <option value="fonedeouvido">Fone de Ouvido</option>
                                                <option value="carregador">Carregador</option>
                                                <option value="caixadesom">Caixa de Som</option>
                                                <option value="celular">Celular</option>
                                                <option value="acessorios">Acessorios</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nome">Descrição</label>
                                            <input  type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Produto"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Quantidade</label>
                                            <input  type="number" class="form-control" min="0" id="quantidade" name="quantidade" placeholder="Valor da movimentção" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor de Custo</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valor" name="valor" placeholder="Valor de custo do produto" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor de Venda</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valorvenda" name="valorvenda" placeholder="Valor de venda do produto" required>
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
                            <h3 class="card-title">Ultimos produtos adicionados</h3>
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
                        <div class="col-12" style="text-align: center">
                            <div class="" style="margin: 5px">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
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
                                    <div style="font-size: 20px">
                                        <?php if (empty($listaEstoque)){
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


