<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Entity\Unidade;

//DEFINE A TIMEZONE
if (isset($_SESSION['usuario']['unidade']) and $_SESSION['usuario']['unidade'] != '0') {
    $unidade = Unidade::getUnidade($_SESSION['usuario']['unidade']);
    date_default_timezone_set($unidade->timezone);
} else {
    date_default_timezone_set('America/sao_paulo');
}

//FORMATA STRING PRA DEIXAR APENAS NÚMEROS
function deixarNumero($string)
{
    return preg_replace("/[^0-9]/", "", $string);
}

//PORCENTAGEM
function porcentagem(float $valor_base, float $valor): float
{
    return (($valor_base - $valor) / $valor_base) * 100;
}

//FORMATAR VALOR
$brl = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);



function minutoHora($minutos)
{
    $hora = floor($minutos / 60);
    $resto = $minutos % 60;
    return $hora . ':' . $resto;
}

//FUNCTION PARA TRAZER O NOME DA FUNÇÃO
function funcao($funcao)
{
    switch ($funcao) {
        case '1':
            return 'Master';
            break;
        case '2':
            return 'Gerente';
            break;
        case '3':
            return 'Aplicador';
            break;
        case '4':
            return 'Recepção/Vendedor';
            break;
        case '10':
            return 'Cliente';
            break;
    }
}

//FUNCTION PARA TRAZER O SEXO
function sexo($sexo)
{
    switch ($sexo) {
        case 'f':
            return 'Feminino';
            break;
        case 'm':
            return 'Masculino';
            break;
    }
}

//FUNÇÃO PARA TRAZER OS DOIS PRIMEIROS NOMES
function doisNomes($nomeCliente)
{
    $nome = '';
    $nome = explode(' ', $nomeCliente);
    if ($nome[1] == 'de' || $nome[1] == 'do' || $nome[1] == 'da' || $nome[1] == 'dos' || $nome[1] == 'das' || $nome[1] == 'DE' || $nome[1] == 'DO' || $nome[1] == 'DA' || $nome[1] == 'DOS' || $nome[1] == 'DAS') {
        $nome = $nome[0] . ' ' . $nome[2];
    } else {
        $nome = $nome[0] . ' ' . $nome[1];
    }
    return $nome;
}

