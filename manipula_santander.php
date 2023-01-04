<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

include('connection.php');

if(isset($_POST['data']))
{
    $data = $_POST['data'];
}

if(isset($_POST['convenio']))
{
    $convenio = $_POST['convenio'];
}

if(isset($_POST['gera_parcela']))
{
    $gera_parcela = $_POST['gera_parcela'];
    $url = 'gerador_parcela_santander.php?data=' . $data . '&convenio=' . $convenio . '&' . 'optante=0';
    header("Location: $url");
}

elseif(isset($_POST['gera_arquivo_optante']))
{   
    $gera_arquivo_optante = $_POST['gera_arquivo_optante'];
    $url = 'gerador_layout_deb_santander.php?data=' . $data . '&convenio=' . $convenio . '&' . 'optante=1';
    header("Location: $url");
}

elseif(isset($_POST['gera_arquivo_debito']))
{
    $gera_arquivo_debito = $_POST['gera_arquivo_debito'];
    $url = 'gerador_layout_deb_santander.php?data=' . $data . '&convenio=' . $convenio . '&' . 'optante=0';
    header("Location: $url");
}