<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include('connection.php');

    // Pegando a data informada por parâmetro
    $data = $_GET['data'];
    
    $arruma_data = explode('-',$data);
        
    $dia         = $arruma_data[2];
    $mes         = $arruma_data[1];
    $ano         = $arruma_data[0];

    // Passando por parâmetro cod do convênio
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

        if($cod_banco == 1)
        {
            // Gera parcelas
            while($dia >= 1)
            {
                // Consulta negócio pelo dia da data informada, status e convênio
                $sql = "SELECT N.id AS negocio,
                        N.dia_debito AS dia_debito,
                        N.data_venda AS data_venda,
                        N.valor_total AS valor_total,
                        F.id AS forma_pgto,
                        C.id AS convenio,
                        B.id AS banco,
                        D.agencia_bancaria AS agencia_bancaria,
                        D.cod_operacao AS cod_operacao,
                        D.conta_corrente AS conta_corrente
                        FROM `negocios` AS N
                        INNER JOIN forma_pagamento AS F ON N.forma_pagamento = F.id
                        INNER JOIN convenios_debito_em_conta AS C ON F.cod_convenio = C.id
                        INNER JOIN clientes_dados_debito AS D ON D.cliente_id = N.cliente_id
                        INNER JOIN bancos AS B ON D.banco_id = B.id
                        WHERE N.dia_debito = $dia AND N.status_negocio = 1 AND C.cod_convenio = $convenio";
                $res2 = $connection->query($sql);               
            
                while($row2 = $res2->fetch_object())
                {   
                    $dia_data_original = $row2->dia_debito;
                    $data_original = date_create($ano . '-' . $mes. '-' . $dia_data_original);
                    $data_original = date_format($data_original, "Y-m-d");                
    
                    // Gera apenas parcelas aonde minha data original (dia + mês + ano) seja maior ou igual a minha data de venda de negócios, evitando cobrança retroativa 
                    if($data_original >= $row2->data_venda)
                    { 
                        // Se possui meu negocio ele busca na data de vencimento informada
                        $sql  = "SELECT id FROM negocio_parcelas WHERE negocio_id = $row2->negocio AND vencimento_original = '$data_original'";
                        $res3 = $connection->query($sql);

                        
                        $result = $res3->fetch_object();
                        
                    
                        // Verifica se meu negocio possui parcela
                        if(empty($result))
                        {
                            // Conta meu número de parcelas pelo meu negocio                    
                            $sql  = "SELECT COUNT(*) AS contador FROM negocio_parcelas WHERE negocio_id = $row2->negocio";
                            $res4 = $connection->query($sql);
                            
                            $row3 = $res4->fetch_object();
                            
                            // Acrescenta sempre uma parcela pelo meu contador gerado a partir do negocio 
                            $numero_parcelas = $row3->contador + 1;
                            
                            // Geramos nossa parcela e inserimos os dados no banco
                            $sql  = "INSERT INTO negocio_parcelas (negocio_id, vencimento, valor, total, numero_parcela, vencimento_original, agencia, banco, conta_corrente, status)
                                     VALUES ($row2->negocio, '$data', $row2->valor_total, $row2->valor_total, $numero_parcelas, '$data_original', 
                                    '$row2->agencia_bancaria', '$row2->banco', '$row2->conta_corrente', 1)";
                            $res4 = $connection->query($sql);
                            
                        }
                    }
                }
                
                $dia += -1;
            } 
        }
    }
    
    header("Location: index_bb.php");
    
    ?>