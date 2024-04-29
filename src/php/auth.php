<?php

include_once("../../config/config.php");
session_start();
$msg = "";

if(isset($_POST["add"])&& !empty($_POST["email"]) && !empty($_POST["senha"])){
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuario INNER JOIN usuario_permissoes ON (usuario.id_usuario = usuario_permissoes.id_usuario) WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if(mysqli_num_rows($resultado) === 1){
        $usuario = mysqli_fetch_assoc($resultado);

        if(password_verify($senha, $usuario["senha"])){
            if($usuario["id_permissao"] == 1){
                $_SESSION["email"] = $email;
                header("Location: ../pages/loja.php");
                exit();
            }
            
            elseif($usuario["id_permissao"] == 2){
                $_SESSION["email"] = $email;
                $_SESSION["id_permissao"] = $usuario;
                header("Location: ../pages/admin/controleEstoque.php");
                exit();
            }
            
            else{
                $msg = "Você não tem permissao para acessar esta página";
                $_SESSION["msg"] = $msg;
                unset($_SESSION["email"]);
                header("Location: ../pages/entrar.php");
                exit();
            }
        }
        else{
            unset($_SESSION["email"]);
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