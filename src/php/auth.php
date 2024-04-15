<?php

include_once("../../config/config.php");
session_start();
$msg = "";

if(isset($_POST["add"])&& !empty($_POST["email"]) && !empty($_POST["senha"])){
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if(mysqli_num_rows($resultado) === 1){
        $usuario = mysqli_fetch_assoc($resultado);

        if(password_verify($senha, $usuario["senha"])){
            $_SESSION["email"] = $email;
            $_SESSION["senha"] = $senha;
            header("Location: ../pages/loja.php");
            exit();
        }
        else{
            unset($_SESSION["email"]);
            unset($_SESSION["senha"]);
            $msg = "Usuário ou senha incorretos!";
            $_SESSION["msg"] = $msg;
            header("Location: ../pages/entrar.php");
            exit();
        }
    } 
    else{
        $msg = "Usuário ou senha incorretos!";
        $_SESSION["msg"] = $msg;
        header("Location: ../pages/entrar.php");
        exit();
    }
}
?>