<?php

include_once("../../config/config.php");
session_start();

if(!isset($_SESSION["email"]) && !isset($_SESSION["senha"])){
        unset($_SESSION["email"]);
        unset($_SESSION["senha"]);
        header("Location: entrar.php");
        exit;
    }


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
</head>
<body>
    <h1>Bem vindo!</h1>
</body>
</html>