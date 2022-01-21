<?php

class Sistema
{
    /**
     * @var $nome string Faz alguma coisa legal.
     */
    public static $nome;
    public static $versao;
    public static $template;

    public static function ini()
    {
        $conf = conf('sistema');
        self::$nome = $conf['nome'];
        self::$versao = $conf['versao'];
        self::$template = $conf['template'];
    }

}