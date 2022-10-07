<?php


use App\Login\Login;
use App\Entity\Usuario;
use App\Entity\Unidade;
use App\Entity\Notificacoes;

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

function nomefuncao(){
    if ($_SESSION['usuario']['funcao'] == '1'){
        echo 'Função: Master';
    } elseif ($_SESSION['usuario']['funcao'] == '2'){
        echo 'Função: Gerente';
    } elseif ($_SESSION['usuario']['funcao'] == '4'){
        echo 'Função: Recepção/Vendedor';
    }
}

// FUNCAO PARA PEGAR A PÁGINA CORRENTE
function active($currect_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    if ($currect_page == $url_array[1]) {
        echo 'menu-is-opening menu-open active';
    }
}

// FUNCAO PARA PEGAR A PÁGINA CORRENTE
function activemenu($currect_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    if ($currect_page == $url_array[1].'/'.$url_array[2]) {
        echo 'active';
    }
}

function mesAtual(){
    $mes = filter_input(INPUT_GET, 'mes', FILTER_SANITIZE_STRING);
    if (empty($mes)){
        $mesAtual = '-'.date('m').'-';
    } else {
        $mesAtual = $mes;
    }
    if ($mesAtual == '-01-'){
        echo 'Janeiro';
    } elseif ($mesAtual == '-02-'){
        echo 'Fevereiro';
    } elseif ($mesAtual == '-03-'){
        echo 'Março';
    } elseif ($mesAtual == '-04-'){
        echo 'Abril';
    } elseif ($mesAtual == '-05-'){
        echo 'Maio';
    } elseif ($mesAtual == '-06-'){
        echo 'Junho';
    } elseif ($mesAtual == '-07-'){
        echo 'Julho';
    } elseif ($mesAtual == '-08-'){
        echo 'Agosto';
    } elseif ($mesAtual == '-09-'){
        echo 'Setembro';
    } elseif ($mesAtual == '-10-'){
        echo 'Outubro';
    } elseif ($mesAtual == '-11-'){
        echo 'Novembro';
    } elseif ($mesAtual == '-12-'){
        echo 'Dezembro';
    } elseif ($mesAtual == '-'){
        echo 'Todos';
    }
};



//LISTA DAS UNIDADES
$unidades = Unidade::getUnidades();

//SELEÇAO DE UNIDADE
if (isset($_POST['unidade'])) {
    $_SESSION['usuario']['unidade'] = $_POST['unidade'];
    header("Refresh:0");
    exit;
}

//ORGANIZA AS UNIDADES DO USUÁRIO
$unidadesUsuario = explode(',', $_SESSION['usuario']['unidade']);

if (is_array($unidadesUsuario)) {
    $_SESSION['usuario']['unidade'] = $unidadesUsuario[0];
} else {
    $_SESSION['usuario']['unidade'] = $unidadesUsuario;
}

$QTNotificacao = Notificacoes::getQtdNotificacoes('lido = "n"');

$obNotificacoes = Notificacoes::getNotificacoes('unidade = '.$_SESSION['usuario']['unidade'],'id desc','5')

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Gestão</title>
    <link rel="shortcut icon" type="imagex/png" href="/assets/img/icons/DSicone.ico">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/css/adminlte.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/assets/plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Alert Toastr -->
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">

    <!-- Ajustes -->
    <link rel="stylesheet" href="/assets/css/ajustes.css">

</head>

<div class="wrapper ">
    <!-- MENSAGENS DE STATUS -->
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success') { ?>
        <input type="hidden" id="success">
    <?php } ?>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'error') { ?>
        <input type="hidden" id="error">
    <?php } ?>
    <?php if (isset($_GET['status']) && $_GET['status'] === 'editado') { ?>
        <input type="hidden" id="editado">
    <?php } ?>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <body class="hold-transition sidebar-mini layout-fixed">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <?php if (Login::requireFuncao('1,2,4')) { ?>
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            <?php } ?>
            <?php if (isset($_SESSION['usuario']['id'])) { ?>
                <li class="nav-item">
                    <form action="" method="POST">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-8">
                                <select name="unidade" class="form-control" required>
                                    <option selected disabled>Selecionar...</option>
                                    <?php
                                    $usuario = Usuario::getUsuario($_SESSION['usuario']['id']);
                                    $obUnidades = $usuario->unidade;
                                    $unidadesUsuario = explode(',', $obUnidades);
                                    foreach ($unidadesUsuario as $unidadeUsuario) { ?>
                                        <option value="<?php echo $unidadeUsuario ?>"><?php echo Unidade::getTitleUnidade($unidadeUsuario); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                            </div>
                            <div class="col-md-6 col-12 ">
                                Loja: <strong><?php echo Unidade::getTitleUnidade($_SESSION['usuario']['unidade']) ?></strong>
                            </div>
                        </div>
                    </form>
                </li>

            <?php } ?>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge" style="font-size: 12px"><?php
                        if (!empty($QTNotificacao)){
                            echo $QTNotificacao;
                        }
                        ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 350px ;max-width: 450px">
                    <span class="dropdown-item dropdown-header"><i class="fas fa-envelope mr-2"></i><?php echo $QTNotificacao ?> Notificações</span>
                    <div class="dropdown-divider"></div>
                    <?php foreach ($obNotificacoes as $obNotificacao) {?>

                    <div class="col-md-12 col-12">
                        <?php
                        if ($obNotificacao->tipo == 'noti') {
                            echo '<div class="info-box bg-green">';

                        } else {
                            echo '<div class="info-box bg-primary">';
                        }
                        ?>
                            <span class="info-box-icon"><?php
                                if ($obNotificacao->tipo == 'noti') {
                                    echo '<i class="far fa-envelope"></i>';

                                } else {
                                    echo '<i class="far fa-check-circle"></i>';
                                }
                                ?>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 10px">
                                    <?php
                                    if ($obNotificacao->tipo == 'noti'){
                                        echo 'Notificação';
                                    } else {
                                        echo 'Atualização';
                                    }
                                    ?>
                                </span>
                                <span class="info-box-number" style="font-size: 14px"><?php echo $obNotificacao->title ?></span>
                                <span class="" style="font-size: 12px">
                                    <?php echo $obNotificacao->descricao ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="dropdown-divider"></div>
                    <a href="../app/Ajax/notificacao.php" class="dropdown-item dropdown-footer">Marcar todos como lido</a>
            </li>


            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="far fa-user"></i>
                    <span class="d-none d-md-inline"><?php echo $usuarioLogado['nome']; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-info">
                            <h3 class="widget-user-username"><?php echo $usuarioLogado['nome']; ?></h3>
                            <h5 class="widget-user-desc"><?php nomefuncao(); ?></h5>
                        </div>

                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="/usuarios/alterar-senha.php?id=<?php echo $usuarioLogado['id'] ?>" class="btn btn-default btn-flat">Alterar Senha</a>
                        <a href="/logout.php" class="btn btn-default btn-flat float-right">Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar  elevation-4 sidebar-light-warning">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <b  class="brand-image img-circle elevation-3" style="color: silver ;padding: 8px">DS</b>
            <span class="brand-text font-weight-light">Sistema de Gestão <span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Painel Usuario -->

            <nav class="mt-3 ">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item <?php active('painel.php'); ?>">
                        <a id="menudash" href="/painel.php" class="nav-link <?php active('painel.php'); ?>">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Dashborad
                            </p>
                        </a>
                    </li>
                    <li class="nav-item <?php active('caixa'); ?>">
                        <a  href="#" class="nav-link <?php active('caixa'); ?>">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>
                                Caixa
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ">
                            <li class="nav-item ">
                                <a href="/caixa/painelcaixa.php" class="nav-link <?php activemenu('caixa/painelcaixa.php'); ?>">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Painel do Caixa</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/caixa/cadastrar.php" class="nav-link <?php activemenu('caixa/cadastrar.php'); ?>">
                                    <i class="fas fa-pen nav-icon"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item <?php active('vendas'); ?>">
                        <a href="#" class="nav-link <?php active('vendas'); ?>">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Vendas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/vendas/painelvendas.php" class="nav-link <?php activemenu('vendas/painelvendas.php'); ?>">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Painel de Vendas</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/vendas/cadastrar.php" class="nav-link <?php activemenu('vendas/cadastrar.php'); ?>">
                                    <i class="fas fa-pen nav-icon"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item <?php active('servicos'); ?>">
                        <a href="#" class="nav-link <?php active('servicos'); ?>">
                            <i class="nav-icon fas fa-screwdriver"></i>
                            <p>
                                Serviços
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/servicos/painelservicos.php" class="nav-link <?php activemenu('servicos/painelservicos.php'); ?>">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Painel de Serviços</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/servicos/cadastrar.php" class="nav-link <?php activemenu('servicos/cadastrar.php'); ?>">
                                    <i class="fas fa-pen nav-icon"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item <?php active('estoque'); ?>">
                        <a href="#" class="nav-link <?php active('estoque'); ?>">
                            <i class="nav-icon fas fa-coins"></i>
                            <p>
                                Estoque
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/estoque/painelestoque.php" class="nav-link <?php activemenu('estoque/painelestoque.php'); ?>">
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Painel do Estoque</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/estoque/cadastrar.php" class="nav-link <?php activemenu('estoque/cadastrar.php'); ?>">
                                    <i class="fas fa-pen nav-icon"></i>
                                    <p>Cadastrar</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php if (Login::requireFuncao('1 , 2')) { ?>
                        <li class="nav-item <?php active('usuarios'); ?>">
                            <a href="#" class="nav-link <?php active('usuarios'); ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Usuarios
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/usuarios/cadastrar.php" class="nav-link <?php activemenu('usuarios/cadastrar.php'); ?>">
                                        <i class="fas fa-pen nav-icon"></i>
                                        <p>Cadastrar</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/usuarios/listar.php" class="nav-link <?php activemenu('usuarios/listar.php'); ?>">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Lista</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?php active('unidades'); ?>">
                            <a href="#" class="nav-link <?php active('unidades'); ?>">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>
                                    Lojas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item ">
                                    <a href="/unidades/cadastrar.php" class="nav-link <?php activemenu('unidades/cadastrar.php'); ?>">
                                        <i class="fas fa-pen nav-icon"></i>
                                        <p>Cadastrar</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/unidades/listar.php" class="nav-link <?php activemenu('unidades/listar.php'); ?>">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Lista</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (Login::requireFuncao('1')) { ?>
                        <li class="nav-item <?php active('master'); ?>">
                            <a href="#" class="nav-link <?php active('master'); ?>">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Administração
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/painelmaster.php" class="nav-link <?php activemenu('master/painelmaster.php'); ?>">
                                        <i class="fas fa-chalkboard nav-icon"></i>
                                        <p>Painel Master</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </aside>