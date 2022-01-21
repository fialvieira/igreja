<?php
namespace templates;

class Igreja
{
    public static $arquivoErro = RAIZ . 'core/templates/igreja/html/erro.html.php';
    public $arquivo;
    public $cssJs;
    public $css;
    public $main;
    public $js;

    public function __construct()
    {
        $this->arquivo = RAIZ . 'core/templates/igreja/html/igreja.html.php';
        $this->cssJs = \Sistema::$versao;
    }

    public static function erro($e)
    {
        include self::$arquivoErro;
    }

    public function iniMain()
    {
        ob_start();
    }

    public function fimMain()
    {
        $this->main = ob_get_clean();
    }

    public function iniCss()
    {
        ob_start();
    }

    public function fimCss()
    {
        $this->css = ob_get_clean();
    }

    public function iniJs()
    {
        ob_start();
    }

    public function fimJs()
    {
        $this->js = ob_get_clean();
    }

    public function renderiza()
    {
        include $this->arquivo;
    }
}