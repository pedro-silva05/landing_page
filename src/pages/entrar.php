<?php
include_once("../php/auth.php");
if(isset($_SESSION["msg"]) === true){
    $msg = $_SESSION["msg"];
    unset($_SESSION["msg"]);
} else {
    unset($_SESSION["msg"]);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/entrar-cadastrar-style/body.css">
    <link rel="stylesheet" href="../style/entrar-cadastrar-style/erros.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Entrar</title>
</head>
<body>
    <main>
        <form action="../php/auth.php" method="post" class="conta">
            <img src="../img/perfilpreto.jpg" alt="logo" class="img-logo-form">
            <div class="input-form">
                <input type="email" placeholder="Insira seu e-mail:" name="email" class="input" required>
                <input type="password" placeholder="Senha:" name="senha" class="input" required>
                <div style="color: red; background-color: #fff;"><?php echo $msg; ?></div>
            </div>
            <div>
                <input type="submit" name="add" value="Cadastrar" class="btn">
            </div>
            <a href="../pages/cadastro.php">Não tem uma conta? <span class="span">Criar conta</span></a>
        </form>
    </main>
</body>
</html>