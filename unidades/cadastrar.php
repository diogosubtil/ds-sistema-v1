<?php
require __DIR__ . '/../vendor/autoload.php';

use \App\Login\Login;
use \App\Entity\Unidade;
use \App\Entity\Usuario;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//OBJETO UNIDADE
$obUnidade = new Unidade;

//OBJETO USUÁRIO
$usuarios = Usuario::getUsuarios('funcao = "2"');

//VALIDAÇÃO DO POST
if (isset($_POST['cep'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['dataAbertura'], $_POST['meta'], $_POST['gerente'], $_POST['endereco'])) {

    $obUnidade->cep          = $_POST['cep'];
    $obUnidade->bairro       = $_POST['bairro'];
    $obUnidade->cidade       = $_POST['cidade'];
    $obUnidade->estado       = $_POST['estado'];
    $obUnidade->dataAbertura = $_POST['dataAbertura'];
    $obUnidade->meta         = $_POST['meta'];
    $obUnidade->gerente      = $_POST['gerente'];
    $obUnidade->whatsapp     = $_POST['whatsapp'];
    $obUnidade->endereco     = $_POST['endereco'];
    $obUnidade->numero       = $_POST['numero'];
    $obUnidade->timezone     = $_POST['timezone'];

    $obUnidade->cadastrar();

    header('location: /unidades/listar.php?status=success');
    exit;
}

//TIMEZONES BRASIL
$timezones = array(
    'AC' => 'America/Rio_branco',   'AL' => 'America/Maceio',
    'AP' => 'America/Belem',        'AM' => 'America/Manaus',
    'BA' => 'America/Bahia',        'CE' => 'America/Fortaleza',
    'DF' => 'America/Sao_Paulo',    'ES' => 'America/Sao_Paulo',
    'GO' => 'America/Sao_Paulo',    'MA' => 'America/Fortaleza',
    'MT' => 'America/Cuiaba',       'MS' => 'America/Campo_Grande',
    'MG' => 'America/Sao_Paulo',    'PR' => 'America/Sao_Paulo',
    'PB' => 'America/Fortaleza',    'PA' => 'America/Belem',
    'PE' => 'America/Recife',       'PI' => 'America/Fortaleza',
    'RJ' => 'America/Sao_Paulo',    'RN' => 'America/Fortaleza',
    'RS' => 'America/Sao_Paulo',    'RO' => 'America/Porto_Velho',
    'RR' => 'America/Boa_Vista',    'SC' => 'America/Sao_Paulo',
    'SE' => 'America/Maceio',       'SP' => 'America/Sao_Paulo',
    'TO' => 'America/Araguaia',
);

//INCLUI O CABEÇALHO
include __DIR__ . '/../includes/header.php';

?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cadastrar Loja</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="card card-secondary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Insira as informações</h3>
                        </div>

                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="cep">CEP</label>
                                            <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="dataAbertura">Data de Abertura</label>
                                            <input type="date" class="form-control" id="dataAbertura" name="dataAbertura" placeholder="Data de Abertura">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="whatsapp">Whatsapp</label>
                                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Whatsapp">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="meta">Meta</label>
                                            <input type="number" class="form-control" id="meta" name="meta" placeholder="Meta">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="gerente">Gerente</label>
                                            <select name="gerente" id="gerente" class="form-control">
                                                <option value="">Selecione um gerente...</option>
                                                <?php foreach ($usuarios as $usuario) { ?>
                                                    <option value="<?php echo $usuario->id ?>"><?php echo $usuario->nome ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="bairro">Bairro</label>
                                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
                                        </div>

                                    </div>

                                    <div class="col-md-1">

                                        <div class="form-group">
                                            <label for="cidade">Cidade</label>
                                            <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade">
                                        </div>

                                    </div>

                                    <div class="col-md-1">

                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado">
                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="endereco">Endereço</label>
                                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="numero">Número</label>
                                            <input type="text" class="form-control" id="numero" name="numero" placeholder="Número">
                                        </div>

                                    </div>

                                    <div class="col-md-2">

                                        <div class="form-group">
                                            <label for="timezone">Timezone</label>
                                            <select name="timezone" id="timezone" class="form-control">
                                                <option value="">Selecione...</option>
                                                <?php foreach ($timezones as $timezone) { ?>
                                                    <option value="<?php echo $timezone ?>"><?php echo $timezone ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn bg-primary">Cadastrar</button>
                                <a href="/unidades/listar.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<?php

//INCLUI O FOOTER
include __DIR__ . '/../includes/footer.php';
