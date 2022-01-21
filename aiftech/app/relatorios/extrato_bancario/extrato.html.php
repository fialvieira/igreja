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
        <link rel="stylesheet" href="extrato.css">
    </head>
    <body>
    <htmlpageheader name="MyHeader1">
        <table class="header">
            <tr>
                <td width="1%"><img src="<?= RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/img/logo.png' ?>" height="80"
                                    width="50"></td>
                <td width="99%">
                    <span class="menor">Extrato Bancário - <?= e($titulo) ?></span>
                </td>
            </tr>
        </table>
    </htmlpageheader>

    <htmlpagefooter name="MyFooter1">
        <table width="100%">
            <tr>
                <td width="50%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                <td width="50%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>

    <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
    <sethtmlpagefooter name="MyFooter1" value="on"/>

    <section class="corpo">
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <th class="" colspan="4"><?= e(strtoupper($retorno[0]['conta'])) ?></th>
                    </tr>
                    <tr>
                        <th class="">Data Movim.</th>
                        <th class="">Histórico</th>
                        <th class="direita">Valor</th>
                        <th class="direita">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($retorno): ?>
                        <?php foreach ($retorno as $ret): ?>
                            <?php
                            $class_valor = '';
                            $class_saldo = 'azul';
                            if ($ret["tipo"] == 'D') :
                                $class_valor = 'vermelho';
                            elseif ($ret["tipo"] == 'C') :
                                $class_valor = 'azul';
                            endif;
                            if ($ret["saldo"] < 0) :
                                $class_saldo = 'vermelho';
                            endif;
                            ?>
                            <tr>
                                <td data-titulo="Data Movim." class=""><?= e(bd\Formatos::dataApp($ret["data"])) ?></td>
                                <td data-titulo="Histórico" class=""><?= e($ret["descricao"]) ?></td>
                                <td data-titulo="Valor" class="direita <?= $class_valor ?>">
                                    <?= e(($ret["valor"] != '') ? \bd\Formatos::moeda($ret["valor"]) . ' ' . $ret["tipo"] : '') ?>
                                </td>
                                <td data-titulo="Saldo" class="direita negrito <?= $class_saldo ?>">
                                    <?= e(bd\Formatos::moeda($ret["saldo"])) ?> <?= ($ret["saldo"] > 0) ? 'C' : 'D' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?> 
                </tbody>
            </table>        
        </div>
    </section>
</body>
</html>