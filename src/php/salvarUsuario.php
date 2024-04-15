<?php

include_once("../../config/config.php");
$msg = "";
session_start();
if(isset($_POST['add'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];

    if($senha !== $confSenha){
        $msg = "As senhas não coincidem";
        $_SESSION["msg"] = $msg;
        header("Location: ../pages/cadastro.php");
        exit();
    }
    else{
        $query_check = "SELECT * FROM usuario where email = '$email'";
        $result_check = mysqli_query($conn, $query_check);
        if(mysqli_num_rows($result_check) > 0){
            $msg = "Usuário já cadastro!";
            $_SESSION["msg"] = $msg;
            header("Location: ../pages/cadastro.php");
            exit();
        }
        else{

            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $query = "INSERT INTO usuario(nome, email, senha) VALUES('$nome', '$email', '$hash')";

            if(mysqli_query($conn, $query)){
                $_SESSION["email"] = $email;
                $_SESSION["senha"] = $senha;
                unset($_SESSION["msg"]);
                header("Location: ../pages/loja.php");
                exit();
            } 
            else{
                $msg = "Erro ao cadastrar!" . mysqli_error($conn);
                $_SESSION["msg"] = $msg;
                unset($_SESSION["email"]);
                unset($_SESSION["senha"]);
                header("Location: ../pages/cadastro.php");
                exit();
            }
        }
    }
    mysqli_close($conn);
}