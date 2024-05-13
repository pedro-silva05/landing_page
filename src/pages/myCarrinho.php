<?php

require '../php/processarCarrinho.php';
require '../php/processarProduto.php';
session_start();
if(!isset($_SESSION["nome"]) && !isset($_SESSION["email"])){
    unset($_SESSION["email"]);
    unset($_SESSION["nome"]);
    header("Location: entrar.php");
    exit();
}
$nome = $_SESSION["nome"];

$carrinho = new Carrinho;
$produtosCarrinho = $carrinho->getCarrinho();
$itens = $carrinho->calcularQuantidadeTotal();


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["limpar"])) {
    $limpar = $carrinho->limparCarrinho();
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])){
    $id_produto = $_POST["id"];
    $carrinho->limparProduto($id_produto);
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}


$subTotal = 0;

if(isset($_SESSION["carrinho"]["total"])){
    $subTotal = $_SESSION["carrinho"]["total"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/loja-style/header.css">
    <link rel="stylesheet" href="../style/myCarrinho/body.css">
    <title>Carrinho</title>
</head>
<body>
    <header>
        <div>
            <a href="../pages/loja.php"><img id="img-logo" src="../img/perfilbranco.jpg" alt=""></a>
        </div>
        <div id="pesquisar">
            <input type="text" class="input-search" placeholder="Pesquise por nome ou categoria do produto">
            <button class="button-search"><i class="fa-solid fa-search"></i></button>
        </div>
        <div class="icons">
            <button id="perfil" class="active" onclick="perfil()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg><?php echo $nome ?>
            </button>
            <a class="carrinho" href="../pages/myCarrinho.php"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                </svg>
            </a>
        </div>
        <div id="options-perfil">
            <button class="btn-options">Configurações</button>
            <button class="btn-options" style="color: red;">Sair</button>
        </div>
    </header>
    <section>
        <div>
            <h1>Carrinho</h1>
        </div>
        <?php
            
            if(empty($produtosCarrinho)){
                echo"<div class='carrinho-vazio'>
                    <div>
                        <h2>O Carrinho esta vazio <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-cart-x' viewBox='0 0 16 16'>
                        <path d='M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793z'/>
                        <path d='M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                        </svg></h2>
                    </div>
                    <div>
                        <p>Navegue por nosso site/padaria ou busque pelo seu produto.</p>
                        <p style='text-align: center;'>Esperemos por você!</p>
                    </div>
                    <div>
                        <a href='../pages/loja.php' class='btn'>Continuar Comprando</a>
                    </div>
                    </div>";
            }
            
            ?>
        <div class="info">
            <div class='list-produtos'>
            <?php
            if(!empty($produtosCarrinho)){

                foreach($produtosCarrinho as $produtos){

                $id = $produtos->getId();
                $desc = $produtos->getDescricao();
                $quantidade = $produtos->getQuantidade();
                $valor = $produtos->getValor();
                $total = $quantidade * $valor;

                echo "
                    <div class='produtos'>
                        <div>
                            <img style='width: 150px; height: 150px;' src='../img/".$id.".png' alt=''>
                        </div>
                        <div class='descricao'>
                            <h2>".$desc."</h2>
                            <div>
                                <p>Vendido e entregue por: Padaria Empório Aliança</p>
                                <p>Valor unitário: <strong>R$".number_format($valor, 2, ',')."</strong></p> 
                            </div>
                        </div>
                        <div class='quantidade'>
                            <p>Qtd: ".$quantidade."</p>
                            <a href='../pages/produto.php?/$id/$desc' class='editar'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                            </svg></a>
                        </div>
                        <div class='total'>
                            <h1>R$".number_format($total, 2, ',')."</h1>
                        </div>
                        <div>
                            <form method='post'>
                                <input type='hidden' name='id' value='".$id."'>
                                <button type='submit' name='limparItem' class='button-trash'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
                                <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
                                </svg></button>
                            </form>
                        </div>
                    </div>";
                }
            }
            ?>
            </div>
            <?php
            
            if(!empty($produtosCarrinho)){
                echo"<div class='info-compra'>
                        <div class='subTotal'>
                            <div class=''>
                                <h3>Resumo do pedido</h3>
                            </div>
                            <div>
                                <p>Produtos no carrinho(".$itens.")</p>
                                <p>Frete</p>
                            </div>  
                            <div style='border-top: 1px solid #000; padding-top: 10px;'>
                                <h3>R$".number_format($subTotal, 2, ',')."</h3>
                            </div>
                        </div>
                        <div class='btn-margin'>
                            <a href='../pages/loja.php'><button id='btn-pagar' >Ir para pagamento</button></a>
                        </div>
                        <div class='btn-margin'>
                            <a href='../pages/loja.php'><button class='btn-subTotal'>Continuar comprando</button></a>
                        </div>
                        <div class='btn-margin'>
                            <form method='post'>
                                <button type'submit' name='limpar' id='btn-limpar'>Limpar carrinho</button>
                            </form>
                        </div>
                    </div>";
            }

            ?>
        </div>
    </section>
    <script>
        function aumentarValor() {
            const inputQtd = document.getElementById('qtd');
            let valor = parseInt(inputQtd.value) || 0;
            inputQtd.value = valor + 1;
        }

        function diminuirValor() {
            const inputQtd = document.getElementById('qtd');
            let valor = parseInt(inputQtd.value) || 0;
            if (valor > 1) {
                inputQtd.value = valor - 1;
            }
        }
    </script>
</body>
</html>