<?php

namespace modelo;

use bd\My;

class Plano{

    private $codigo;
    private $descricao;
    private $cadastrado=false;

    public function __construct($codigo){
        $c=My::con();
        if($codigo){
            $r=$c->query("CALL plano_seleciona($codigo)");
            $l=$r->fetch_assoc();
            if($l){
                $this->codigo=$codigo;
                $this->descricao=$l['descricao'];
                $this->cadastrado=true;
            }else{
                $this->codigo=$codigo;
            }
            $c->next_result();
        }
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public static function getPlanos(){
        $c = My::con();
        $r=$c->query('CALL planos_seleciona()');
        $planos=[];
        while($l=$r->fetch_assoc()){
            $planos[]=$l;
        }
        $c->next_result();
        return $planos;
    }

}
