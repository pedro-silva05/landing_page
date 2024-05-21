<?php

include_once "../../config/config.php";

session_start();
if(isset($_POST["addEndereco"]) && isset($_SESSION["id_usuario"])){
    $cep = $_POST["cep"];
    $estado = $_POST["estado"];
    $cidade = $_POST["cidade"];
    $bairro = $_POST["bairro"];
    $rua = $_POST["rua"];
    $numero = $_POST["numero"];
    $complemento = $_POST["complemento"];
    $id = $_SESSION["id_usuario"];

    if($stmt_check = $conn->prepare("SELECT * FROM endereco where id_usuario = ?")){
        $stmt_check->bind_param('i', $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if($result_check->num_rows > 0){
            die("ja existe");
        } else {

            $stmt = $conn->prepare("INSERT INTO endereco(cep, estado, cidade, bairro, rua, numero, complemento, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssi", $cep, $estado, $cidade, $bairro, $rua, $numero, $complemento, $id);
            $stmt->execute();
        }
    }

    


    $stmt->close();
    $conn->close();
    header("Location: ../pages/perfil.php?=endereco_adicionado");
    exit();
}

?>