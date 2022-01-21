<?php

ini_set('error_reporting', E_ALL & ~E_NOTICE);
define('RAIZ', str_replace('\\', '/', __DIR__) . '/');
include RAIZ . 'core/funcoes.php';
spl_autoload_register('autoload');
header('Content-type: text/html; charset=utf-8');
session_name(basename(RAIZ));
session_start();
define('SERVIDOR', str_replace('www.', '', $_SERVER['HTTP_HOST']));
define('SITE', $_SERVER['REQUEST_SCHEME'] . '://' . str_replace('//', '/',
        $_SERVER['HTTP_HOST'] . '/' . str_replace($_SERVER['DOCUMENT_ROOT'] . '/', '', RAIZ) . '/'));
$confs = conf('localidade');
date_default_timezone_set($confs['SP']);
Sistema::ini();

$subdomain = (SERVIDOR != 'localhost') ? 'https://pibb.aiftech.com.br/projeto_igreja/aiftech/app/index.php' : $_SERVER['SERVER_NAME'];
$subdomain = str_replace(['https://', 'http://'], '', $subdomain);
$arr_subdomain = explode('.', $subdomain);
$subdomain = ($arr_subdomain[0] == 'www') ? $arr_subdomain[1] : $arr_subdomain[0];
$c = \bd\My::con();
$query = <<< SQL
          SELECT id
          FROM empresas
          WHERE subdomain = ?
SQL;
$com = $c->prepare($query);
$com->bind_param('s', $subdomain);
$com->execute();
$r = $com->get_result();
$l = $r->fetch_assoc();
define('EMPRESA', $l['id']);
Aut::ini();