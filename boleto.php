<!-- https://github.com/openboleto/openboleto -->
<?php

require("./boletos/openboleto-master\autoloader.php");

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;

$nome = $_GET['nome'];
$cpf = $_GET['cpf'];
$rua = $_GET['rua'];
$cep = $_GET['cep'];
$localidade =  $_GET['localidade'];
$uf = $_GET['uf'];

$sacado = new Agente($nome, $cpf, $rua, $cep, $localidade, $uf);
$cedente = new Agente('WeTube Corporation', '02.124.134/0001-12', 'CLS 404 Lk 28', '82000-000', 'São Paulo', 'SP');

$boleto = new Bradesco(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime('2021-12-20'),
    'valor' => 4.99,
    'sequencial' => 123456789, // Até 11 dígitos
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => 1010, // Até 4 dígitos
    'carteira' => 9, // 3, 6 ou 9
    'conta' => 0403005, // Até 7 dígitos

    // Parâmetros recomendáveis
    //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
    'contaDv' => 2,
    'agenciaDv' => 1,
    'carteiraDv' => 1,
    'descricaoDemonstrativo' => array( // Até 5
        'Compra de materiais cosméticos',
        'Compra de alicate',
    ),
    'instrucoes' => array( // Até 8
        'Após o dia 30/11 cobrar 2% de mora e 1% de juros ao dia.',
        'Não receber após o vencimento.',
    ),

    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'cip' => '000', // Apenas para o Bradesco
    //'moeda' => Bradesco::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    //'especieDoc' => 'ABC',
    //'numeroDocumento' => '123.456.789',
    //'usoBanco' => 'Uso banco',
    //'layout' => 'layout.phtml',
    //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
    //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
    //'descontosAbatimentos' => 123.12,
    //'moraMulta' => 123.12,
    //'outrasDeducoes' => 123.12,
    //'outrosAcrescimos' => 123.12,
    //'valorCobrado' => 123.12,
    //'valorUnitario' => 123.12,
    //'quantidade' => 1,
));

echo $boleto->getOutput();
