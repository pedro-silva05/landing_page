<?php

class AddProduto{
    private int $id;
    private string $descricao;
    private int $quantidade;
    private float $valor;


    public function getId(){
        return $this->id;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function getQuantidade(){
        return $this->quantidade;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }

    public function setQuantidade(int $quantidade){
        $this->quantidade = $quantidade;
    }

    public function setValor(float $valor){
        $this->valor = $valor;
    }
}

?>