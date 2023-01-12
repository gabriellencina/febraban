<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
      
    include('connection.php');
    
    $dia     = date('d',strtotime($_GET['data'])); 

    $data    = date('Ymd',strtotime(substr($_GET['data'],8,2).'-'.substr($_GET['data'],5,2).'-'.substr($_GET['data'],0,4)));
    
    $optante = $_GET['optante'];

    $convenio = $_GET['convenio'];
    
    if(isset($_GET['convenio']))
    {
        // Busca os dados do convenio
        $sql = "SELECT * , bancos.nome_banco, bancos.codigo_febraban, convenios_debito_em_conta.banco_id
                FROM convenios_debito_em_conta 
                INNER JOIN bancos
                ON bancos.id = convenios_debito_em_conta.banco_id	
                WHERE `cod_convenio` = ".$convenio;
        $res = $connection->query($sql);
        
        $row       = $res->fetch_object();
        $cod_banco = $row->codigo_febraban;
        $convenio  = $row->cod_convenio;
        
        if($cod_banco == 33)
        {
            // Gera parcelas
            while ($dia >= 1)
            {
                // Consulta negócio pelo dia da data informada, status e convênio
                $sql = "SELECT N.id AS negocio, 
                        N.dia_debito AS dia_debito, 
                        N.data_venda AS data_venda,
                        N.valor_total AS valor_total,
                        F.id AS forma_pgto, 
                        C.id AS convenio 
                        FROM `negocios` AS N
                        INNER JOIN forma_pagamento AS F ON N.forma_pagamento = F.id
                        INNER JOIN convenios_debito_em_conta AS C ON F.id = C.id
                        WHERE N.dia_debito = $dia AND N.status_negocio = 1 AND C.cod_convenio = '$convenio'";
                $res = $connection->query($sql);
                
                while($row = $res->fetch_object())
                {
                    $data_original = date('Ymd', strtotime($row->dia_debito. '-' .substr($_GET['data'],5,2). '-' . substr($_GET['data'],0,4)));
                                            
                    // Gera apenas parcelas aonde minha data original (dia + mês + ano) seja maior ou igual a minha data de venda de negócios, evitando cobrança retroativa 
                    if($data_original >= $row->data_venda)
                    { 
                        // Se possui meu negocio ele busca na data de vencimento informada
                        $sql  = "SELECT id FROM negocio_parcelas WHERE negocio_id = $row->negocio AND vencimento_original = '$data_original'";
                        $res2 = $connection->query($sql);

                        // Verifica se meu negocio possui parcela
                        if($res2->lengths == null) 
                        {
                            // Conta meu número de parcelas pelo meu negocio                    
                            $sql  = "SELECT COUNT(*) AS contador FROM negocio_parcelas WHERE negocio_id = $row->negocio";
                            $res3 = $connection->query($sql);

                            $row3 = $res3->fetch_object();

                            // Acrescenta sempre uma parcela pelo meu contador gerado a partir do negocio 
                            $numero_parcelas = $row3->contador;
                                                
                            // Geramos nossa parcela e inserimos os dados no banco
                            $sql  = "INSERT INTO negocio_parcelas (negocio_id, vencimento, valor, total, pagamento_parcelas, numero_parcela, vencimento_original, status)
                                     VALUES ($row->negocio, $data, $row->valor_total, $row->valor_total, 0, $numero_parcelas, $data_original, 1)";
                            $res4 = $connection->query($sql);
                                        
                        }
                    } 
                }

                $dia += -1;

            } 
        }
    }

     header("Location: index_santander.php");

?>
