<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/png" sizes="64x64" href="<?= SITE ?>core/templates/igreja/img/favico.ico">
    <title><?= \Sistema::$nome ?></title>
    <link rel="stylesheet" href="matrimonios.css">
</head>
<body>
<htmlpageheader name="MyHeader1">
    <table class="header">
        <tr>
            <td width="1%"><img src="<?= RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/img/logo.png' ?>" height="80"
                                width="50"></td>
            <td width="99%">
                <?= e($empresa->getNome()) ?> - <?= e($estado->getSigla()) ?><br>
                <span class="menor">Aniversários de Casamento do Mês de <?=  e(mesPorExtenso($mes)) ?></span>
            </td>
        </tr>
    </table>
</htmlpageheader>

<htmlpagefooter name="MyFooter1">
    <table width="100%">
        <tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right; "><?= e($empresa->getNome()) ?></td>
        </tr>
    </table>
</htmlpagefooter>

<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<sethtmlpagefooter name="MyFooter1" value="on"/>

<section class="corpo">
    <!--<div class="subtitulo">Aniversários de Casamento do mês <?/*= e($mes_por_extenso) */?></div>-->
    <div class="tabela">
        <table>
            <thead>
            <tr>
                <th>Dt. Casamento</th>
                <th>Casal</th>
                <th>Tempo</th>
                <th>Bodas</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($aniversariantes as $k => $v): ?>
                <tr>
                    <td data-titulo="Data Casamento"><?= e($v['data_casamento']) ?></td>
                    <td data-titulo="Casal"><?= e($v["nome1"] . ' & ' . $v['nome2']) ?></td>
                    <td data-titulo="Tempo"><?= e($v['tempo']) ?></td>
                    <td data-titulo="Bodas">Bodas de <?= e($v['bodas']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>