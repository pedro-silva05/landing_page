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
$nome = mysqli_fetch_assoc($resultado);

$query_produtos = "SELECT * FROM produto";
$resultado_produtos = mysqli_query($conn, $query_produtos);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/loja-style/body1.css">
    <link rel="stylesheet" href="../style/loja-style/header.css">
    <link rel="stylesheet" href="../style/loja-style/promocoes.css">
    <link rel="stylesheet" href="../style/loja-style/produtos.css">
    <title>Loja</title>
</head>

<body>
    <header>
        <div>
            <img id="img-logo" src="../img/perfilbranco.jpg" alt="">
        </div>
        <div id="pesquisar">
            <input type="text" class="input-search" placeholder="Pesquise por nome ou categoria do produto">
            <button class="button-search"><i class="fa-solid fa-search"></i></button>
        </div>
        <div>
            <button id="perfil" class="active" onclick="perfil()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg><?php echo $nome['nome']?></button>
        </div>
        <div id="options-perfil">
            <button class="btn-options">Configurações</button>
            <button class="btn-options" style="color: red;">Sair</button>
        </div>
    </header>
    <section id="promocoes">
        <div>
            <h1>Promoções do dia</h1>
        </div>
        <div class="promocoes-produtos">
            <div class="itens">
                <div class="desconto">
                    <h3>-40%</h3>
                </div>
                <img class="img-produtos" src="../img/pao_de_queijo.png" alt="">
                <div class="center">
                    <h3>Pão de Queijo</h3>
                    <p>3 Unidades R$1,00 ou</p>
                    <p>Unidade R$0,35</p>
                </div>
                <a href="#" class="btn-produtos">Comprar agora</a>
            </div>
            <div class="itens">
                <div class="desconto">
                    <h3>-40%</h3>
                </div>
                <img class="img-produtos" src="../img/pao_de_sal.jpeg" alt="">
                <div class="center">
                    <h3>Pão de Sal</h3>
                    <p>Undidade R$0,50</p>
                </div>
                <a href="#" class="btn-produtos">Comprar agora</a>
            </div>
            <div class="itens">
                <div class="desconto">
                    <h3>-40%</h3>
                </div>
                <img class="img-produtos" src="../img/181675-1600-auto.webp" alt="">
                <div class="center">
                    <h3>Pão de Milho</h3>
                    <p>Undidade R$0,55</p>
                </div>
                <a href="#" class="btn-produtos">Comprar agora</a>
            </div>
            <div class="itens">
                <div class="desconto">
                    <h3>-40%</h3>
                </div>
                <img class="img-produtos" src="../img/9b92d4b17bba63dc3b02daa11d039cf8b48fe772dad00e3c58facf70a15bcd42_full.jpg" alt="">
                <div class="center">
                    <h3>Pão de Leite</h3>
                    <p>Undidade R$0,55</p>
                </div>
                <a href="#" class="btn-produtos">Comprar agora</a>
            </div>
        </div>
    </section>
    <section id="produtos">
        <div>
            <h1>Da nossa padaria para <span>você</span></h1>
        </div>
        <div>
            <?php
            if($resultado_produtos && mysqli_num_rows($resultado_produtos) > 0){

                $coluna_linha = 4;
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
                    echo "<p class='p'>R$ ". $produtos['valorVenda'] ."</p>";
                    echo "</div>";
                    echo "<a href='' class='btn-produtos'>Comprar agora</a>";
                    echo "</div>";

                    $contar_coluna++;
                }
                echo "</div>";
            }
            ?>
        </div>
    </section>
    <footer id="rodape">

    </footer>
    <script src="../javascript/scriptLoja.js"></script>
</body>

</html>