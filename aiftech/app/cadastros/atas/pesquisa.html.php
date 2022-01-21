<table>
    <thead>
        <tr>
            <th class="centro">Número</th>
            <th class="">Data</th>
            <th class="">Tipo</th>
            <!--<th class="">Assuntos</th>-->
            <!--<th class="">Participantes</th>-->
            <th></th>
            <th class="oculto"></th>
        </tr>
    </thead>
    <tbody> 
        <?php foreach ($retorno as $ret): ?> 
            <?php
            $ata = modelo\Ata::selecionaArquivos($ret['id'], 'S');
//      $assuntos = $ret["assuntos"];
//      $titulos = '';
//      foreach ($assuntos as $a) {
//        $titulos .= $a["titulo"].', ';
//      }
//      $titulos = substr($titulos, 0, -2);
//      $participantes = $ret["participantes"];
//      $membros = '';
//      foreach ($participantes as $p) {
//        $membros .= $p["nome"].', ';
//      }
//      $membros = substr($membros, 0, -2);
            ?>
            <tr>
                <td data-titulo="Número" class="centro"><?= e($ret["num"]) ?></td>
                <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["data"])) ?></td>
                <td data-titulo="Tipo" class=""><?= e($ret["tipo_desc"]) ?></td>
                <!--<td data-titulo="Assuntos" class=""><?= e($titulos) ?></td>-->
                <!--<td data-titulo="Participantes" class=""><?= e($membros) ?></td>-->
                <td data-titulo="" class="oculto"><?= e($ret["ata_ft"]) ?></td>
                <td class="acoes">
                    <div>
                        <?php if (!$ata || $ret["finalizado"] != 'S'): ?>
                            <?php if ($permitido): ?>
                                <a id="a_acao" class="alterar" title="Alterar dados" href="ata.php?id=<?= hs($ret["id"]) ?>"></a>
                            <?php endif; ?>
                            <a id="a_acao" class="print" title="Gerar Ata em PDF" href="imprime.php?id=<?= hs($ret["id"]) ?>" target="_blank"></a>
                        <?php elseif ($ata['path']) : ?>
                            <a id="a_acao" class="download" title="Visualizar Ata em PDF" href="downloadArquivo.php?dir=<?= $ata['path'] ?>" target="_blank"></a>
                        <?php endif; ?>
                        <a id="a_acao" class="detalhe" title="Mostrar arquivos anexos." onclick="mostra_arquivos(<?= hs($ret["id"]) ?>)"></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?> 
    </tbody>
</table>