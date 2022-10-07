<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Entity\Estoque;

//BUSCA O VALOR NO ESTOQUE
function retorna($idproduto)
{
    $Produto = Estoque::getProduto($idproduto);
    $ValorProduto = $Produto->valorvenda;
    if(!empty($ValorProduto)){
        $valores['valorproduto'] = $ValorProduto;
    }else{
        $valores['valorproduto'] = '0';
    }
    return json_encode($valores);
}

//RETORNA O VALOR
if(isset($_GET['idproduto'])){
    echo retorna($_GET['idproduto']);
}
