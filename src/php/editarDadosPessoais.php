<?php

include_once "../../config/config.php";

if(isset($_GET["salvar"]) && empty($_GET["salvar"])){
    $email = $_GET["email"];
    $nome = $_GET["nome"];
    $dataNasc = $_GET["dataNasc"];
    $cpf = $_GET["cpf"];
    $celular = $_GET["celular"];

    function formatarCpf($cpf){
        return substr($cpf, 0, 3).'.'. substr($cpf, 3, 3).'.'. substr($cpf, 6, 3).'-'. substr($cpf, 9, 2);
    }

    $cpfFormatado = formatarCpf($cpf);

    $query_ataualizar = "UPDATE usuario SET  nome = '$nome', dataNasc = '$dataNasc', cpf = '$cpfFormatado', celular = '$celular' WHERE email = '$email'";
    $result_atualizar = mysqli_query($conn, $query_ataualizar);

    header("Location: ../pages/perfil.php?=editado");
    exit();
}
?>