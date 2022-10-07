<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Notificacoes;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

$obNotificacao = new Notificacoes;

//VALIDAÇÃO DO POST
if (isset($_POST['title'], $_POST['tipo'], $_POST['descricao'])) {

    $obNotificacao->title        = $_POST['title'];
    $obNotificacao->idusuario        = $_SESSION['usuario']['id'];
    $obNotificacao->tipo        = $_POST['tipo'];
    $obNotificacao->unidade        = $_SESSION['usuario']['unidade'];
    $obNotificacao->descricao      = $_POST['descricao'];
    $obNotificacao->lido      = 'n';


    if (empty($_POST['data'])){
        $obNotificacao->data    = date('Y-m-d');
    } else {
        $obNotificacao->data = $_POST['data'];
    }

    $obNotificacao->cadastrar();

    header('location: /master/painelmaster.php?status=success');
    exit;
}


//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

include __DIR__.'/../includes/header.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Painel Master</h1>
                </div>

            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Criar Notificação</h3>
                        </div>
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nome">Titulo</label>
                                            <input  type="text" class="form-control" id="title" name="title" placeholder="Titulo da Notificação" value=""  required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="idade">Tipo</label>
                                            <select  name="tipo" id="tipo" class="form-control" required>
                                                <option value="" >Selecione</option>
                                                <option value="att" >Atualização</option>
                                                <option value="noti" >Notificação</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dataNascimento">Data (opcional)</label>
                                            <input  type="date" class="form-control" id="data" value=""  name="data" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descricao">Descrição</label>
                                            <textarea type="text" class="form-control" id="descricao" name="descricao" rows="10" required> </textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary">Enviar</button>
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
