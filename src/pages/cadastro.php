<?php
include_once("../php/salvarUsuario.php");
if(isset($_SESSION["msg"]) === true){
    $msg = $_SESSION["msg"];
    unset($_SESSION["msg"]);
} else{
    unset($_SESSION["msg"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/entrar-cadastrar-style/body.css">
    <title>Cadastrar</title>
</head>
<body>
    <main>
        <form action="../php/salvarUsuario.php" method="post" class="conta">
            <img src="../img/perfilpreto.jpg" alt="logo" class="img-logo-form">
            <div class="input-form">
                <input type="text" placeholder="Insira seu nome:" name="nome" class="input" required>
                <input type="email" placeholder="Insira seu e-mail:" name="email" class="input" required>
                <input type="password" placeholder="Senha:" name="senha" class="input" required>
                <input type="password" placeholder="Confirme sua Senha:" name="confSenha" class="input" required>
                <div style="color: red; background-color: #fff;"><?php echo $msg; ?></div>
            </div>
            <div>
                <input type="submit" name="add" value="Cadastrar" class="btn">
            </div>
            <a href="../pages/entrar.php">Já tem uma conta? <span>Entrar</span></a>
        </form>
    </main>
</body>
</html>