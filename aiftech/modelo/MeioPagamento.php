<?php


namespace modelo;


class MeioPagamento
{
    const CARTAO = 1;
    const DINHEIRO = 2;
    const CHEQUE = 3;
    const BOLETO = 4;
    const PROMISSORIA = 5;
    const TRANSFERENCIA = 6;
    const DEPOSITO = 7;
    const MEIOS_PAGAMENTOS = [
        1 => 'Cartão',
        2 => 'Dinheiro',
        3 => 'Cheque',
        4 => 'Boleto',
        5 => 'Promissória',
        6 => 'Transferência',
        7 => 'Depósito'
    ];

    public function __construct($id = null)
    {
        if (!is_null($id)) {}
    }
}