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
    <link rel="stylesheet" href="membro.css">
</head>
<body>
<htmlpageheader name="MyHeader1">
    <table class="header">
        <tr>
            <td width="1%"><img src="<?= RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/img/logo.png' ?>" height="80"
                                width="50"></td>
            <td width="99%">
                <?= e ($empresa->getNome ()) ?> - <?= e ($estado->getSigla ()) ?><br>
                <span class="menor">Endereços Membros</span>
            </td>
        </tr>
    </table>
</htmlpageheader>

<htmlpagefooter name="MyFooter1">
    <table width="100%">
        <tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right; "><?= e ($empresa->getNome ()) ?></td>
        </tr>
    </table>
</htmlpagefooter>

<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<sethtmlpagefooter name="MyFooter1" value="on"/>

<section class="corpo">
    <?php foreach ($retorno as $k => $v): ?>
        <?php if ($v['letra'] != $letra_inicial):
            $letra_inicial = $v['letra'];
            ?>
            <h1 class="subtitulo"><?= e ($letra_inicial) ?></h1>
        <?php endif; ?>
        <?php
        if ($v['logradouro'] != $end || $v['enderecos_numero'] != $num || $v['enderecos_complemento'] != $com):
            $end = $v['logradouro'];
            $num = $v['enderecos_numero'];
            $com = $v['enderecos_complemento'];
            $endereco = $letra_inicial . ' - ' . (($num != '') ? $end . ', ' . $num : $end) . (($v['cep'] != '') ? ', ' . $v['cep'] : '');
            ?>
            <h2><?= e ($endereco) ?></h2>
        <?php endif; ?>
        <p><?= e ($v['nome']) ?></p>
    <?php endforeach; ?>
</section>
</body>
</html>