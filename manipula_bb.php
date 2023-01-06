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

if(isset($_POST['vendedor']))
{
    $vendedor = $_POST['vendedor'];
}

if(isset($_POST['dia_inicial']))
{
    $dia_inicial = $_POST['dia_inicial'];
}

if(isset($_POST['dia_final']))
{
    $dia_final = $_POST['dia_final'];
}

if(isset($_POST['gera_parcela']))
{
    $gera_parcela = $_POST['gera_parcela'];
    $url = 'gerador_parcela_bb.php?data=' . $data . '&convenio=' . $convenio . '&' . 'optante=0'. '&vendedor=' . $vendedor . '&dia_inicial=' . $dia_inicial . '&dia_final=' . $dia_final;
    header("Location: $url");
}

elseif(isset($_POST['gera_arquivo_optante']))
{   
    $gera_arquivo_optante = $_POST['gera_arquivo_optante'];
    $url = 'gerador_layout_deb_bb.php?data=' . $data . '&convenio=' . $convenio . '&' . 'optante=1';
    header("Location: $url");
}

elseif(isset($_POST['gera_arquivo_debito']))
{
    $gera_arquivo_debito = $_POST['gera_arquivo_debito'];
    $url = 'gerador_layout_deb_bb.php?data=' . $data . '&convenio=' . $convenio . '&' . 'optante=0';
    header("Location: $url");

}



