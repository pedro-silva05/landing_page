<?php

session_start();
isset($_SESSION["email"]);
$nome = $_SESSION["nome"];

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = explode('/', $url);

$id = "";

foreach($parts as $part){
    if(is_numeric($part)){
        $id = $part;
    }
}

include_once("../../config/config.php");
if(!empty($id)){
    $query_produto = "SELECT * FROM produto WHERE id_produto = '$id'";
    $result = $conn->query($query_produto);
    if(mysqli_num_rows($result) > 0){
        while($linha = mysqli_fetch_assoc($result)){
            $descricao = $linha['descricao'];
            $valor = $linha['valorVenda'];
        }
    }
    $_SESSION["id_produto"] = $id;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/produto/body1.css">
    <link rel="stylesheet" href="../style/loja-style/header.css">
    <title><?php echo $descricao; ?></title>
</head>
<body>
    <header>
        <div>
            <a href="../pages/index.html"><img id="img-logo" src="../img/perfilbranco.jpg" alt=""></a>
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
        <div class="img-position">
            <img class="img" src="../img/<?php echo $id; ?>.png" alt="?">
        </div>
        <div class="info-produto">
            <div>
                <h2><?php echo $descricao; ?></h2>
            </div>
            <div>
                <p>Vendido e entregue por: Padaria Empório Aliança</p>
            </div>
            <div>
                <h2>R$<?php echo number_format($valor, 2, ','); ?></h2>
            </div>
            <form action="../php/carrinho.php" method="post">
                <div class="qtd">
                    <label for="qtd">Quantidade:</label>
                    <button type="button" onclick="diminuirValor()" class="qtd-value">-</button>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="number" min="1" value="1" max="100" name="qtd" id="qtd">
                    <button type="button" onclick="aumentarValor()" class="qtd-value">+</button>
                </div>
                <div>
                    <a href="loja.php"><button class="btn" type="submit" name="addCarrinho">COMPRAR</button></a>
                </div>
            </form>
        </div>
    </section>
    <script>
        const img = document.querySelector('.img');

        img.addEventListener('mouseenter', () => {
            img.style.transform = 'scale(1.3)';
        })

        img.addEventListener('mouseleave', () =>{
            img.style.transform = 'scale(1.0)';
        })

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

        function perfil(){
            var perfil = document.getElementById('options-perfil');
            perfil.classList.toggle('active');
        }
    </script>
</body>
</html>