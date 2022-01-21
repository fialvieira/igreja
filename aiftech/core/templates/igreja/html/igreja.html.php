<?php
/* @var $this \templates\Igreja */
?>
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
    <link rel="stylesheet" href="<?= SITE ?>core/templates/igreja/css/igreja.css?<?= $this->cssJs ?>">
    <?= $this->css ?>
</head>
<body>
<header>
    <a id="logo" href="<?= SITE ?>app/index.php"></a>
    <?php if (Aut::logado()): ?>
        <a id="hamburguer"></a>
    <?php endif; ?>
    <a id="mais"></a>
    <?php include RAIZ . 'core/templates/igreja/html/menu.html_1.php' ?>
    <div id="usuario">
        <?php if (Aut::logado()): ?>
            <a class="usuario"
               href="<?= SITE ?>app/cadastros/usuarios/usuario.php?codigo=<?= Aut::$usuario->getCodigo() ?>"><?= Aut::$usuario->getNome() ?></a>
            <a href="<?= SITE ?>app/login/logout.php">Sair</a>
        <?php else: ?>
            <a href="<?= SITE ?>app/login/index.php">Entrar</a>
        <?php endif; ?>
    </div>
</header>
<main>
    <?= $this->main ?>
</main>
<footer>
    © <?= date('Y') ?> by AIFTECH
</footer>
<div id="vidro-modal"></div>
<div id="vidro-flutuante"></div>
<div id="alerta" class="erro">
    <div></div>
    <a></a>
</div>
<script src="<?= SITE ?>core/js/core.js?<?= $this->cssJs ?>"></script>
<script src="<?= SITE ?>core/templates/igreja/js/igreja.js?<?= $this->cssJs ?>"></script>
<?= $this->js ?>
</body>
</html>