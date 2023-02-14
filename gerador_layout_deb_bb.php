<?php 
	namespace febraban;

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include("vendor/autoload.php");
	include('connection.php');

    //Recebendo por parâmetro na url convenio, vencimento e optante
	$convenio   = $_GET['convenio'];

	$vencimento = date('Y-m-d',strtotime($_GET['data']));

    $vendedor 	= $_GET['vendedor'];

	$optante    = $_GET['optante'];

    function clearString($string = "")
    {   
	    $nova_string = $string;

        if($string) {
            $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ãª', 'ª', 'º');
            $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'E', 'a', 'o');
            $nova_string = str_replace($comAcentos, $semAcentos, $string);
            $nova_string = str_replace($comAcentos, $semAcentos, utf8_encode($nova_string));
        }

	    return $nova_string;
    }

    if(isset($_GET['convenio']))
    {
        // Busca os dados do convenio
	    $sql = "SELECT * , bancos.nome_banco, bancos.codigo_febraban, convenios_debito_em_conta.banco_id, convenios_debito_em_conta.id
                FROM convenios_debito_em_conta 
                INNER JOIN bancos
                ON bancos.id = convenios_debito_em_conta.banco_id	
                WHERE `cod_convenio` = " . $convenio;
        $res = $connection->query($sql);
        $row = $res->fetch_object();
 

        //Inicializa as variáveis
		$cod_banco = $row->codigo_febraban;
		$convenio  = $row->cod_convenio;	
        $contador_registros = 2;
        $numero_sequencial_arquivo  = $row->numero_sequencial_arquivo  + 1;

        switch($cod_banco)
        {
            case 1:
                // Adiciona 1 ao numero sequencial do arquivo e guarda no convenio 
				$sql = "UPDATE `convenios_debito_em_conta` SET `numero_sequencial_arquivo` = $numero_sequencial_arquivo  WHERE `cod_convenio` = ".$convenio;
				$res = $connection->query($sql);

                //REGISTRO A
                $RegistroA = array();
                $RegistroA["cod_registro"]                  = "A";
                $RegistroA["cod_remessa"]                   = 1;
                $RegistroA["cod_convenio"]                  = $convenio;
                $RegistroA["nome_destinataria"]             = $row->nome_empresa;
                $RegistroA["cod_depositaria"]               = $cod_banco;
                $RegistroA["nome_depositaria"]              = $row->nome_banco;
                $RegistroA["data_geracao"]                  = Date('Ymd');
                $RegistroA["numero_sequencial_arquivo"]     = $numero_sequencial_arquivo;
                $RegistroA["versao_layout"]                 = $row->versao_layout;
                $RegistroA["identificacao_servico"]         = $row->identificacao_servico;
                $RegistroA["reservado_futuro"]              = " ";

                $content  = '';
                
                $content .= bbDebAuto150Layout::RegistroA($RegistroA).PHP_EOL;

                $condicao = !empty($vendedor) ? "AND N.vendedor_id = $vendedor" :  " ";

                $condicao2 = !empty($optante) ? "AND N.optin_pendente = 1" : " ";

                //REGISTRO E
                // Busca as parcelas
                $sql = "SELECT negocio_parcelas.id as parcela,
                        negocio_parcelas.negocio_id,
                        negocio_parcelas.documento, 
                        negocio_parcelas.vencimento,   
                        negocio_parcelas.valor,   
                        negocio_parcelas.data_pagamento,  
                        negocio_parcelas.multa,  
                        negocio_parcelas.juros,
                        negocio_parcelas.total, 
                        negocio_parcelas.pagamento_parcelas,
                        negocio_parcelas.cod_retorno,  
                        negocio_parcelas.cod_retorno1,  
                        negocio_parcelas.cod_retorno2,  
                        negocio_parcelas.cod_retorno3,
                        negocio_parcelas.cod_retorno4,
                        negocio_parcelas.cod_retorno5,  
                        negocio_parcelas.numero_parcela,   
                        negocio_parcelas.numero_sequencial_arquivo_debito,
                        negocio_parcelas.numero_registro_e,  
                        negocio_parcelas.numero_agendamento_cliente,
                        negocio_parcelas.vencimento_original,
                        negocio_parcelas.valor_tarifa,
                        negocio_parcelas.status,
                        C.id,
                        C.endereco,
                        C.numero_endereco,
                        C.complemento_endereco,
                        C.bairro,
                        C.nome,
                        C.sobrenome,
                        C.cpf,
                        C.cep,
                        C.cidade,  
                        T.nome_cidade,
                        U.nome_uf,
                        V.cod_convenio,
                        F.dias_antecedencia_cobranca_debito,
                        D.agencia_bancaria,
                        D.conta_corrente,
                        V.mensagem_cliente,
                        V.codigo_carteira,
                        N.vendedor_id
                        FROM negocio_parcelas
                        INNER JOIN negocios as N ON N.id = negocio_id
                        INNER JOIN clientes as C ON N.cliente_id = C.id
                        INNER JOIN clientes_dados_debito as D ON N.conta_debito = D.id
                        LEFT JOIN cidades as T ON T.id = C.cidade
                        LEFT JOIN ufs as U ON U.id = T.uf_cidade
                        INNER JOIN forma_pagamento as F ON N.forma_pagamento = F.id
                        INNER JOIN convenios_debito_em_conta as V ON F.cod_convenio = V.id
                        WHERE negocio_parcelas.numero_registro_e = 0 AND negocio_parcelas.vencimento <= '$vencimento' 
                                                                     AND V.cod_convenio = $convenio 
                                                                     AND negocio_parcelas.status = 1
                                                                     $condicao $condição2";
			    $res3 = $connection->query($sql);
               
                
                $nome_arquivo_debito_conta = "DEB_".$cod_banco."_".$convenio."_".date('ymd')."_".str_pad($numero_sequencial_arquivo, 5 , '0' , STR_PAD_LEFT).".REM";
                
                $data_geracao_atual = date('Y-m-d');
            
			    $soma_valores = 0;

                // Insere os dados do nosso arquivo na tabela arquivos debito conta
			    $sql = "INSERT INTO arquivos_debito_conta (nome_arquivo, tipo_arquivo, data_criacao, convenio, numero_registros, arquivo_optante, numero_arquivo)
                        VALUES('$nome_arquivo_debito_conta', 'REM', '$data_geracao_atual', $convenio, $contador_registros, 0, $numero_sequencial_arquivo)";
                $res5 = $connection->query($sql);
    
                // Busca o id com base no nome do aquivo, data criação e convenio 
                $sql = "SELECT id FROM arquivos_debito_conta WHERE nome_arquivo = '$nome_arquivo_debito_conta' AND data_criacao = '$data_geracao_atual' AND convenio = '$convenio'";
                $res6 = $connection->query($sql);
                $row5 = $res6->fetch_object();
         
                while($row2 = $res3->fetch_object())
                {
                    if($optante == 0)
                    {
                        // Verifica se a data de vencimento é menor que a data passada no parâmetro, se sim, atualiza o vencimento para o parametro passado
                        if (str_replace('-', '', $row2->vencimento) < str_replace('-', '', $vencimento))
                        {
                            $data_vencimento = str_replace('-', '', $vencimento);
                        } else {
                            $data_vencimento = str_replace('-', '', $row2->vencimento);
                        }
            
                            $sql  = "UPDATE `negocio_parcelas` SET `numero_registro_e` = " . $contador_registros . ", vencimento = " . $data_vencimento . ",`numero_sequencial_arquivo_debito` = " . $numero_sequencial_arquivo . " WHERE `negocio_id` = " . $row2->negocio_id;
                            $res7 = $connection->query($sql);
                        
                            // Soma e Formata o valor da parcela
                            $soma_valores = $soma_valores + $row2->total;
                            $inteiro      = intval($row2->total);
                            $centavos     = substr(number_format($row2->total, 2, ',', '.'), strpos(number_format($row2->total, 2, ',', '.'), ',', 0) + 1, strlen(number_format($row2->total, 2, ',', '.')));

                            $formata_vencimento = date('dmy', strtotime($row2->vencimento));
                        
                        } else {

                            $data_vencimento = '99999999';
                            $soma_valores    = 0;
                            $inteiro         = 0;
                            $centavos        = '00';

                            $sql  = "UPDATE `negocio_parcelas` SET `numero_registro_e` = " . $contador_registros . ",`numero_sequencial_arquivo_debito` = " . $numero_sequencial_arquivo . " WHERE `negocio_id` = " . $row2->negocio_id;
                            $res8 = $connection->query($sql);
                        }

                    $limpa_campo_conta_corrente =   [
                                                        'A', 'a', 'B', 'b', 'C', 'c',
                                                        'D', 'd', 'E', 'e', 'F', 'f',
                                                        'G', 'g', 'H', 'h', 'I', 'i',
                                                        'J', 'j', 'K', 'k', 'L', 'l',
                                                        'M', 'm', 'N', 'n', 'O', 'o',
                                                        'P', 'p', 'Q', 'q', 'R', 'r',
                                                        'S', 's', 'T', 't', 'U', 'u',
                                                        'V', 'v', 'W', 'w', 'X', 'x',
                                                        'Y', 'y', 'Z', 'z'
                                                    ];

                    // Preenche array do Registro E
                    $RegistroE = array();
                    $RegistroE["cod_registro_e"]                = "E";
                    $RegistroE["id_cliente_destinataria"]       = 0 . $row2->cpf;
                    $RegistroE["agencia_debito"]                = $row2->agencia_bancaria;
                    $RegistroE["id_cliente_depositaria"]        = intval(str_replace($limpa_campo_conta_corrente, 0, $row2->conta_corrente));
                    $RegistroE["prazo_validade_contrato"]       = $data_vencimento;
                    $RegistroE["valor_debito"]                  = intval($inteiro.$centavos);
                    $RegistroE["cod_moeda"]                     = 03;
                    $RegistroE["uso_instituicao_destinataria"]  = $row2->parcela;
                    $RegistroE["uso_instituicao_destinataria2"] = "X"; 
                    $RegistroE["tipo_identificacao"]            = 2;
                    $RegistroE["identificacao"]                 = $row2->cpf;
                    $RegistroE["tipo_operacao"]                 = 3;
                    $RegistroE["utilizacao_cheque_especial"]    = 2;
                    $RegistroE["opcao_debito_parcial"]          = 2;
                    $RegistroE["reservado_futuro_E"]            = " ";

                    if($optante == 0) 
                    {
                        $RegistroE["cod_movimento"]        =  0;
                    } else {
                        $RegistroE["cod_movimento"]        =  5;
                    }
                
                    $contador_registros += +1;

                    $content .= bbDebAuto150Layout::RegistroE($RegistroE).PHP_EOL;

                    $sql = "INSERT INTO arquivos_debito_conta_retornos (data_ocorrencia, arquivo_debito_conta_id, negocio_parcela_id, registro, agencia, conta, cliente_id, status, cod_convenio, banco)
                            VALUES('$data_geracao_atual', $row5->id, $row2->parcela, $contador_registros, $row2->agencia_bancaria, $row2->conta_corrente, $row2->id, $row2->status, $row->id, $row->banco_id)";
                    $res9 = $connection->query($sql);
                }

                // atualiza meu numero de registros na tabela arquivos debito conta
			    $sql = "UPDATE arquivos_debito_conta 
                        SET numero_registros = '$contador_registros' 
                        WHERE nome_arquivo = '$nome_arquivo_debito_conta' AND data_criacao = '$data_geracao_atual' AND convenio = '$convenio'";
                $res10 = $connection->query($sql);

                // Registro Z, confere a somatoria dos Registros E
                $RegistroZ = array();
                $inteiro 										= intval($soma_valores);
                $centavos 										= substr(number_format($soma_valores, 2, ',', '.'), strpos(number_format($soma_valores, 2, ',', '.'),',',0)+1, strlen(number_format($soma_valores, 2, ',', '.')));
                $RegistroZ["cod_registro_z"]                    = "Z";
                $RegistroZ["total_registros_arquivo"]           =  $contador_registros;
                $RegistroZ["valor_total_registros_arquivo"]     = $inteiro.$centavos;
                $RegistroZ["reservado_futuro_Z"]                = " ";

                $content .= bbDebAuto150Layout::RegistroZ($RegistroZ).PHP_EOL;

                //Cria o arquivo
                $nome_arquivo = "DEB_".$cod_banco."_".$convenio."_".date('ymd')."_".str_pad($numero_sequencial_arquivo, 5 , '0' , STR_PAD_LEFT).".REM";
                $fp = fopen($_SERVER['DOCUMENT_ROOT'] ."/$nome_arquivo","wb");
                fwrite($fp,$content);
                fclose($fp);
                    
                header("Location: index_bb.php");

                break;

            default:
                    echo 'Layout não encontrado';
                 
                break;
        }
    }
