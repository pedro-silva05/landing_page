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

                $id_usuario = mysqli_insert_id($conn);
                $id_permissao = 1;

                $query_assoc = "INSERT INTO usuario_permissoes(id_Usuario, id_permissao) VALUES ('$id_usuario', '$id_permissao')";
                mysqli_query($conn, $query_assoc); 

                $_SESSION["email"] = $email;
                unset($_SESSION["msg"]);
                header("Location: ../pages/loja.php");
                exit();
            } 
            else{
                $msg = "Erro ao cadastrar!" . mysqli_error($conn);
                $_SESSION["msg"] = $msg;
                unset($_SESSION["email"]);
                header("Location: ../pages/cadastro.php");
                exit();
            }
        }
    }
    mysqli_close($conn);
}