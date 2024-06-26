<?php

include_once("../../config/config.php");
session_start();

if (!isset($_SESSION["email"])) {
    unset($_SESSION["email"]);
    header("Location: entrar.php");
    exit;
}

$email = $_SESSION['email'];

$query = "SELECT nome FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($conn, $query);
$assoc = mysqli_fetch_assoc($resultado);
$nome = $assoc["nome"];

$parts = explode(" ", $nome);
    $primeiroNome = $parts[0];
    $ultimoNome = end($parts);

    $usuario = $primeiroNome . " " . $ultimoNome;

$_SESSION["usuario"] = $usuario;

if(isset($_POST["sair"])){
    $sair = $_POST[$sair];
    session_destroy();
    header("Location: entrar.php");
    exit();
}

if(!empty($_GET["search"])){
    $dados = $_GET["search"];
    $query_produtos = "SELECT * FROM produto WHERE descricao LIKE '%$dados%' or categoria LIKE '%$dados%'";
    $visivel = 1;
} else{
    $query_produtos = "SELECT * FROM produto ORDER BY id_produto ASC";
    $visivel = 0;
}
$resultado_produtos = mysqli_query($conn, $query_produtos);


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/perfilmarrom.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/loja-style/body.css">
    <link rel="stylesheet" href="../style/loja-style/header.css">
    <link rel="stylesheet" href="../style/loja-style/promocoes.css">
    <link rel="stylesheet" href="../style/loja-style/produtos.css">
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>Loja</title>
</head>

<body>
    <header>
        <div>
            <a href="../pages/index.html"><img id="img-logo" src="../img/perfilbranco.jpg" alt=""></a>
        </div>
        <div id="pesquisar">
            <input type="search" class="input-search" id="search" placeholder="Pesquise por nome ou categoria do produto">
            <button onclick="searchData()" class="button-search"><i class="fa-solid fa-search"></i></button>
        </div>
        <div class="icons">
            <button id="perfil" class="active" onclick="perfil()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg><?php echo $usuario ?>
            </button>
            <a class="carrinho" href="../pages/myCarrinho.php"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                </svg>
            </a>
        </div>
        <div id="options-perfil">
            <form method="post">
                <a href="perfil.php"><button type="button" class="btn-options">Ver Perfil</button></a>
                <button type="submit" name="sair" class="btn-options" style="color: red;">Sair</button>
            </form>
            
        </div>
    </header>
    <?php

    switch($visivel){
        case 0: echo
    "<section id='promocoes'>
        <div>
            <h1 class='reveal-left'>Promoções do dia</h1>
        </div>
        <div class='promocoes-produtos'>
            <div class='itens'>
                <div class='desconto'>
                    <h3 class='desconto-font'>-40%</h3>
                </div>
                <img class='img-produtos' src='../img/pao_de_queijo.png' alt=''>
                <div class='center'>
                    <h3>Pão de Queijo</h3>
                    <p>3 Unidades R$1,00 ou</p>
                    <p>Unidade R$0,35</p>
                </div>
                <a href='#' class='btn-produtos'>Comprar agora</a>
            </div>
            <div class='itens'>
                <div class='desconto'>
                    <h3 class='desconto-font'>-60%</h3>
                </div>
                <img class='img-produtos' src='../img/pao_de_sal.jpeg' alt=''>
                <div class='center'>
                    <h3>Pão de Sal</h3>
                    <p>Undidade R$0,50</p>
                </div>
                <a href='#' class='btn-produtos'>Comprar agora</a>
            </div>
            <div class='itens'>
                <div class='desconto'>
                    <h3 class='desconto-font'>-30%</h3>
                </div>
                <img class='img-produtos' src='../img/181675-1600-auto.webp' alt=''>
                <div class='center'>
                    <h3>Pão de Milho</h3>
                    <p>Undidade R$0,55</p>
                </div>
                <a href='#' class='btn-produtos'>Comprar agora</a>
            </div>
            <div class='itens'>
                <div class='desconto'>
                    <h3 class='desconto-font'>-20%</h3>
                </div>
                <img class='img-produtos' src='../img/9b92d4b17bba63dc3b02daa11d039cf8b48fe772dad00e3c58facf70a15bcd42_full.jpg' alt=''>
                <div class='center'>
                    <h3>Pão de Leite</h3>
                    <p>Undidade R$0,55</p>
                </div>
                <a href='#' class='btn-produtos'>Comprar agora</a>
            </div>
        </div>
    </section>";
        break;
        case 1: echo 
    "<div style='padding-top: 91px;'></div>";
        break;
    }

    ?>
    <section id="produtos" style="min-height: 88vh;">
        <div>
            <h1 class="reveal-left"><?php switch($visivel): case 0: echo "Da nossa padaria para você"; break; case 1: echo "Resultado"; break; endswitch; ?></h1>
        </div>  
        <div>
            <?php
            if($resultado_produtos && mysqli_num_rows($resultado_produtos) > 0){

                $coluna_linha = 5;
                $contar_coluna = 0;

                echo "<div class='linha'>";
                while($produtos = mysqli_fetch_assoc($resultado_produtos)){

                    if ($contar_coluna > 0 && $contar_coluna % $coluna_linha == 0) {
                        echo "</div>";
                        echo "<div class='linha'>";
                    }
                    
                    echo "<div class='itens-produto'>";
                    echo "<img class='img-produtos' src='../img/". $produtos['id_produto'] .".png'>";
                    echo "<div class='center'>";
                    echo "<h3>" . $produtos['descricao'] . "</h3>";
                    echo "<p class='p'>R$ ". number_format($produtos['valorVenda'], 2, ',') ."</p>";
                    echo "</div>";
                    echo "<a href='../pages/produto.php?/$produtos[id_produto]/$produtos[descricao]' class='btn-produtos'>Comprar agora</a>";
                    echo "</div>";

                    $contar_coluna++;
                }
                echo "</div>";
            } else {
                echo "Nenhum produto encontrado.";
            }
            ?>
        </div>
    </section>
    <footer id="rodape">
        <div>
            <h2></h2>
        </div>
    </footer>
    <script src="../javascript/scriptLoja.js"></script>
    <script src="../javascript/search.js"></script>
</body>

</html>