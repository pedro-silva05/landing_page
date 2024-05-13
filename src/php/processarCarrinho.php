<?php

class Carrinho{

    public function addItem(AddProduto $addProduto){
        $noCarrinho = false;
        $this->setTotal($addProduto);
        if(count($this->getCarrinho()) > 0){
            foreach($this->getCarrinho() as $produtosCarrinho){
                if($produtosCarrinho->getId() === $addProduto->getId()){
                    $qtd = $produtosCarrinho->getQuantidade() + $addProduto->getQuantidade();
                    $produtosCarrinho->setQuantidade($qtd); 
                    $noCarrinho = true;
                    break;
                }
            }
        }

        if(!$noCarrinho){
            $this->setProdutosCarrinho($addProduto);
        }
    }

    private function setProdutosCarrinho($addProduto){
        $_SESSION["carrinho"]["produtos"][] = $addProduto;
    }

    private function setTotal(AddProduto $addProduto){
        if (!isset($_SESSION["carrinho"]["total"])) {
            $_SESSION["carrinho"]["total"] = 0;
        }
    
        $_SESSION["carrinho"]["total"] += $addProduto->getValor() * $addProduto->getQuantidade();
    
    }

    public function calcularQuantidadeTotal(){
        $quantidadeTotal = 0;
        
        foreach($this->getCarrinho() as $produto){
            $quantidadeTotal += $produto->getQuantidade();
        }
        return $quantidadeTotal;
    }

    public function getCarrinho(){
        return $_SESSION["carrinho"]["produtos"] ?? [];
    }


    public function limparProduto(int $id_produto){
        if(isset($_SESSION["carrinho"]["produtos"])){
            foreach($this->getCarrinho() as $index => $produto){
                if($produto->getId() === $id_produto){
                    unset($_SESSION["carrinho"]["produtos"][$index]);
                    $_SESSION["carrinho"]["total"] -= $produto->getValor() * $produto->getQuantidade();
                }
            }
        }
    }

    public function limparCarrinho(){
        if(isset($_SESSION["carrinho"]["produtos"])){
            unset($_SESSION["carrinho"]["produtos"]);
            unset($_SESSION["carrinho"]["total"]);
        }
    }
}

?>