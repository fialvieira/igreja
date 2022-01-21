<?php if (!empty($mm)): ?>
    <div class="card">
        <h1>Histórico movimentação: <?= e($retorno->getNome()) ?></h1>
        <table id="tbl_mov_membros">
            <thead>
            <tr>
                <th>Data</th>
                <th>Data Movimento</th>
                <th>Igreja</th>
                <th>Abreviação</th>
                <th>Pastor</th>
                <th>Tipo</th>
                <th>Nº Ata</th>
                <th>Nº Carta</th>
                <th>Arq. Anexo</th>
                <th>Dt. Carta Envio</th>
                <th>Dt. Carta Recebimento</th>
                <th>Secretário(a)</th>
                <th>Pastor/Presidente</th>
                <th>Observação</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($mm as $k => $v):
                $nome_receb = '';
                if ($v['carta_recebimento_path'] != '') {
                    $carta = str_replace('\\', '/', $v['carta_recebimento_path']);
                    $carta_arr = explode('/', $carta);
                    $nome_receb = $carta_arr[count($carta_arr) - 1];
                }
                ?>
                <tr data-id="<?= e($v['id']) ?>">
                    <td data-titulo="Data"><?= e(($v['data_mov'] != '') ? \bd\Formatos::dataApp($v['data_mov']) : '') ?></td>
                    <td data-titulo="Data Movimento"><?= e(($v['created'] != '') ? \bd\Formatos::dataApp($v['created']) : '') ?></td>
                    <td data-titulo="Igreja"><?= e($v['igreja']) ?></td>
                    <td data-titulo="Abreviacao"><?= e($v['abreviacao']) ?></td>
                    <td data-titulo="Pastor"><?= e($v['pastor']) ?></td>
                    <td data-titulo="Tipo"><?= e($v['tp_mov']) ?></td>
                    <?php if ($v['ata_path'] != ''): ?>
                        <td data-titulo="Nº Ata"><a href="downloadArquivo.php?dir=<?= e($v['ata_path']) ?>"
                                                    target="_blank"><?= e($v['ata_numero']) ?></a></td>
                    <?php else: ?>
                        <td data-titulo="Nº Ata"><?= e($v['ata_numero']) ?></td>
                    <?php endif; ?>
                    <?php if ($v['carta_envio_path'] != ''): ?>
                        <td data-titulo="Nº Carta"><a href="downloadArquivo.php?dir=<?= e($v['carta_envio_path']) ?>"
                                                      target="_blank"><?= e($v['carta_numero']) ?></a></td>
                    <?php else: ?>
                        <td data-titulo="Nº Carta"><?= e($v['carta_numero']) ?></td>
                    <?php endif; ?>
                    <td data-titulo="Arq. Anexo" data-path="<?= e($v['carta_recebimento_path']) ?>"><a
                                href="downloadArquivo.php?dir=<?= e($v['carta_recebimento_path']) ?>"
                                target="_blank"><?= e($nome_receb) ?></a></td>
                    <td data-titulo="Dt. Carta Envio"><?= e(($v['data_carta_envio'] != '' ? \bd\Formatos::dataApp($v['data_carta_envio']) : '')) ?></td>
                    <td data-titulo="Dt. Carta Recebimento"><?= e(($v['data_carta_recebimento'] != '') ? \bd\Formatos::dataApp($v['data_carta_recebimento']) : '') ?></td>
                    <td data-titulo="Secretário(a)"><?= e($v['secretario']) ?></td>
                    <td data-titulo="Pastor/Presidente"><?= e($v['presidente']) ?></td>
                    <td data-titulo="Observação"><?= e($v['observacao']) ?></td>
                    <td class="acoes">
                        <div>
                            <?php if (($v['exclusao'] == 'S') && (Aut::temPermissao(Aut::$modulos['MEMBROS'],
                                        \modelo\Permissao::REWRITE) || Aut::temPerfil(Aut::PERFIL_MASTER))): ?>
                                <a id="d_acao" class="excluir" title="Excluir dados"
                                   onclick="excluir(this,'<?= e($v['id']) ?>')"></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>