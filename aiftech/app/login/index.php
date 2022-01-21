<?php
include "../../def.php";
try{
    $perfis=\modelo\Usuario::PERFIS;
    
    include "index.html.php";
}catch(\Exception $e){
    \templates\Igreja::erro($e);
}
