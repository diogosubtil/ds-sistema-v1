<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Estoque;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBTEM OS REGISTROS
$listaEstoque = Estoque::getEstoque('','id desc','10');

//OBJETO UNIDADE
$obEstoque = Estoque::getProduto($_GET['id']);

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
    $obEstoque->atualizar();

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
                    <h1 class="m-0">Editar Estoque - Produto: <?php echo $obEstoque->nome ?></h1>
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
                                            <input  type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Produto" value="<?php echo $obEstoque->nome ?>"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="idade">Categoria</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="" <?=$obEstoque->tipo == '' ? 'selected' : ''?>>Selecione</option>
                                                <option value="capa" <?=$obEstoque->tipo == 'capa' ? 'selected' : ''?>>Capa para Celular</option>
                                                <option value="fonedeouvido" <?=$obEstoque->tipo == 'fonedeouvido' ? 'selected' : ''?>>Fone</option>
                                                <option value="carregador" <?=$obEstoque->tipo == 'carregador' ? 'selected' : ''?>>Carregador</option>
                                                <option value="caixadesom" <?=$obEstoque->tipo == 'caixadesom' ? 'selected' : ''?>>Caixa de Som</option>
                                                <option value="celular" <?=$obEstoque->tipo == 'celular' ? 'selected' : ''?>>Celular</option>
                                                <option value="acessorios" <?=$obEstoque->tipo == 'acessorios' ? 'selected' : ''?>>Acessorios</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nome">Descrição</label>
                                            <input  type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Produto"  value="<?php echo $obEstoque->descricao ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Quantidade</label>
                                            <input  type="number" class="form-control" min="0" id="quantidade" name="quantidade" placeholder="Valor da movimentção" value="<?php echo $obEstoque->quantidade ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor de Custo</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valor" name="valor" placeholder="Valor de custo do produto" value="<?php echo $obEstoque->valor ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dataNascimento">Valor de Venda</label>
                                            <input  type="number" class="form-control" step="0.010" min="0" id="valorvenda" name="valorvenda" placeholder="Valor de venda do produto" value="<?php echo $obEstoque->valorvenda ?>" required>
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


