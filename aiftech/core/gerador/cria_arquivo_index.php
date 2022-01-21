<?php
$js = 
'function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");
//        var grid = container.querySelector(".grid");
//        var tabela = container.dataset.tb;
        
        function retorno(html) {
            grid.innerHTML = html;
            var tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
                //alerta.erro("Nenhum registro encontrado",3);
            }
            document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
            if (document.getElementById("txt_pesquisa").value) {
                var hash = historico.hash();
                hash.texto = document.getElementById("txt_pesquisa").value;
                historico.push(hash);
            }
        }
//        var ctn = document.body.querySelector("div.container-grid");
        var parametros = query_string({
//            "tabela": tabela,
            //"texto": document.getElementById("txt_pesquisa").value
        });
        ajax("pesquisa.php", parametros, retorno);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 8);
    }
}

function filtra(e) {
    var hash = historico.hash();
    var t = document.querySelector(".container-grid .grid table tbody");
    full_text(e, t, document.getElementById("txt_pesquisa"));
    if (!document.getElementById("txt_pesquisa").value) {
        delete hash.texto;
    } else if (eval(document.getElementById("txt_pesquisa").value.length % 3) == 0) {
        hash.texto = document.getElementById("txt_pesquisa").value;
    }
    historico.push(hash);
    var tr = t.querySelectorAll("tr:not(.oculto)");
    document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
}

function liga_desliga(a) {
  try {
    if (a.classList.contains("ligado")) {
        a.classList.remove("ligado");
        a.classList.add("desligado");
    } else {
        a.classList.remove("desligado");
        a.classList.add("ligado");
    }
    var linha = a.parentNode.parentNode.parentNode;
    var ativo = (a.classList.contains("ligado"))? "S" : "N";
    var param = query_string({
        "id": linha.cells[0].innerHTML,
        "ativo": ativo
    });
    ajax("salva.php", param, function (resp) {
      try {
        var r = JSON.parse(resp);
        if (r.erro) {
          throw r.mensagem;
        }
      } catch (e) {
        alerta.erro(e, 10);
      }
    });
  } catch (e) {
    alerta.erro(e, 10);
  }    
}

historico.load(function (hash) {
    if (hash.texto) {
        document.getElementById("txt_pesquisa").value = hash.texto;
        delete hash.texto;
        historico.push(hash);

        pesquisa();
    } else {
        document.getElementById("txt_pesquisa").innerHTML = "";
    }
});

//function enter(e) {
//   if (e.keyCode == 13) {
//        pesquisa();
//       document.getElementById("txt_pesquisa").focus();
//        return false;
//    }
//}

//function pesquisar(e) {
//    if (e.keyCode != 13) {
//        var tam = eval(document.getElementById("txt_pesquisa").value.length % 4);
//        if (tam == 0) {
//            pesquisa();
//            document.getElementById("txt_pesquisa").focus();
//            return false;
//        }
//    }
//}
pesquisa();';

$css = 
'#ctn_totalizador{
  width: 100%;
  text-align: center;
}
#total_registros{
  font-size: 1rem;
}
.sem_registro{
  text-align: center;
}
/*.direita {
    text-align: right;
}
.centro {
    text-align: center;
}*/
@media (min-width: 1024px) {
  #ctn_totalizador{
    /*text-align: right;*/
    margin-bottom: 5px;
  }
  #total_registros{
    margin-right: 2px;
  }
}';

$php = 
'<?php
include "../../../def.php";

try {
    include "index.html.php";
} catch (\Exception $e) {
    ' . $template . '::erro($e);
}
?>';

$html = 
'<?php $template = new ' . $template . '() ?>

    <?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
    <?php $template->fimCss() ?>

    <?php $template->iniMain() ?>

    <div class="container-grid">
        <h1>' . $titulo . '</h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="controle">
                        <input type="text" id="txt_pesquisa" onkeyup="filtra(event)">
                    </div>
                    <div class="mensagem"></div>
                </div>
                <a class="botao no-max" onclick="pesquisa();">Pesquisar</a>
                <a class="novo" href="'.$nome_tabela.'.php"></a>
            </div>
        </div>
        <div id="ctn_totalizador">
            <span id="total_registros"></span>
        </div>
        <div class="grid"></div>
    </div>

    <?php $template->fimMain() ?>

    <?php $template->iniJs() ?>
    <script src="index.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>';

$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/';
if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        throw new \Exception('Falha ao criar diretório do arquivo' . basename($dir) . '!!');
    }
} 

//---------->> javascript
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/index.js';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $js);
if ($fw != strlen($js)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//---------->> CSS
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/index.css';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $css);
if ($fw != strlen($css)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//---------->> php
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/index.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $php);
if ($fw != strlen($php)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//---------->> html
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/index.html.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $html);
if ($fw != strlen($html)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

