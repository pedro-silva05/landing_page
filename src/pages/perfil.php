<?php
include_once "../../config/config.php";

session_start();
if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
    $email = $_SESSION['email'];
    $query_usuario = "SELECT * FROM usuario WHERE email = '$email'";
    $resultado_usuario = mysqli_query($conn, $query_usuario);
    $assoc_usuario = mysqli_fetch_assoc($resultado_usuario);

    $usuario = $_SESSION["usuario"]; 
    $id = $assoc_usuario["id_usuario"];
    $_SESSION["id_usuario"] = $id;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/perfilmarrom.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/perfil/body.css">
    <link rel="stylesheet" href="../style/perfil/header.css">
    <link rel="stylesheet" href="../style/perfil/section.css">
    <link rel="stylesheet" href="../style/perfil/footer.css">
    <title>Perfil</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="loja.php"><img src="../img/perfilmarrom.jpg" alt="logo"></a>
        </div>
        <div class="perfil">
            <i class="fa-solid fa-user-circle"></i>
            <p>Olá, <?php echo $usuario; ?></p>
        </div>
    </header>
    <section>
        <nav class="nav-perfil">
            <ul>
                <li><a href="">Dados da Conta</a></li>
                <li><a href="">Meus Pedidos</a></li>
                <li><a href="">Sair</a></li>
            </ul>
        </nav>
        <div class="dados">
            <div>
                <h1>Dados da Conta</h1>
            </div>

            <?php

                if($dados = $assoc_usuario){
                    if(isset($_GET["editar"])){
                        echo "
                    <form action='../php/editarDadosPessoais.php' method='get'>
                        <div class='informacoes'>
                            <div class='div-informacoes'>
                                <div class='div-display-form'>
                                    <input type='hidden' name='email' id='email' value='".$dados["email"]."'>
                                </div>
                            </div>
                            <div class='div-informacoes'>
                                <div class='div-display-form'>
                                    <label for='nome'>Nome</label>
                                    <input type='text' name='nome' id='nome' value='".$dados["nome"]."' required>
                                </div>
                                <div class='div-display-form'>
                                    <label for='dataNasc'>Data de Nascimento</label>
                                    <input type='date' name='dataNasc' id='dataNasc' value='".$dados["dataNasc"]."' required>
                                </div>
                            </div>
                            <div class='div-informacoes'>
                                <div class='div-display-form'>
                                    <label for='cpf'>CPF (apenas numeros)</label>
                                    <input type='number' name='cpf' id='cpf' value='".$dados["cpf"]."' required>
                                </div>
                                <div class='div-display-form'>
                                    <label for='Celular'>Celular</label>
                                    <input type='tel' name='celular' id='celular' value='".$dados["celular"]."' required>
                                </div>
                            </div>
                            <div class='div-informacoes'>
                                <div>
                                    <button type='submit' name='salvar' class='btn-editar'>Salvar</button>
                                    <button type='button' onclick='voltar()' class='btn-editar'>Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>";
                    } else { 
                        echo "
                    <div class='informacoes'>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <h4>E-mail</h4>
                                <p>".$dados["email"]."</p>
                            </div>
                            <div class='div-display'>
                                <h4>Nome</h4>
                                <p>".$dados["nome"]."</p>
                            </div>
                            <div class='div-display'>
                                <h4>Data de Nascimento</h4>
                                <p>".$dados["dataNasc"]."</p>
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <h4>CPF</h4>
                                <p>".$dados["cpf"]."</p>
                            </div>
                            <div class='div-display'>
                                <h4>Sexo</h4>
                                <p>".$dados["sexo"]."</p>
                            </div>
                            <div class='div-display'>
                                <h4>Celular</h4>
                                <p>".$dados["celular"]."</p>
                            </div>
                        </div>
                            <div class='div-informacoes'>
                                <div>
                                    <form method='get' action='perfil.php'>
                                        <button name='editar' class='btn-editar'>Editar Dados</button>
                                    </form>
                                </div>
                                <div>
                                    <button class='btn-editar'>Alterar Email</button>
                                </div>
                                <div>
                                    <button class='btn-editar'>Alterar Senha</button>
                                </div>
                            </div>
                    </div>";
                    }                    
                }
            
            ?>
            <div>
                <h1>Endereço</h1>
            </div>

            <?php
            
            $queryEndereco = "SELECT * FROM endereco WHERE id_usuario = '$id'";
            $resultadoEndereco = mysqli_query($conn, $queryEndereco);

            if(!$dadosEndereco = mysqli_fetch_assoc($resultadoEndereco)){
                echo "<form id='endereco' method='post' action='../php/processarEndereco.php'>
                    <div class='informacoes'>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <label for='cep'>CEP</label>
                                <input type='number' name='cep' id='cep' value='' placeholder='ex:12345-678' required>
                                <button type='button' class='btn-cep' onclick='buscarEndereco()'>Buscar</button>
                            </div>
                            <div class='div-display'>
                                <label for='estado'>Estado(UF)</label>
                                <input type='text' name='estado' id='estado' value='' placeholder='ex: SP' required >
                            </div>
                            <div class='div-display'>
                                <label for='cidade'>Cidade</label>
                                <input type='text' name='cidade' id='cidade' value='' placeholder='ex: São Paulo' required >
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <label for='bairro'>Bairro</label>
                                <input type='text' name='bairro' id='bairro' value='' placeholder='ex: Liberdade' required >
                            </div>
                            <div class='div-display'>
                                <label for='rua'>Rua</label>
                                <input type='text' name='rua' id='rua' value='' placeholder='ex: R. São Joaquim' required >
                            </div>
                            <div class='div-display'>
                                <label for='numero'>Número</label>
                                <input type='number' name='numero' id='numero' value='' placeholder='ex: 1234' required>
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <label for='complemento'>Complemento</label>
                                <input type='text' name='complemento' id='complemento' value=''>
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <button type='submit' name='addEndereco' id='addEndereco' class='btn-editar'>Adicionar Endereço</button>
                        </div>
                    </div>
                </form>";
            } else if(isset($_GET["editarEndereco"])){
                echo "<form id='endereco' method='post' action='../php/processarEndereco.php'>
                    <div class='informacoes'>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <label for='cep'>CEP</label>
                                <input type='number' name='cep' id='cep' value='' placeholder='ex:12345-678' required>
                                <button type='button' class='btn-cep' onclick='buscarEndereco()'>Buscar</button>
                            </div>
                            <div class='div-display'>
                                <label for='estado'>Estado(UF)</label>
                                <input type='text' name='estado' id='estado' value='' placeholder='ex: SP' required >
                            </div>
                            <div class='div-display'>
                                <label for='cidade'>Cidade</label>
                                <input type='text' name='cidade' id='cidade' value='' placeholder='ex: São Paulo' required >
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <label for='bairro'>Bairro</label>
                                <input type='text' name='bairro' id='bairro' value='' placeholder='ex: Liberdade' required >
                            </div>
                            <div class='div-display'>
                                <label for='rua'>Rua</label>
                                <input type='text' name='rua' id='rua' value='' placeholder='ex: R. São Joaquim' required >
                            </div>
                            <div class='div-display'>
                                <label for='numero'>Número</label>
                                <input type='number' name='numero' id='numero' value='' placeholder='ex: 1234' required>
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <div class='div-display'>
                                <label for='complemento'>Complemento</label>
                                <input type='text' name='complemento' id='complemento' value=''>
                            </div>
                        </div>
                        <div class='div-informacoes'>
                            <div>
                                <button type='submit' name='addEndereco' id='addEndereco' class='btn-editar'>Adicionar Endereço</button>
                                <button type='button' onclick='voltar()' class='btn-editar'>Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>";
            } else {
                if(!$dadosEndereco["complemento"]){
                    $dadosEndereco["complemento"] = "vazio";
                }
                echo "
                <div class='informacoes'>
                    <div class='div-informacoes'>
                        <div class='div-display'>
                            <h4>CEP</h4>
                            <p>".$dadosEndereco["cep"]."</p>
                        </div>
                        <div class='div-display'>
                            <h4>Estado</h4>
                            <p>".$dadosEndereco["estado"]."</p>
                        </div>
                        <div class='div-display'>
                            <h4>Cidade</h4>
                            <p>".$dadosEndereco["cidade"]."</p>
                        </div>
                    </div>
                    <div class='div-informacoes'>
                        <div class='div-display'>
                            <h4>Bairro</h4>
                            <p>".$dadosEndereco["bairro"]."</p>
                        </div>
                        <div class='div-display'>
                            <h4>Rua</h4>
                            <p>".$dadosEndereco["rua"]."</p>
                        </div>
                        <div class='div-display'>
                            <h4>Numero</h4>
                            <p>".$dadosEndereco["numero"]."</p>
                        </div>
                    </div>
                    <div class='div-informacoes'>
                        <div class='div-display'>
                            <h4>Complemento</h4>
                            <p>".$dadosEndereco["complemento"]."</p>
                        </div>
                    </div>
                        <div class='div-informacoes'>
                            <div>
                                <form method='get' action='perfil.php'>
                                    <button name='editarEndereco' class='btn-editar'>Editar Endereço</button>
                                </form>
                            </div>                   
                        </div>
                </div>";    
            }
            
            ?>
        </div>
    </section>
    <footer>
        <p>oi</p>
    </footer>
    <script>
        function voltar(){
            history.back();
        }

        document.getElementById('cpf').addEventListener('input', function(){
            if(this.value.length > 11){
                this.value = this.value.slice(0,11);
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const celular = document.getElementById('celular');
            celular.addEventListener('input', function(e){

                if(this.value.length > 14){
                this.value = this.value.slice(0,14);
                }

                let value = e.target.value;
                
                value = value.replace(/\D/g, '');

                if(value.length > 0){
                    value = value.replace(/^(\d{2})(\d)/, '($1)$2');
                }

                if(value.length > 9){
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }

                e.target.value = value;
            });
        });

    function buscarEndereco() {
        const cep = document.getElementById('cep').value.replace(/\D/g, '');

        if (cep.length !== 8) {
            alert('CEP inválido!');
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado!');
                    return;
                }

                document.getElementById('rua').value = data.logradouro ;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
            })
            .catch(error => {
                console.error('Erro ao buscar o CEP:', error);
                alert('Erro ao buscar o CEP!');
            });
    }

    </script>
</body>
</html>