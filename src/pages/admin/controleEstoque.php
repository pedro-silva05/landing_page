<?php
include_once("../../../config/config.php");
session_start();
$msg = "";
if(isset($_SESSION["id_permissao"]) != 2){
    $msg = "Você não tem permissão para acessar este site";
    $_SESSION["msg"] = $msg;
    unset($_SESSION["id_permissao"]);
    header("location: ../entrar.php");
    exit;
}

if(isset($_POST["Adicionar"])){
    $desc = $_POST['desc'];
    $codBarras = $_POST['codBarras'];
    $categoria = $_POST['categoria'];
    $valorCompra = $_POST['valorCompra'];
    $valorVenda = $_POST['valorVenda'];
    $qtd = $_POST['qtd'];

    if(!empty($desc) && !empty($codBarras) && !empty($categoria) && !empty($valorCompra) && !empty($valorVenda) && !empty($qtd)){
        $query_check = "SELECT * FROM produto WHERE codBarras = ?";
        $stmt_check = mysqli_prepare($conn, $query_check);
        mysqli_stmt_bind_param($stmt_check, 's', $codBarras);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        $num_rows = mysqli_stmt_num_rows($stmt_check);

        if($num_rows > 0){
            $msg = "Este produto ja foi cadastrado!";
        }
        else {
            $query = "INSERT INTO produto(descricao, codBarras, categoria, valorCompra, ValorVenda, quantidade) VALUES(?,?,?,?,?,?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssssss', $desc, $codBarras, $categoria, $valorCompra, $valorVenda, $qtd);
            mysqli_stmt_execute($stmt);
    
            if(mysqli_stmt_affected_rows($stmt) > 0){
                $msg = "Produto adicionado com sucesso";
                header("Location: controleEstoque.php?=+1");
                exit();
            }
        }
    }
}
$query_assoc = "SELECT * FROM produto";
$result_assoc = mysqli_query($conn, $query_assoc);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/controleEstoque-style/body.css">
    <link rel="stylesheet" href="../../style/controleEstoque-style/formProdutos.css">
    <title>Contole do Estoque | Administração</title>
</head>
<body>
    <div id="desfocus"></div>
    <div><?php print_r($_SESSION["id_permissao"])?></div>
    <header>

    </header>
    <section>
        <h1>Administração</h1>
        <div id="funcoes">
            <button class="btn" onclick="addProduto()">Adicionar Produto</button>
            <div>
                <label for="select">Filtrar por:</label>
                <select name="filtro" id="filtro">
                    <option value="">Ordem crescente</option>
                    <option value="">Ordem decrescente</option>
                    <option value="">Maior valor de venda</option>
                    <option value="">Menor valor de venda</option>
                    <option value="">Categoria</option>
                </select>
            </div>
        </div>
        <div id="hidden" class="hidden">
            <form action="" method="post">
                <div>
                    <div class="center">
                        <h1>Adicionar Produto</h1>
                    </div>
                    <div>
                        <input type="text" class="input-form" placeholder="Descrição do Produto:" name="desc" required>
                    </div>
                    <div>
                        <input type="number" class="input-form" placeholder="Código de Barras:" name="codBarras" id="cod" maxlength="13" arequired>
                    </div>
                    <div>
                        <input type="text" class="input-form" placeholder="Categoria:" name="categoria" required>
                    </div>
                    <div>
                        <input type="text" class="input-form" placeholder="Valor de Compra:" name="valorCompra" required>
                    </div>
                    <div>
                        <input type="text" class="input-form" placeholder="Valor de Venda:" name="valorVenda" required>
                    </div>
                    <div>
                        <input type="number" class="input-form" placeholder="Quantidade:" name="qtd" required>
                    </div>
                    <div class="center">
                        <input type="submit" value="Adicionar" name="Adicionar" class="btn">
                        <button class="btn" onclick="voltar()">Voltar</button>
                    </div>
                </div>
            </form>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Cód. Barras</th>
                <th>Categoria</th>
                <th>Valor de Compra</th>
                <th>Valor de venda</th>
                <th>Qtd</th>
                <th>Editar/Excluir</th>
            </tr>
            <?php
            if($result_assoc && mysqli_num_rows($result_assoc) > 0){
                while($linha = mysqli_fetch_assoc($result_assoc)){
                    echo "<tr>";
                    echo "<td>" . $linha['id_produto'] . "</td>";
                    echo "<td style='text-align: left;'>" . $linha['descricao'] . "</td>";
                    echo "<td>" . $linha['codBarras'] . "</td>";
                    echo "<td>" . $linha['categoria'] . "</td>";
                    echo "<td>R$ " . $linha['valorCompra'] . "</td>";
                    echo "<td>R$ " . $linha['valorVenda'] . "</td>";
                    echo "<td>" . $linha['quantidade'] . "</td>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='8'>Nenhum produto Encontrado</td>";
                echo "</tr>";
            }
            
            ?>
        </table>
    </section>
    <script src="../../javascript/scriptControleEstoque.js"></script>
</body>
</html>