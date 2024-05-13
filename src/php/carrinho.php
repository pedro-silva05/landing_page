<?php
require '../php/processarCarrinho.php';
require '../php/processarProduto.php';
include_once ("../../config/config.php");
session_start();


if(isset($_POST["id"]) && isset($_POST["qtd"])){    
    $id = strip_tags($_POST["id"]);
    $qtd = strip_tags($_POST["qtd"]);
    $produtos = [];
    $query = "SELECT * FROM produto WHERE id_produto = '$id'";
    $result = mysqli_query($conn, $query);
    if($result->num_rows > 0){
        $produtos = mysqli_fetch_assoc($result);
        
    }
    $produtoInfo = $produtos;
    $AddProduto = new AddProduto;
    $AddProduto->setId($produtoInfo["id_produto"]);
    $AddProduto->setDescricao($produtoInfo["descricao"]);
    $AddProduto->setQuantidade($qtd);
    $AddProduto->setValor($produtoInfo["valorVenda"]);

    $carrinho = new Carrinho;
    $carrinho->addItem($AddProduto);
}

var_dump($_SESSION["carrinho"]);
header("Location: ../pages/myCarrinho.php");
exit();

?>