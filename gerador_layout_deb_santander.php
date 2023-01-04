<?php 
	namespace febraban;
    
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include("vendor/autoload.php");
	include('connection.php'); 
    
    // Recebendo por parâmetro de url o cod do convenio, data de vencimento e se o cliente é optante
    $convenio   = $_GET['convenio'];

    $vencimento = date('Y-m-d',strtotime($_GET['data']));

    $optante    = $_GET['optante'];

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
        $numero_sequencial_arquivo = $row->numero_sequencial_arquivo  + 1;

        switch($cod_banco)
        {
            case 33:
                // Adiciona 1 ao numero sequencial do arquivo e guarda no convenio
                $sql = "UPDATE `convenios_debito_em_conta` SET `numero_sequencial_arquivo` = $numero_sequencial_arquivo  WHERE `cod_convenio` = ".$convenio;
				$res = $connection->query($sql);
             
			    //REGISTRO A
                $RegistroA = array(); 
                $RegistroA["cod_registro"]                  = "A"; 
                $RegistroA["cod_remessa"]                   = "1";
                $RegistroA["cod_convenio"]                  = $convenio;
                $RegistroA["nome_empresa"]                  = $row->nome_empresa;
                $RegistroA["cod_banco"]                     = $cod_banco;
                $RegistroA["nome_banco"]                    = $row->nome_banco;
                $RegistroA["data_geração_arquivo"]          = Date('Ymd');
                $RegistroA["numero_sequencial_arquivo"]     = $numero_sequencial_arquivo;
                $RegistroA["versao_layout"]                 = $row->versao_layout;
                $RegistroA["identificacao_servico"]         = $row->identificacao_servico;
                $RegistroA["reservado_futuro"]              = " ";
                
                $content  = '';
                
                $content .= santanderDebAuto150Layout::RegistroA($RegistroA).PHP_EOL;
                
                
                //REGISTRO E
				// Busca as Parcelas
				$condicao  = $optante == 1 ? "negocio_parcelas.numero_registro_e = 0 AND " : "";
				$condicao2 = $optante == 0 ? "clientes_dados_debito.optante = 0 AND " : "";

				$sql = "SELECT clientes.cpf, convenios_debito_em_conta.cod_convenio, forma_pagamento.dias_antecedencia_cobranca_debito, clientes_dados_debito.agencia_bancaria, clientes_dados_debito.optante , clientes_dados_debito.conta_corrente, negocio_parcelas.*  
                        FROM `negocio_parcelas`
                        INNER JOIN negocios ON negocios.id = negocio_id 
                        INNER JOIN clientes ON negocios.cliente_id = clientes.id
                        INNER JOIN forma_pagamento ON negocios.forma_pagamento = forma_pagamento.id
                        INNER JOIN convenios_debito_em_conta ON forma_pagamento.cod_convenio = convenios_debito_em_conta.id
                        INNER JOIN clientes_dados_debito ON negocios.conta_debito = clientes_dados_debito.id
				        WHERE $condicao $condicao2 negocio_parcelas.vencimento <= '$vencimento'"; 
				$res = $connection->query($sql);

				// Inicializa variáveis
				$RegistroE = array();
                $numero_sequencial_registroE = 0;
				$soma_valores = 0;

                while($row = $res->fetch_object())
                { 
                    // Atualiza o numero do registro E na parcela caso não esteja efetuando o cadastro
                    $numero_sequencial_registroE = $numero_sequencial_registroE + 1;

                    if($optante == 1)
                    {	
                        // Verifica se a data de vencimento é menor que a data passada no parâmetro, se sim, atualiza o vencimento para o parametro passado
                        if (str_replace('-', '', $row->vencimento) < str_replace('-', '', $vencimento))
                        {
                            $data_vencimento = str_replace('-', '', $vencimento);
                        } else {
                            $data_vencimento = str_replace('-', '', $row->vencimento);
                        }
                        
                        $sql  = "UPDATE `negocio_parcelas` SET `numero_registro_e` = ".$numero_sequencial_registroE.", vencimento = ".$data_vencimento." WHERE `id` = ".$row->id;
                        $res2 = $connection->query($sql);
                        
                        // Soma e Formata o valor da parcela
                        $soma_valores = $soma_valores + $row->total;
                        $inteiro      = intval($row->total);
                        $centavos     = substr(number_format($row->total, 2, ',', '.'), strpos(number_format($row->total, 2, ',', '.'),',',0)+1, strlen(number_format($row->total, 2, ',', '.')));
                        
                    } else {
                        $data_vencimento = '00000000';
                        $soma_valores    = 0;
                        $inteiro         = 0;
                        $centavos        = '00';
                    }
                    
                    // Preenche Array do Registro E
                    $RegistroE["cod_registro"]          = "E";
                    $RegistroE["id_cliente_empresa"]    = $row->cpf;
                    $RegistroE["agencia_debito"]        = $row->agencia_bancaria;
                    $RegistroE["id_cliente_banco"]      = intval($row->conta_corrente);
                    $RegistroE["data_vencimento"]       = $data_vencimento;
                    $RegistroE["valor_debito"]          = $inteiro.$centavos;
                    $RegistroE["codigo_moeda"]          = "03";
                    $RegistroE["uso_empresa"]           = " ";
                    $RegistroE["reservado_futuroE"]     = " ";
                    $RegistroE["codigo_movimento"]      = 0;
                    
                    $content .= santanderDebAuto150Layout::RegistroE($RegistroE).PHP_EOL;

                }

                // Registro Z, confere a somatoria dos Registros E
                    $RegistroZ = array();
                    $inteiro   = intval($soma_valores);
                    $centavos  = substr(number_format($soma_valores, 2, ',', '.'), strpos(number_format($soma_valores, 2, ',', '.'),',',0)+1, strlen(number_format($soma_valores, 2, ',', '.')));

                    $RegistroZ["cod_registro"]                  = "Z";
                    $RegistroZ["total_registros_arquivo"]       = $numero_sequencial_registroE + 2;
                    $RegistroZ["valor_total_registro_arquivo"]  = $inteiro.$centavos;
                    $RegistroZ["reservado_futuroZ"]             = " ";
                    
                    $content .= santanderDebAuto150Layout::RegistroZ($RegistroZ).PHP_EOL;

                    //Cria o arquivo
                    $nome_arquivo = "DEB_".$cod_banco."_".$convenio."_".date('ymd')."_".str_pad($numero_sequencial_arquivo, 5 , '0' , STR_PAD_LEFT).".REM";
                    $fp = fopen($_SERVER['DOCUMENT_ROOT'] ."/$nome_arquivo","wb");
                    fwrite($fp,$content);
                    fclose($fp);
                    
                    header("Location: index_santander.php");

                    break;

            default:
					echo 'Layout não encontrado';
					break;
        }
        	// Insere dados do arquivo debito em conta
			$sql = "INSERT INTO arquivos_debito_conta (nome_arquivo, tipo_arquivo, data_criacao, convenio, numero_registros, registros_falha, arquivo_optante, numero_arquivo) 
                    VALUES ('$nome_arquivo', 'REM', date('Y-m-d'), $convenio, $numero_sequencial_registroE, 0, $optante, $numero_sequencial_arquivo)";
            $res = $connection->query($sql);
    }
        

      

   



    