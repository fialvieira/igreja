<?php $template = new \templates\Igreja() ?>

<?php $template->iniMain() ?>

<h1>Aviso!</h1>

<div class="erro">
    <?= e($e->getMessage()) ?>
</div>

<?php $template->fimMain() ?>

<?php $template->renderiza() ?>